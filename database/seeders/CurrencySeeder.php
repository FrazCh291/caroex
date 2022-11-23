<?php

namespace Database\Seeders;

use App\Models\CurrencyExchange;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CurrencyExchange::updateOrCreate(['date' => '2021-12-01',  'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4555,
            'date' => '2021-12-01',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-01',  'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3278,
            'date' => '2021-12-01',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-02', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4376,
            'date' => '2021-12-02',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-02', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.33,
            'date' => '2021-12-02',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-03', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4416,
            'date' => '2021-12-03',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-03',  'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3233,
            'date' => '2021-12-03',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-04', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4416,
            'date' => '2021-12-04',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-04',   'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3239,
            'date' => '2021-12-04',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-05', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4394,
            'date' => '2021-12-05',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-05', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3235,
            'date' => '2021-12-05',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-06',  'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4564,
            'date' => '2021-12-06',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-06', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3262,
            'date' => '2021-12-06',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-07', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4335,
            'date' => '2021-12-07',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-07', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3246,
            'date' => '2021-12-07',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-08', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.3797,
            'date' => '2021-12-08',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-08', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3208,
            'date' => '2021-12-08',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-09', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4331,
            'date' => '2021-12-09',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-09', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3223,
            'date' => '2021-12-09',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-10', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' =>  8.4529,
            'date' => '2021-12-10',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-10', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.327,
            'date' => '2021-12-10',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-11', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4528,
            'date' => '2021-12-11',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-11', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.327,
            'date' => '2021-12-11',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-12', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' =>  8.4442,
            'date' => '2021-12-12',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-12', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3256,
            'date' => '2021-12-12',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-13', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' =>  8.4124,
            'date' => '2021-12-13',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-13', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3256,
            'date' => '2021-12-13',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-14', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' =>  8.4442,
            'date' => '2021-12-14',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-14', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3213,
            'date' => '2021-12-14',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-15', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4454,
            'date' => '2021-12-15',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-15', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3229,
            'date' => '2021-12-15',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-16',  'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4843,
            'date' => '2021-12-16',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-16', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3263,
            'date' => '2021-12-16',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-17', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4379,
            'date' => '2021-12-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-17', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3323,
            'date' => '2021-12-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-18', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4843,
            'date' => '2021-12-18',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-18', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3235,
            'date' => '2021-12-18',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-19', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4452,
            'date' => '2021-12-19',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-19', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3247,
            'date' => '2021-12-19',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-20', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4337,
            'date' => '2021-12-20',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-20', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3228,
            'date' => '2021-12-20',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-21', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.4624,
            'date' => '2021-12-21',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-21', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.321,
            'date' => '2021-12-21',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-22', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.5163,
            'date' => '2021-12-22',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-22', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3269,
            'date' => '2021-12-22',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-23', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.5481,
            'date' => '2021-12-23',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-23', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3406,
            'date' => '2021-12-23',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-24', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.5230,
            'date' => '2021-12-24',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-24', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3385,
            'date' => '2021-12-24',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-25', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.5246,
            'date' => '2021-12-25',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-25', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3387,
            'date' => '2021-12-25',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-26', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.5444,
            'date' => '2021-12-26',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-26', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3404,
            'date' => '2021-12-26',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-27', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.5687,
            'date' => '2021-12-27',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-27', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3278,
            'date' => '2021-12-27',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-28', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' =>  8.5615,
            'date' => '2021-12-28',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-28', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3278,
            'date' => '2021-12-28',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-29', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.5615,
            'date' => '2021-12-29',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-29', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3278,
            'date' => '2021-12-29',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-30', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.5615,
            'date' => '2021-12-30',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-30', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3442,
            'date' => '2021-12-30',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        CurrencyExchange::updateOrCreate(['date' => '2021-12-31', 'from_to' => 'GBP-CNY' , 'slug' => 'gbp-cny'], [
            'from_to' => 'GBP-CNY',
            'slug' => 'gbp-cny',
            'amount' => 8.5615,
            'date' => '2021-12-31',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        CurrencyExchange::updateOrCreate(['date' => '2021-12-31', 'from_to' => 'GBP-USD' ,  'slug' => 'gbp-usd'], [
            'from_to' => 'GBP-USD',
            'slug' => 'gbp-usd',
            'amount' => 1.3442,
            'date' => '2021-12-31',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
