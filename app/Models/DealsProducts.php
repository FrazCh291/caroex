<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealsProducts extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dealProductsRates()
    {
        return $this->hasMany(DealsProductsRates::class, 'deal_product_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

}
