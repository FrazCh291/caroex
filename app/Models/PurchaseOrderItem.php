<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $softDelete = true;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function currencies()
    {
        return $this->belongsTo(Lookup::class, 'currency', 'slug');
    }

    public function lookup()
    {
        return $this->belongsTo(lookup::class, 'item_type' , 'slug');
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');

    }
}
