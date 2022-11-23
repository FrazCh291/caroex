<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lookup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    protected static function boot() {
        parent::boot();
        //lookupOrderBy is a name of scope. it is as arbitrary you can provide of your own
        static::addGlobalScope('lookupOrderBy', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }
}
