<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'payroll_id' ,'id');
    }
    public function payrollStatus()
    {
        return $this->belongsTo(Lookup::class, 'status', 'slug');
    }
}
