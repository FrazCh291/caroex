<?php
return [
    'user' => env('PAYPAL_USER', ''),
    'password' => env('PAYPAL_PASSWORD', ''),
    'signature' => env('PAYPAL_SIGNATURE', ''),
    'client_id' => env('PAYPAL_CLIENT_ID', ''),
    'client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
    'method' => 'DoDirectPayment',
    'version' => '85.0',
    'action' => 'sale',
    'desc' => 'Testing Payments Pro',
    'currency_code' => 'USD',
];