<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    protected $guarded = [];
    use HasFactory;
    use SoftDeletes;

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
    public function documents()
    {
        return $this->morphMany(Documents::class, 'documentable');
    }
    public function account()
    {
        return $this->belongsTo(accounts::class, 'id', 'employee_id');
    }
    public function salaries()
    {
        return $this->hasMany(Salary::class, 'employee_id' ,'employee_id'); 
    }
    public function attendence() 
    {
        return $this->hasMany(Attendences::class, 'employee_number', 'employee_id');
    }
    public function adjustments()
    {
        return $this->hasMany(Adjustment::class, 'employee_id', 'id');
    }
}
