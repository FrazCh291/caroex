<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryItem extends Model

{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'order_id',
        'order_item_id',
        'delivery_id',
        'delivery_date',
        'delivery_method',
        'note',
        'status'
    ];
    // protected $with = ['orderItem'];


    protected $appends = ['start','end','title'];

    public function getTitleAttribute()
    {
        return 'Delivery('.$this->delivery_type.')';
    }

    public function getStartAttribute()
    {
        return $this->delivery_date;
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = $value;
    }

    public function getEndAttribute()
    {
        return $this->delivery_date;
    }

    public function setEndAttribute($value)
    {
        $this->attributes['start'] = $value;
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class,'order_item_id', 'id');
    }

    public function collection()
    {
        return $this->belongsTo(Returns::class);
    }

    public function returns()
    {
        return $this->belongsTo(Product::class,'order_item_id','id');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class,'delivery_id','id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }


}
