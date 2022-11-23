<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bin extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'company_id',
        'level_id',
        'name',
        'code',
        'length',
        'width',
        'height',
        'volume',
        'is_occupied',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    
    public function levels()
    {
        return $this->belongsTo(Level::class);
    }
}
