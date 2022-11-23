<?php

namespace App\Services;

use App\Models\Card;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RenewSubscription
{


    public function __construct()
    {
    }

    public function renewPackageSubscription($subID)
    {
        DB::transaction(function () use ($subID) {
            $sub = Subscription::where('id', $subID)->first();
            $package = Package::find($sub->package_id);
            $card = Card::where('user_id', $sub->user_id)->first()->toArray();
            $payment = new DirectPayment($card, $package->price);
            $data = $payment->pay();
            $data['card_number'] = strval($card['card_number']);
            $data['package_id'] = $package->id;
            $payment->storePayment($data);
            Subscription::where('id', $subID)->update(['is_active' => 1, 'end_at' => Carbon::now()->addDays($package->duration)]);

            $card = new Card();
            $card->user_id = Auth::user()->id;
            $card->first_name = 'fsdf';
            $card->last_name = 'ds';
            $card->card_type = 'visa';
            $card->card_number = 'sadas121';
            $card->expire = '08-2025';
            $card->cvv2 = '123';
            $card->street = '2 Main St';
            $card->city = 'San Jose';
            $card->state = 'CA';
            $card->zip = '6786';
            $card->country = 'US';
            $card->save();
        });
    }
}
