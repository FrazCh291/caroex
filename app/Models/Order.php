<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $with = ['channel', 'product', 'createdBy', 'updatedBy'];
    protected $fillable =
        ['channel_id',
            'customer_id',
            'company_id',
            'import_id',
            'vendor_id',
            'product_id',
            'saleforce_deal_option_id',
            'deal_id',
            'order_number',
            'order_date',
            'shipping_customer_name',
            'shipping_email',
            'shipping_address_1_2',
            'shipping_address_1',
            'shipping_address_2',
            'shipping_address_town',
            'shipping_city',
            'shipping_postcode',
            'shipping_address_postcode',
            'shipping_address_phone',
            'shipping_country',
            'shipping_phone',
            'product_option',
            'product_name',
            'sku',
            'birthday',
            'marketing_permalink',
            'dispatch_method',
            'order_status',
            'customer_note',
            'billing_customer_name',
            'billing_company',
            'house_number',
            'billing_address_1_2',
            'billing_address_1',
            'billing_address_2',
            'billing_city',
            'billing_postcode',
            'billing_country',
            'marketing_permission',
            'payment_method_type',
            'cart_discount_amount',
            'order_subtotal_amount',
            'order_shipping_amount',
            'order_refund_amount',
            'order_total_amount',
            'order_total_tax_amount',
            'item',
            'quantity',
            'item_code',
            'discount_amount',
            'discount_amount_tax',
            'merchant_sku_item',
            'gift',
            'git_message',
            'coupon_code',
            'quantity_request',
            'shipment_carrier',
            'shipment_tracking_number',
            'ship_date',
            'groupon_sku',
            'permalink',
            'product_weight',
            'product_weight_unit',
            'product_length',
            'product_height',
            'product_dimension_unit',
            'incoterms',
            'hts_code',
            'pl_name',
            'pl_warehouse_location',
            'kettting_details',
            'deal_opportunity_id',
            'shipping_strategy',
            'fulfillment_method',
            'country_of_origin',
            'merchant_permalink',
            'feature_start_date',
            'feature_end_date',
            'bom_sku',
            'created_by',
            'updated_by',
            'parcel_side_1'
        ];

    //  protected $casts = [
    //      'order_date' => 'datetime:d/m/Y',
    //  ];

    protected $appends = ['start', 'end', 'title'];

    public function getTitleAttribute()
    {
        return 'Order (' . $this->product_name . ')';
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    public function getStartAttribute()
    {
        return $this->order_date;
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = $value;
    }

    public function getEndAttribute()
    {
        return $this->order_date;
    }

    public function setEndAttribute($value)
    {
        $this->attributes['start'] = $value;
    }

    protected $appends1 = ['start', 'end', 'title'];

    public function getTitleAttributes()
    {
        return 'Delivery (' . $this->product_option . ')';
    }

    public function getStartAttributes()
    {
        return $this->order_date;
    }

    public function setStartAttributes($value)
    {
        $this->attributes['start'] = $value;
    }

    public function getEndAttributes()
    {
        return $this->order_date;
    }

    public function setEndAttributes($value)
    {
        $this->attributes['start'] = $value;
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function channel()
    {
        return $this->belongsTo(SalesChannel::class, 'channel_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function import()
    {
        return $this->belongsTo(Import::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    public function case()
    {
        return $this->hasOne(Cases::class);
    }
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }

}
