<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groupon extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'import_id',
        'company_id',
        'channel_id',
        'product_id',
        'fulfillment_line_item_id',
        'groupon_number',
        'order_date',
        'merchant_sku_item',
        'quantity_requested',
        'shipment_method_requested',
        'shipment_address_name',
        'shipment_address_street',
        'shipment_address_street_2',
        'shipment_address_city"',
        'shipment_address_postal_code',
        'shipment_address_country',
        'gift',
        'gift_message',
        'quantity_shipped',
        'shipment_carrier',
        'shipment_method',
        'shipment_tracking_number',
        'ship_date',
        'groupon_sku',
        'custom_field_value',
        'permalink',
        'item_name',
        'vendor_id',
        'salesforce_deal_option_id',
        'groupon_cost',
        'billing_address_name',
        'billing_address_street',
        'billing_address_city',
        'billing_address_stat',
        'billing_address_postal_code',
        'billing_address_country',
        'purchase_order_number',
        'product_weight',
        'product_weight_unit',
        'product_length',
        'product_height',
        'product_dimension_unit',
        'customer_phone',
        'incoterms',
        'hts_code',
        'pl_name',
        'pl_warehouse_location',
        'kitting_details',
        'sell_price',
        'deal_opportunity_id',
        'shipment_strategy"',
        'fulfillment_method',
        'country_of_origin',
        'merchant_permalink',
        'feature_start_date',
        'feature_end_date',
        'bom_sku'
    ];

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
