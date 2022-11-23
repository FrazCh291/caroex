<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'company_id',
        'aisle_id',
        'name',
        'code',
        'length',
        'width',
        'height',
        'volume',
        'max_weight',
        'is_occupied',
        'is_active',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    
    public function aisles()
    {
        return $this->belongsTo(Aisle::class);
    }

    public function levels()
    {
        return $this->hasMany(Level::class);
    }
}
