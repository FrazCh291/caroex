<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesChannel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function feedbacks(): HasMany {
        return $this->hasMany(Feedback::class);
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
