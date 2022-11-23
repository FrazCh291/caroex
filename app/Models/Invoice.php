<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function invoiceable()
    {
        return $this->morphTo();
    }

    public function addresses()
    {
        return $this->belongsTo(Address::class, 'ship_from_address_id', 'id');
    }

    public function statuss()
    {
        return $this->belongsTo(Lookup::class, 'status', 'slug');
    }

    public function addressess()
    {
        return $this->belongsTo(Address::class, 'ship_to_address_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'supplier_id', 'id');
    }

    public function suppliers()
    {
        return $this->belongsTo(SalesChannel::class, 'supplier_id', 'id');
    }

    public function shipment()
    {
        return $this->belongsTo(Shippment::class, 'invoiceable_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Company::class, 'customer_id', 'id');
    }
    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function purchaseOrders()
    {
        return $this->morphedByMany(PurchaseOrder::class, 'invoiceable');
    }

    public function documents()
    {
        return $this->morphMany(Documents::class, 'documentable');
    }

    public function payments()
    {
        return $this->hasMany(CompanyPayment::class);
    }

    public function getCurrencyAttribute($value)
    {
        return strtoupper($value);
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
