<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Address extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $softDelete = true;
    protected $fillable = [
        'company_id',
        'addressable_id',
        'addressable_type',
        'address_1',
        'address_2',
        'town',
        'city',
        'county',
        'postcode',
        'country',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

   
}
