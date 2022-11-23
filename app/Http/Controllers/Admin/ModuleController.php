<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Support\Str;
use App\Services\Traits\Sort;
use Illuminate\Http\Request;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Models\ActivityLogsDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;


class ModuleController extends Controller
{
    use Search;
    use Sort;
    use Logger;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Module::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Module',
            'activity' => 'View',
            'type' => 'super',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $modules = Module::query();
        $modules = $this->search($modules, [
            'name',
        ]);
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $modules = $this->sort($modules, $columns, $request->get('direction'));
        }

        $modules = $modules->orderBy('name', 'asc')->paginate(10);

        $params = $request->all();

        return Inertia::render('Modules/Index', [
            'modules' => $modules->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
            'name',
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
        $this->authorize('create',Module::class);

        
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Module',
            'activity' => 'Create',
            'type' => 'super',
            'path' => $slice
        ];
        $this->defaultFun($module);
        return Inertia::render('Modules/Create');
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
            'name' => ['required', 'unique:modules,name']
        ]);

        $module = Module::create($request->all());

        $str = strtolower($module->name);

        $moduleAction = implode("-", explode(" ", $str));

        Permission::firstOrCreate([
            'action' => $moduleAction . '.index',
            'module_id' => $module->id
        ], [
            'action' => $moduleAction . '.index',
            'description' => 'Can view ' . $moduleAction,
            'module_id' => $module->id
        ]);

        Permission::firstOrCreate([
            'action' => $moduleAction . '.create',
            'module_id' => $module->id
        ], [
            'action' => $moduleAction . '.create',
            'description' => 'Can create ' . $moduleAction,
            'module_id' => $module->id
        ]);

        Permission::firstOrCreate([
            'action' => $moduleAction . '.show',
            'module_id' => $module->id
        ], [
            'action' => $moduleAction . '.show',
            'description' => 'Can view ' . $moduleAction,
            'module_id' => $module->id
        ]);

        Permission::firstOrCreate([
            'action' => $moduleAction . '.update',
            'module_id' => $module->id
        ], [
            'action' => $moduleAction . '.update',
            'description' => 'Can update ' . $moduleAction,
            'module_id' => $module->id
        ]);

        Permission::firstOrCreate([
            'action' => $moduleAction . '.delete',
            'module_id' => $module->id
        ], [
            'action' => $moduleAction . '.delete',
            'description' => 'Can delete ' . $moduleAction,
            'module_id' => $module->id
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $module->id  .'}',
            'module' => $module,
            'activity' => 'Store',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('modules.index')->with('success', 'Module created successfully');
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $this->authorize('update',Module::class);

        $module = Module::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $modules = [
            'message' => '{' . $module->id  .'}',
            'module' => $module,
            'activity' => 'Edit',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($modules);


        return Inertia::render('Modules/Create', [
            'module' => $module
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
    
        $this->validate($request, [
            'name' => ['required', 'unique:modules,name,' . $module->id]
        ]);
        $moduleOld = Module::where('id', $request->id)->first();
        $module->update($request->all());
        $moduleNew = Module::where('id', $request->id)->first();
        $str = strtolower($module->name);
        $moduleAction = implode("-", explode(" ", $str));

        Permission::updateOrCreate([
            'action' => $moduleAction . '.index',
            'module_id' => $module->id
        ], [
            'action' => $moduleAction . '.index',
            'description' => 'Can view ' . $moduleAction,
            'module_id' => $module->id
        ]);

        Permission::updateOrCreate([
            'action' => $moduleAction . '.create',
            'module_id' => $module->id
        ], [
            'action' => $moduleAction . '.create',
            'description' => 'Can create ' . $moduleAction,
            'module_id' => $module->id
        ]);

        Permission::updateOrCreate([
            'action' => $moduleAction . '.show',
            'module_id' => $module->id
        ], [
            'action' => $moduleAction . '.show',
            'description' => 'Can view ' . $moduleAction,
            'module_id' => $module->id
        ]);

        Permission::updateOrCreate([
            'action' => $moduleAction . '.update',
            'module_id' => $module->id
        ], [
            'action' => $moduleAction . '.update',
            'description' => 'Can update ' . $moduleAction,
            'module_id' => $module->id
        ]);

        Permission::updateOrCreate([
            'action' => $moduleAction . '.delete',
            'module_id' => $module->id
        ], [
            'action' => $moduleAction . '.delete',
            'description' => 'Can delete ' . $moduleAction,
            'module_id' => $module->id
        ]);
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $module->id  .'}',
            'module' => $module,
            'activity' => 'Update',
            'type' => 'super',
            'path' => $slice.'/edit',
        ];
        $logData =  $this->logable($module);
        $details = $moduleOld;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

         $currentURL = url()->current();
         $slice = Str::after($currentURL, '8000');

        $details = $moduleNew;
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();
        
        return Redirect::route('modules.index')->with('success', 'Module updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete',Module::class);

        $module = Module::where('id', $id)->first();
        
        Module::where('id', $id)->delete();
        Permission::where('module_id', $id)->delete();

        $module = [
            'message' => '{' . $module->id  .'}',
            'module' => $module,
            'activity' => 'Delete',
            'type' => 'super',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('modules.index')->with('success', 'Module deleted successfully');
    }
}
