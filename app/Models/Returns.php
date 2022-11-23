<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Returns extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function case()
    {
        return $this->belongsTo(Cases::class,'case_id','id');
    }
    public function media()
    {
        return $this->hasMany(ReturnsMedia::class,'return_id' , 'id');
    }
    public function returnItem()
    {
        return $this->hasMany(ReturnItem::class,);
    }
    public function lookup()
    {
        return $this->belongsTo(Lookup::class, 'request_type', 'id');
    }
}
