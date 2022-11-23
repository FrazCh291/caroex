<?php


namespace App\Services\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

trait DefaultActiveLog
{
    public function defaultLog($request)
    {
        $activityLog = new ActivityLog();
        $activityLog->company_id = $request['company_id'];
        $activityLog->user_id = $request['user_id'];
        $activityLog->logable_type  = $request['module'];
        $activityLog->activity  = $request['activity'];
        $activityLog->type  = $request['type'];
        $activityLog->path  = $request['path'];
        $activityLog->save();

        return Redirect::back();
    }
}
