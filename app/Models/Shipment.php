<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $softDelete = true;
    protected $guarded = [];

    protected $appends = ['start','end','title'];

    public function getTitleAttribute()
    {
        return 'shipment ('.$this->container_number.')';
    }

    public function getStartAttribute()
    {
        return $this->expected_container_delivery_date;
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = $value;
    }

    public function getEndAttribute()
    {
        return $this->expected_container_delivery_date;
    }

    public function setEndAttribute($value)
    {
        $this->attributes['start'] = $value;
    }

    public function mainCompany()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'supplier_id', 'id');
    }

    public function supplierFreightForwarder()
    {
        return $this->belongsTo(Company::class, 'supplier_freight_forwarder_id', 'id');
    }
    public function purchaserFreightForwarder()
    {
        return $this->belongsTo(Company::class, 'purchaser_freight_forwarder_id', 'id');
    }
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Company::class, 'warehouse_id', 'id');
    }

    public function shipmentItems()
    {
        return $this->hasMany(ShipmentItem::class, 'shipment_id', 'id');
    }

    public function documents()
    {
        return $this->morphMany(Documents::class, 'documentable');
    }
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

}
