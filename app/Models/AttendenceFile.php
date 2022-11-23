<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendenceFile extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function documents()
    {   
        return $this->morphMany(Documents::class, 'documentable');
    }
}
