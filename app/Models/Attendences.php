<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendences extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_id');
    }
   
}
