<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Documents extends Model
{
    use HasFactory;
    // use SoftDeletes;

    // protected $softDelete = true;

    protected $guarded = [];

    public function documentable()
    {
        return $this->morphTo();
    }
    public function user(){

       return $this->belongsTo(User::class, 'user_id' , 'id');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
    public function customer()
    {
        return $this->morphMany(Customer::class, 'documentable');
    }
}
