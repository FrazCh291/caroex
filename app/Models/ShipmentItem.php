<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function shipments()
    {
        return $this->belongsTo(Shipment::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
   
}
