<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boomtekk extends Model
{
    use HasFactory;

    protected $table = 'boomtekks';
    protected $guarded = [];

    protected $fillable = [
        'company_id',
        'product_id',
        'import_id',
        'order_id',
        'invoice_number',
        'invoice_prefix',
        'store_id',
        'store_name',
        'store_url',
        'customer_id',
        'customer_group',
        'first_name',
        'last_name',
        'email',
        'telephone',
        'fax',
        'payment_first_name',
        'payment_last_name',
        'payment_company',
        'payment_address_1',
        'payment_address_2',
        'payment_city',
        'payment_postcode',
        'payment_country',
        'payment_country_id',
        'payment_zone',
        'payment_zone_id',
        'payment_address_format',
        'payment_method',
        'payment_code',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_company',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_postcode',
        'shipping_country',
        'shipping_country_id',
        'iso_code',
        'shipping_zone',
        'shipping_zone_id',
        'shipping_address_format',
        'shipping_method',
        'shipping_code',
        'comment',
        'total',
        'order_status_id',
        'affiliate_id',
        'commission',
        'language_id',
        'currency_id',
        'currency_code',
        'currency_value',
        'ip',
        'forwarded_ip',
        'user_agent',
        'accept_language'
    ];

}
