<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Building;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'company_id',
        'building_id',
        'name',
        'code',
        'length',
        'width',
        'height',
        'volume',
        'is_active',
        'is_occupied',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    
    public function buildings()
    {
        return $this->belongsTo(Building::class);
    }

    public function aisles()
    {
        return $this->hasMany(Aisle::class);
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
