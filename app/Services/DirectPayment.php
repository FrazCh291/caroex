<?php

namespace App\Services;

use App\Models\Payment;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

class DirectPayment
{
    protected $paypalConfig;
    protected $price;
    protected $data;

    /**
     * DirectPayment constructor.
     * @param array $data
     * @param float $price
     */
    public function __construct(array $data, float $price)
    {
        $this->paypalConfig = Config::get('paypal');
        $this->price = $price;
        $this->data = $data;
//        dd($this->paypalConfig,$this->price,$this->data);

    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public final function pay()
    {
        $requestParams = $this->getParams();
        $client = new Client();
        $result = $client->request('POST',
            'https://api-3t.sandbox.paypal.com/nvp',
            ['form_params' => $requestParams]);

        $payment = $this->stringToArray($result->getBody()->getContents());
        if ($payment['ACK'] == 'Success') {
            return $payment;
        }
        if ($payment['ACK'] == 'Failure') {
            ValidationException('error', 'Your payment was declined/fail.');
        } else {
            validationException('error', 'Something went wrong please try again letter.');
        }
    }

    /**
     * @param $NVPString
     * @return array
     */
    private function stringToArray($NVPString)
    {
        $proArray = array();
        while (strlen($NVPString)) {
            // key
            $keypos = strpos($NVPString, '=');
            $keyval = substr($NVPString, 0, $keypos);
            //value
            $valuepos = strpos($NVPString, '&') ? strpos($NVPString, '&') : strlen($NVPString);
            $valval = substr($NVPString, $keypos + 1, $valuepos - $keypos - 1);


            $proArray[$keyval] = urldecode($valval);
            $NVPString = substr($NVPString, $valuepos + 1, strlen($NVPString));
        }
        return $proArray;
    }

    /**
     * @return array
     */
    private function getParams()
    {
        $requestParams = array(
            'METHOD' => $this->paypalConfig['method'],
            'USER' => $this->paypalConfig['user'],
            'PWD' => $this->paypalConfig['password'],
            'SIGNATURE' => $this->paypalConfig['signature'],
            'VERSION' => $this->paypalConfig['version'],
            'PAYMENTACTION' => $this->paypalConfig['action'],
            'DESC' => $this->paypalConfig['desc'],
            'CURRENCYCODE' => $this->paypalConfig['currency_code'],
            'IPADDRESS' => strval($this->data['ip']),
            'CREDITCARDTYPE' => $this->data['card_type'],
            'ACCT' => strval($this->data['card_number']),
            'EXPDATE' => Str::replaceFirst("-", '', $this->data['expire']),
            'CVV2' => strval($this->data['cvv2']),
            'FIRSTNAME' => $this->data['first_name'],
            'LASTNAME' => $this->data['last_name'],
            'STREET' => $this->data['street'],
            'CITY' => $this->data['city'],
            'STATE' => $this->data['state'],
            'COUNTRYCODE' => $this->data['country'],
            'ZIP' => $this->data['zip'],
            'AMT' => strval($this->price),
        );

        return $requestParams;
    }

    /**
     * @param $details
     * @return Payment
     */
    public function storePayment($details)
    {

        $user = auth()->user();

        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->company_id = $user->company_id;
        $payment->package_id = $details['package_id'];
        $payment->correlation_id = $details['CORRELATIONID'];
        $payment->ack = $details['ACK'];
        $payment->version = intval($details['VERSION']);
        $payment->build = $details['BUILD'];
        $payment->amt = $details['AMT'];
        $payment->currency_code = $details['CURRENCYCODE'];
        $payment->avs_code = $details['AVSCODE'];
        $payment->cvv2_match = $details['CVV2MATCH'];
        $payment->transaction_id = $details['TRANSACTIONID'];
        $payment->card_crypt = Crypt::encryptString($user->first_name . ' ' . $user->last_name . ' ' . substr(strval($details['card_number']), 0, 5));
        $payment->timestamp = Carbon::parse($details['TIMESTAMP']);
        $payment->save();
        return $payment;
    }
}
