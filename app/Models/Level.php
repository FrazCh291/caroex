<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'company_id',
        'bay_id',
        'name',
        'code',
        'length',
        'width',
        'height',
        'volume',
        'max_weight',
        'is_occupied',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    public function bays()
    {
        return $this->belongsTo(Bay::class);
    }

    public function bins()
    {
        return $this->hasMany(Bin::class);
    }
}
