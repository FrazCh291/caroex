<?php

namespace App\Services\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

trait Logger
{
    public function log($request)
    {
        $Module = $request['module'];
        return $Module->logs()->create([
            'company_id' => $request['company_id'],
            'user_id' => $request['user_id'],
            'activity' => $request['activity'],
            'type' => $request['type'],
            'path' => $request['path'],
        ]);
    }
}
