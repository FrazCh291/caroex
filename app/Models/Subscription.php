<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'package_id',
        'company_id ',
        'is_active',
        'auto_renew',
        'started_at',
        'end_at'
    ];

    public static function firstOrCreate(array $array, array $array1)
    {
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
