<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Lookup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;

class LookupController extends Controller
{
    use Sort;
    use Search;
    use Logger;
    use Filter;
    use DefaultActiveLog;
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Lookup',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $lookups = Lookup::query();
        
        $lookups = $this->search($lookups, [
            'type',
            'value',
            'slug',
            'order',
            'enable'
        ]);

        $lookups = $request->get('enable') ? $lookups->where('enable', 1) : $lookups;
        $lookups = $request->get('disable') ? $lookups->orWhere('enable', 0) : $lookups;

        if(strtolower($request->get('query')) == 'active') {
            $lookups = $request->get('query') ? $lookups->orWhere('enable', 1) : $lookups;
        }

        if(strtolower($request->get('query')) == 'inactive') {
            $lookups = $request->get('query') ? $lookups->orWhere('enable', 0) : $lookups;
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $lookups = $this->sort($lookups, $columns, $request->get('direction'));
        }
        
        $lookups = $lookups->paginate(10);
        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';
        
        return Inertia::render('Lookups/Index', [
            'lookups' => $lookups->withQueryString(),
            'params' => $params
        ]);

    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
            'type',
            'value',
            'slug',
            'order',
            'enable'
            ] as $sort) {
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
     * @return \Inertia\Response
     */
    public function create()
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Lookup',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        return Inertia::render('Lookups/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => ['required'],
            'slug' => ['required'],
            'value' => ['required'],
        ]);

        $lookup = new Lookup();
        $lookup->type = strtolower($request->type);
        $lookup->slug = strtolower($request->slug);
        $lookup->value = $request->value;
        $lookup->order = $request->order;
        $lookup->enable = $request->enable;
        $lookup->save();
        
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $lookup->id  .'}',
            'module' => $lookup,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice.'/'.$lookup->id.'/edit',
        ];
        $this->logable($module);

        return Redirect::route('lookups.index')->with('success', 'Lookup added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lookup = Lookup::findOrFail($id);
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $lookup->id  .'}',
            'module' => $lookup,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Lookups/Create', [
            'lookup' => $lookup
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lookup $lookup)
    {
        $this->validate($request, [
            'type' => ['required'],
            'slug' => ['required'],
            'value' => ['required'],
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        
        $module = [
            'message' => '{' . $lookup->id  .'}',
            'module' => $lookup,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice.'/edit',
        ];
        $logData =  $this->logable($module);
        $details = $lookup;

		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 1;
        $LogDetail->details = $final_data;
        $LogDetail->save();
        
        $lookup->type = strtolower($request->type);
        $lookup->slug = strtolower($request->slug);
        $lookup->value = $request->value;
        $lookup->order = $request->order;
        $lookup->enable = $request->enable;
        $lookup->update();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $lookup;
        
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('lookups.index')->with('success', 'Lookup updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lookup $lookup)
    {
        $lookup = Lookup::findOrFail($lookup->id);
        $module = [
            'message' => '{' .  $lookup->id  .'}',
            'module' =>  $lookup,
            'activity' => 'Delete',
            'type' => 'super',
            'path' => null,
        ];
        $this->logable($module);
        $lookup->delete();
        
        return Redirect::route('lookups.index')->with('success', 'Lookup deleted successfully');
    }
}
