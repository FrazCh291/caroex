<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'filename',
        'company_id',
        'status',
        'deliverydate',
        'weight',
        'No_items',
        'date'
    ];
    // protected $casts = [
    //     'date' => 'date:d/m/Y'
    // ];

    protected $appends = ['start','end','title'];

    public function getTitleAttribute()
    {
        return 'Delivery ('.$this->status.')';
    }

    public function getStartAttribute()
    {
        return $this->deliverydate;
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = $value;
    }

    public function getEndAttribute()
    {
        return $this->deliverydate;
    }

    public function setEndAttribute($value)
    {
        $this->attributes['start'] = $value;
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
    public function deliveryItems()
    {

        return $this->hasMany(DeliveryItem::class, 'delivery_id', 'id');
    }
    public function documents()
    {
        return $this->morphMany(Documents::class, 'documentable');
    }
}
