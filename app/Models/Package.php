<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'is_one_time',
        'duration',
        'number_of_user',
        'status'
    ];

    public static function find(string $string)
    {
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_package');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
