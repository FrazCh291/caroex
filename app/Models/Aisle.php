<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aisle extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'id',
        'company_id',
        'section_id',
        'name',
        'code',
        'length',
        'width',
        'height',
        'volume',
        'is_occupied',
        'is_active',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function sections()
    {
        return $this->belongsTo(Section::class);
    }

    public function bays()
    {
        return $this->hasMany(Bay::class);
    }
}
