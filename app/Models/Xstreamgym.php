<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Xstreamgym extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "company_id",
        "import_id",
        "product_id",
        "order_number",
        "order_status",
        "order_date",
        "customer_note",
        "billing_first_name",
        "billing_last_name",
        "billing_company",
        "billing_address_1_2",
        "billing_city",
        "billing_state_code",
        "billing_postcode",
        "billing_country_code",
        "billing_email",
        "billing_phone",
        "shipping_first_name",
        "shipping_last_name",
        "shipping_address_1_2",
        "shipping_city",
        "shipping_state_code",
        "shipping_postcode",
        "shipping_country_code",
        "payment_method_title",
        "cart_discount_amount",
        "order_subtotal_amount",
        "shipping_method_title",
        "order_shipping_amount",
        "order_refund_amount",
        "order_total_amount",
        "order_total_tax_amount",
        "sku",
        "item",
        "item_name",
        "quantity",
        "item_cost",
        "coupon_code",
        "discount_amount",
        "discount_amount_tax",
    ];

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
