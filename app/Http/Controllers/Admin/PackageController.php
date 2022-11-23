<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Module;
use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLogsDetails;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;


class PackageController extends Controller
{
    use Search;
    use Logger;
    use Sort;
    use DefaultActiveLog;
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Package::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Package',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $packages = Package::query();
        $packages = $request->get('active') ? $packages->where('status',1) : $packages;
        $packages = $request->get('inactive') ? $packages->orWhere('status',0) : $packages;


        $packages = $this->search($packages, [
            'name',
            'duration',
            'number_of_user',
            'price',
        ]); 

        if ($request->has('query')) {
            $packages = $packages->orWhereHas('modules', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('query')) {
            $packages = $packages->orWhereHas('modules', function (Builder $query) {
                $this->search($query, ['duration']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $packages = $this->sort($packages, $columns, $request->get('direction'));
        }

        $packages = $packages->orderBy('name', 'asc')->paginate(10);

        $params = $request->all();
        return Inertia::render('Packages/Index', [
            'packages' => $packages->withQueryString(),
            'params' => $params
        ]);
    }
    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
            'name',
            'duration',
            'number_of_user',
            'price',
            'status',

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
        $this->authorize('create',Package::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Package',
            'activity' => 'Create',
            'type' => 'super',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $modules = Module::orderBy('name', 'asc')->get();

        return Inertia::render('Packages/Create', [
            'modules' => $modules
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
            'name' => ['required', 'unique:packages,name'],
            'price' => ['required'],
            'is_one_time' => ['required'],
            'duration' => 'required|numeric',
            'number_of_user' => ['required'],
            'value' => ['required'],
            'status' => ['required']
        ]);

        $package = new Package($request->all());
        $package->save();
        $package->modules()->attach($request->value);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $package->id  .'}',
            'module' => $package,
            'activity' => 'Store',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('packages.index')->with('success', 'Package created successfully');
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
    public function edit(Package $package)
    {
        $this->authorize('update',Package::class);
        $modules = Module::orderBy('name', 'asc')->get();
        $package = Package::findOrFail($package->id);
        $values = $package->modules()->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' .  $package->id  .'}',
            'module' =>  $package,
            'activity' => 'Edit',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Packages/Create', [
            'package' => $package,
            'modules' => $modules,
            'values' => $values
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Package $package)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:packages,name,' . $package->id],
            'price' => ['required'],
            'is_one_time' => ['required'],
            'duration' => 'required|numeric',
            'number_of_user' => ['required'],
            'value' => ['required'],
            'status' => ['required']
        ]);


        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $package->id  .'}',
            'module' => $package,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice.'/edit',
        ];
        $logData =  $this->logable($module);
        $details = $package;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

        $package->modules()->sync($request->value);
        $package->update($request->all());
         
         $currentURL = url()->current();
         $slice = Str::after($currentURL, '8000');

        $details = $package;
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('packages.index')->with('success', 'Package updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Package $package)
    {
        $this->authorize('delete',Package::class);
        $package = Package::findOrFail($package->id);
        $package->delete();

        $module = [
            'message' => '{' . $package->id  .'}',
            'module' => $package,
            'activity' => 'Delete',
            'type' => 'super',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('packages.index')->with('success', 'Package deleted successfully');
    }
}
