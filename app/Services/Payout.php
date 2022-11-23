<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class Payout
{
    protected $paypalConfig;
    protected $user;
    protected $price;

    /**
     * Payout constructor.
     * @param $user
     * @param $price
     */
    public function __construct($user, $price)
    {
        $this->paypalConfig = Config::get('paypal');
        $this->user = $user;
        $this->price = $price;
    }

    public function payout()
    {
        $token = Http::withHeaders([
            'Accept' => 'application/json',
            'Accept-Language' => 'en_US',
        ])->withBasicAuth($this->paypalConfig['client_id'], $this->paypalConfig['client_secret'])->asForm()
            ->post('https://api.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);
        $accessToken = 'Bearer ' . $token['access_token'];
        $requestParams = [
            'sender_batch_header' => [
                "sender_batch_id" => $this->user->first_name . '_' . $this->user->last_name . '_' . now()->getTimestamp(),
                "email_subject" => "You have a payout!",
                "email_message" => "You have received a payout you withdraw " . $this->user->account->balacne . " form your Xstream Gym account. Thanks for using Xstream!"
            ],
            'items' => [
                [
                    "recipient_type" => "EMAIL",
                    "amount" => [
                        "value" => $this->price,
                        "currency" => $this->paypalConfig['currency_code']
                    ],
                    "note" => "Thanks for your patronage!",
                    "sender_item_id" => $this->user->id . '' . $this->user->email,
                    "receiver" => $this->user->email,
                ]
            ]
        ];
        $result = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $accessToken
        ])->post('https://api.sandbox.paypal.com/v1/payments/payouts', $requestParams);

        return $result->json();
    }
}

