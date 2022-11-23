<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'quantity',
        'product_id',
        'product_name',
        'item_cost',
        'coupon_code',
        'discount_amount',
        'discount_amount_tax',
        'created_by',
        'order_date',
        'updated_by',
        'deal_product_rate_id',
        'return_status'
    ];

    protected $with = [
        'order',
        'product'
    ];

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    public function order()
    {

        return $this->belongsTo(Order::class);
    }

    public function product()
    {

        return $this->belongsTo(Product::class);
    }

    public function dealProductRate()
    {

        return $this->belongsTo(DealsProductsRates::class,'deal_product_rate_id', 'id');
    }
}
