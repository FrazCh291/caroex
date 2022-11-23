<?php

namespace App\Http\Controllers\Fulfilment;
use Inertia\Inertia;
use App\Models\Lookup;
use App\Models\Warehouse;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Sort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\Traits\Logger;
use App\Models\ActivityLogsDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;


class WarehouseController extends Controller
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
        $this->authorize('viewAnyhouse',Warehouse::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Warehouse',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $warehouses = Warehouse::query();
        $warehouses = $warehouses->where('company_id',Auth::user()->company_id);
        $warehouses = $request->get('enable') ? $warehouses->where('status', 1) : $warehouses;
        $warehouses = $request->get('disable') ? $warehouses->orWhere('status', 0) : $warehouses;
        $warehouses = $this->search($warehouses, [
            'name',
            'phone',
            'address_1',
            'address_2',
            'country',
            'city',
            'state',
            'postcode',
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $warehouses = $this->sort($warehouses, $columns, $request->get('direction'));
        }
        $warehouses = $warehouses->orderBy('name', 'asc')->paginate(10);

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Fulfilment/Warehouse/Index', [
            'warehouses' => $warehouses->withQueryString(),
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
        foreach (['name',
                     'stock_item_id',
                     'name',
                     'phone',
                     'address_1',
                     'address_2',
                     'country',
                     'city',
                     'state',
                     'postcode',] as $sort) {
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
        $this->authorize('createhouse',Warehouse::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Warehouse',
            'activity' => 'Create',
            'type' => 'fulfilment',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $countries = Lookup::where('type', 'country')->get();

        return Inertia::render('Fulfilment/Warehouse/Create', [
            'countries' => $countries
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
            'name' => ['required', 'string', 'min:3', 'max:250'],
            'address_1' => ['required', 'string', 'max:250'],
            'address_2' => ['different:address_1'],
            'city' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'postcode' => ['required', 'string', 'max:8'],
            'phone' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
        ]);
        $warehouse = new Warehouse();
        $warehouse->company_id = Auth::user()->company_id;
        $warehouse->name = $request->name;
        $warehouse->phone = $request->phone;
        $warehouse->address_1 = $request->address_1;
        $warehouse->address_2 = $request->address_2;
        $warehouse->country = $request->country;
        $warehouse->city = $request->city;
        $warehouse->state = $request->state;
        $warehouse->postcode = $request->postcode;
        $warehouse->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $warehouse->id  .'}',
            'module' => $warehouse,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('warehouse.index')->with('success', 'Warehouse created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('viewhouse',Warehouse::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $this->authorize('updatehouse',Warehouse::class);

        $warehouse = Warehouse::findOrFail($id);
        $countries = Lookup::where('type', 'country')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $warehouse->id  .'}',
            'module' => $warehouse,
            'activity' => 'Edit',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Fulfilment/Warehouse/Create', [
            'warehouse' => $warehouse,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:3', 'max:250'],
            'address_1' => ['required', 'string', 'max:250'],
            'address_2' => ['different:address_1'],
            'country' => ['required'],
            'postcode' => ['required', 'string', 'max:8'],
            'phone' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
        ]);
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $warehouse->id  .'}',
            'module' => $warehouse,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice.'/edit',
        ];
        $logData =  $this->logable($module);
        $details = $warehouse;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();
         
        $warehouse->company_id = Auth::user()->company_id;
        $warehouse->name = $request->name;
        $warehouse->phone = $request->phone;
        $warehouse->address_1 = $request->address_1;
        $warehouse->address_2 = $request->address_2;
        $warehouse->city = $request->city;
        $warehouse->state = $request->state;
        $warehouse->country = $request->country;
        $warehouse->postcode = $request->postcode;
        $warehouse->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $warehouse;
        
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('warehouse.index')->with('success', 'Warehouse updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        $this->authorize('deletehouse',Warehouse::class);

        $warehouse = Warehouse::findOrFail($warehouse->id);
        $warehouse->delete();

        $module = [
            'message' => '{' . $warehouse->id  .'}',
            'module' => $warehouse,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('warehouse.index')->with('success', 'Warehouse deleted successfully');
    }
}
