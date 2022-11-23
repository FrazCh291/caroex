<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'payroll_id',
        'company_id',
        'gross',
        'currency',
        'total_detuction',
        'tax',
        'total_addition',
        'net_total',
        'status',
        

    ];
    // protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id' ,'id');
    } 
    public function payroll()
    {
        return $this->belongsTo(Payroll::class, 'payroll_id' ,'id');
    }
    public function adjustments()
    {
        return $this->hasMany(Adjustment::class, 'salary_id', 'id');
    }
}
