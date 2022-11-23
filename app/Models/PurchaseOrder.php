<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $softDelete = true;
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'supplier_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Company::class, 'customer_id', 'id');
    }

    public function purchaseOrderItem()
    {
        return $this->hasMany(PurchaseOrderItem::class)->whereNotNull('product_id');
    }

    public function currency()
    {
        return $this->belongsTo(CurrencyExchange::class, 'currency', 'id');
    }

    public function invoiceable()
    {
        return $this->morphMany(Invoiceable::class, 'invoiceable');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    public function getCurrencyAttribute($value)
    {
        return strtoupper($value);
    }

    public function getTotalAttribute($value)
    {
        return number_format($value);
    }
}
