<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\BillplzGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BillplzController extends Controller
{
    protected $billplzGateway;

    public function __construct(BillplzGateway $billplzGateway)
    {
        $this->billplzGateway = $billplzGateway;
    }

    public function redirect(Order $order)
    {
        if ($order->status === 'canceled') {
            abort(404);
        }

        if ($order->status === 'completed') {
            return redirect()->route('order.completed', $order->order_id);
        }

        $paymentUrl = $this->billplzGateway->preparePayment($order);

        if ($paymentUrl) {
            return redirect()->away($paymentUrl);
        }

        return redirect()->route('order.failed', $order->order_id)->with('error', 'Unable to process payment.');
    }

    public function return(Request $request)
    {
        try {
            $billplzId = $request->input('billplz.id');
            $billplzPaidStatus = $request->input('billplz.paid');

            $payment = Payment::where('billplz_bill_id', $billplzId)->firstOrFail();
            $order = $payment->order;

            if ($billplzPaidStatus === 'true') {
                $order->update(['status' => 'completed']);
                $payment->update([
                    'status' => 'paid',
                ]);
                return redirect()->route('order.completed', $order->order_id)->with('success', 'Payment successful.');
            }

            $order->update(['status' => 'failed']);
            $payment->update([
                'status' => 'failed',
            ]);
            return redirect()->route('order.failed', $order->order_id)->with('error', 'Payment was unsuccessful.');
        } catch (\Exception $e) {
            return redirect()->route('pizza.index')->with('error', 'An error occurred while processing your payment.');
        }
    }

    public function callback(Request $request)
    {
        $xSignature = $request->header('X-Signature');

        if (!$xSignature || !$this->billplzGateway->validateXSignature($xSignature, $request->all())) {
            Log::error('Billplz X-Signature validation failed.');
            return response('Forbidden', 403);
        }

        $orderId = $request->input('reference_1');
        $order = Order::where('order_id', $orderId)->firstOrFail();
        $billplzId = $request->input('id');
        $paidStatus = $request->input('paid');

        if ($paidStatus === 'true') {
            $order->update(['status' => 'completed']);
            $order->payment->update([
                'status' => 'paid',
                'billplz_bill_id' => $billplzId,
            ]);
        } else {
            $order->update(['status' => 'failed']);
            $order->payment->update([
                'status' => 'failed',
                'billplz_bill_id' => $billplzId,
            ]);
        }

        return response('OK', 200);
    }
}
