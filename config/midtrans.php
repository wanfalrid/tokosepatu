<?php

return [
    'serverKey' => env('MIDTRANS_SERVER_KEY', 'Your-Midtrans-Server-Key'),
    'clientKey' => env('MIDTRANS_CLIENT_KEY', 'Your-Midtrans-Client-Key'),
    'isProduction' => false, // false = sandbox mode
    'isSanitized' => true,
    'is3ds' => true,
];