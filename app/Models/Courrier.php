<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courrier extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function warehousebuilding()
    {
        return $this->belongsTo(Building::class,'warehouseBuilding_id','id');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
