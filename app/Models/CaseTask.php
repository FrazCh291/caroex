<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseTask extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function case_types()
    {
        return $this->belongsTo(Lookup::class, 'case_type', 'slug');
    }
    public function usertask()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
