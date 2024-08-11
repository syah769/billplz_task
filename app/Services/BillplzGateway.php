<?php

namespace App\Services;

use App\Models\Order;
use App\Traits\BillplzGatewayTrait;
use Illuminate\Support\Facades\Log;

class BillplzGateway
{
    use BillplzGatewayTrait;

    public function __construct()
    {
        $this->baseUrl = config('services.billplz.sandbox') ? self::DEV_URL : self::PROD_URL;
        $this->apiKey = config('services.billplz.api_key');
        $this->collectionId = config('services.billplz.collection_id');
        $this->xsignatureKey = config('services.billplz.xsignature_key');

        Log::info('BillplzGateway Configuration', [
            'baseUrl' => $this->baseUrl,
            'apiKey' => $this->apiKey,
            'collectionId' => $this->collectionId,
            'xsignatureKey' => $this->xsignatureKey,
        ]);
    }

    public function preparePayment(Order $order): ?string
    {
        $billData = [
            'collection_id' => $this->collectionId,
            'email' => $order->user->email,
            'name' => $order->customer_name,
            'amount' => $order->total_amount * 100,
            'description' => "Pizza Order #{$order->id}",
            'callback_url' => route('billplz.callback'),
            'redirect_url' => route('billplz.return'),
            'reference_1_label' => 'Order ID',
            'reference_1' => $order->order_id,
        ];

        Log::info('Preparing Billplz payment', $billData);

        $response = $this->createBill($billData);

        Log::info('Billplz response', $response ?? ['error' => 'No response']);

        if ($response && isset($response['id'])) {
            $order->payment()->create([
                'billplz_bill_id' => $response['id'],
                'status' => 'pending',
                'amount' => $order->total_amount,
            ]);
            return $this->billUrl($response['id']);
        }

        return null;
    }

    public function processPayment(array $data): ?Order
    {
        if (!isset($data['id']) || !isset($data['paid'])) {
            return null;
        }

        $order = Order::where('billplz_bill_id', $data['id'])->first();

        if (!$order) {
            return null;
        }

        $billDetails = $this->getBill($data['id']);

        if ($billDetails === null) {
            return null;
        }

        if ($data['paid'] === 'true') {
            if ($billDetails['amount'] === $order->total_amount * 100) {
                $order->update([
                    'status' => 'completed',
                    'payment_status' => 'paid',
                ]);
            } else {
                $order->update([
                    'status' => 'failed',
                    'payment_status' => 'failed',
                ]);
            }
        } else {
            $order->update([
                'status' => 'failed',
                'payment_status' => 'failed',
            ]);
        }

        return $order;
    }
}
