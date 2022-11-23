<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deal extends Model
{
    protected $guarded = [];
    use HasFactory;
    // use SoftDeletes;

    protected $appends = [
        'order_count',

    ];

//    public function product()
//    {
//        return $this->belongsTo(Product::class);
//    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'deal_id', 'deal_number');
    }

    public function documents()
    {
        return $this->morphMany(Documents::class, 'documentable');
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }

    public function getOrderCountAttribute()
    {
        return $this->orders()->count();
    }

    public function statuss()
    {
        return $this->belongsTo(Lookup::class, 'status', 'slug');
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    public function dealProducts()
    {
        return $this->hasMany(DealsProducts::class, 'deal_id', 'id');
    }

    public function dealProductRates()
    {
        return $this->hasManyThrough( DealsProductsRates::class, DealsProducts::class , 'deal_id', 'deal_product_id');
    }
}
