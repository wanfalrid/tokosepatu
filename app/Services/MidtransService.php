<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.serverKey');
        Config::$clientKey = config('midtrans.clientKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');
    }    public function createSnapToken($order)
    {
        // Debug: Log the order data
        Log::info('Creating Midtrans snap token with data:', $order);
        
        $params = [
            'transaction_details' => [
                'order_id' => $order['order_id'],
                'gross_amount' => (int) $order['total_amount'], // Ensure it's integer
            ],
            'customer_details' => [
                'first_name' => $order['customer']['first_name'],
                'last_name' => $order['customer']['last_name'] ?? '',
                'email' => $order['customer']['email'],
                'phone' => $order['customer']['phone'],
                'billing_address' => [
                    'first_name' => $order['customer']['first_name'],
                    'last_name' => $order['customer']['last_name'] ?? '',
                    'email' => $order['customer']['email'],
                    'phone' => $order['customer']['phone'],
                    'address' => $order['customer']['address'],
                ],
                'shipping_address' => [
                    'first_name' => $order['customer']['first_name'],
                    'last_name' => $order['customer']['last_name'] ?? '',
                    'email' => $order['customer']['email'],
                    'phone' => $order['customer']['phone'],
                    'address' => $order['customer']['address'],
                ]
            ],
            'item_details' => $order['items'],
        ];
        
        // Debug: Log the params being sent to Midtrans
        Log::info('Midtrans params:', $params);

        try {
            $snapToken = Snap::getSnapToken($params);
            Log::info('Snap token created successfully: ' . $snapToken);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans error: ' . $e->getMessage());
            Log::error('Midtrans error trace: ' . $e->getTraceAsString());
            throw new \Exception('Error creating snap token: ' . $e->getMessage());
        }
    }

    public function getClientKey()
    {
        return config('midtrans.clientKey');
    }
}