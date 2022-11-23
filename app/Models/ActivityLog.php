<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function logable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function cases()
    {
        return $this->belongsTo(Cases::class, 'logable_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'logable_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'logable_id', 'id');
    }

    public function import()
    {
        return $this->belongsTo(Import::class, 'logable_id', 'id');
    }

    public function email()
    {
        return $this->belongsTo(Email::class, 'logable_id', 'id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'logable_id', 'id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'logable_id', 'id');
    }

    public function activityLogDetail()
    {
        return $this->hasMany(ActivityLogsDetails::class,'activity_log_id', 'id');
    }    
}
