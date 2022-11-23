<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amazon extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

//    protected $fillable = [
//        'product_id',
//        'import_id',
//        'order_id',
//        'company_id',
//        'order_status',
//        'order_date',
//        'customer_note',
//        'customer_name',
//        'company_billing',
//        'city_billing',
//        'state_code_billing',
//        'state_code_billing',
//        'country_code_billing',
//        'email_billing',
//        'phone_billing',
//        'shipping_customer_name',
//        'postal_address_4',
//        'shipping_postal_address',
//        'city_shipping',
//        'state_code_shipping',
//        'postcode_shipping',
//        'country_code_shipping',
//        'payment_method_title',
//        'cart_discount_amount',
//        'order_subtotal_amount',
//        'shipping_method_title',
//        'order_shipping_amount',
//        'order_refund_amount',
//        'order_total_amount',
//        'order_total_tax_amount',
//
//        'sku',
//        'item',
//        'item_name',
//        'quantity',
//        'item_cost',
//        'coupon_code',
//        'discount_amount',
//        'discount_amount_tax',
//        'asin',
//        'item_cost',
//        'item_cost',
//        'item_cost',
//        'order_item_id',
//        'dispatch_date',
//        'reason_for_late_dispatch',
//        'postal_address_1',
//        'postal_address_2',
//        'postal_address_3',
//        'post_code',
//        'freight_company',
//        'tracking_number',
//
//    ];

    public function import()
    {
        return $this->belongsTo(import::class);
    }
}
