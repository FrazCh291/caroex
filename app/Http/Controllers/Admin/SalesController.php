<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;

class SalesController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',SalesChannel::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\SalesChannels',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $channel = SalesChannel::query();
        $channel = $request->get('enable') ? $channel->where('status', 1) : $channel;
        $channel = $request->get('disable') ? $channel->orWhere('status', 0) : $channel;
        
        $channel = $this->search($channel, [
            'name',
            'slug',
            'status',
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $channel = $this->sort($channel, $columns, $request->get('direction'));
        }

        $channel = $channel->orderBy('name', 'asc')->paginate(10);

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';
        
        return Inertia::render('SalesChannel/Index', [
            'channels' => $channel->withQueryString(),
            'params' => $params
        ]);

    }

    /**
     * @param Request $request
     * @return array
     */
    public function sortables(Request $request)
    {
        $sorts = [];
        foreach (['name', 'slug','status'] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }

        return $sorts;
    }

    public function logable($module)
    {
        $request = [
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::user()->id,
            'module' => $module['module'],
            'activity' => $module['activity'],
            'type' => $module['type'],
            'path' => $module['path'],
        ];
       return $this->log($request);
    }

    public function defaultFun($module)
    {
        $request = [
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::user()->id,
            'module' => $module['module'],
            'activity' => $module['activity'],
            'type' => $module['type'],
            'path' => $module['path'],
        ];

        $this->defaultLog($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',SalesChannel::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\SalesChannel',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        return Inertia::render('SalesChannel/Create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'slug' => ['required'],
            'status' => ['required'],
        ]);

        $channel =   SalesChannel::create($request->all());

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $channel->id  .'}',
            'module' => $channel,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('channels.index')->with('success', 'Channel added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $this->authorize('update',SalesChannel::class);

        $channel = SalesChannel::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $channel->id  .'}',
            'module' => $channel,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('SalesChannel/Create', [
            'channel' => $channel
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SalesChannel $channel)
    {
        $this->validate($request, [
            'name' => ['required'],
            'slug' => ['required'],
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $channel->id  .'}',
            'module' => $channel,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice.'/edit',
        ];
        $logData =  $this->logable($module);
        $details = $channel;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

        $channel->update($request->all());

        $currentURL = url()->current();
         $slice = Str::after($currentURL, '8000');

        $details = $channel;
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('channels.index')->with('success', 'Channel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SalesChannel $channel)
    {
        $this->authorize('delete',SalesChannel::class);

        $channel = SalesChannel::findOrFail($channel->id);
        $channel->delete();

        $module = [
            'message' => '{' . $channel->id  .'}',
            'module' => $channel,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('channels.index')->with('success', 'Channel deleted successfully');
    }
}
