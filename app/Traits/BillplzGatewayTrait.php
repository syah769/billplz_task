<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait BillplzGatewayTrait
{
    public const DEV_URL = 'https://www.billplz-sandbox.com';
    public const PROD_URL = 'https://www.billplz.com';

    protected string $baseUrl;
    protected string $apiKey;
    protected string $collectionId;
    protected string $xsignatureKey;

    public function createBill(array $data): ?array
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->post($this->baseUrl . '/api/v3/bills', $data);

            return $response->json();
        } catch (Exception $e) {
            Log::error('Billplz Error', [
                'data' => $data,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function getBill(string $billId): ?array
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->get($this->baseUrl . '/api/v3/bills/' . $billId);

            return $response->json();
        } catch (Exception $e) {
            Log::error('Billplz Error', [
                'billId' => $billId,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function billUrl(string $billId): string
    {
        return $this->baseUrl . '/bills/' . $billId;
    }

    public function validateXSignature(string $receivedSignature, array $data): bool
    {
        $sourceString = $this->buildSourceString($data);
        $calculatedSignature = hash_hmac('sha256', $sourceString, $this->xsignatureKey);

        return hash_equals($calculatedSignature, $receivedSignature);
    }

    protected function buildSourceString(array $data, string $prefix = ''): string
    {
        uksort($data, function ($a, $b) {
            $a_len = strlen($a);
            $b_len = strlen($b);

            $result = strncasecmp($a, $b, min($a_len, $b_len));

            if ($result === 0) {
                $result = $b_len - $a_len;
            }

            return $result;
        });

        $processed = [];

        foreach ($data as $key => $value) {
            if ($key === 'x_signature') {
                continue;
            }

            if (is_array($value)) {
                $processed[] = $this->buildSourceString($value, $key);
            } else {
                $processed[] = $prefix . $key . $value;
            }
        }

        return implode('|', $processed);
    }
}
