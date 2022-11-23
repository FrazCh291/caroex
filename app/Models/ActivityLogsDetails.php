<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogsDetails extends Model
{
    use HasFactory;

    public function activitiesLog()
    {
        return $this->belongsTo(ActivityLog::class, 'activity_log_id', 'id');
    }
}
