<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DealsProductsRates extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id', 'id');
    // }

    protected $appends = ['product_name'];

    public function dealProduct()
    {
        return $this->belongsTo(DealsProducts::class, 'deal_product_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'deal_product_rate_id', 'id');
    }

    public function getProductNameAttribute()
    {
        $dealPproduct = $this->dealProduct()->first();
        $product = $dealPproduct ? $dealPproduct->product()->first() : '';
        return $product;
//        return $this->dealProduct()->first()->product()->first()->name;
    }

    public function documents()
    {
        return $this->morphMany(Documents::class, 'documentable');
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
