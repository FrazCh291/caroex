<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Lookup;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Building;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Models\ActivityLogsDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\DefaultActiveLog;


class BuildingController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Building::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Building',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $building = Building::query();
        $building = $this->search($building, [
            'code',
            'address_1',
            'address_2',
            'city',
            'state',
            'country',
            'zip_code',
            'phone'
        ]);
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $building = $this->sort($building, $columns, $request->get('direction'));
        }
        $building = $building->orderBy('code', 'asc')->paginate(10);
        $params = $request->all();

        return Inertia::render('Building/Buildings/Index', [
            'buildings' => $building->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request)
    {
        $sorts = [];
        $sortrr =   [
            'code',
            'address_1',
            'phone'
        ];
        foreach ($sortrr as $sort) {
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
        $this->authorize('create', Building::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Building',
            'activity' => 'Create',
            'type' => 'fulfilment',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $countries = Lookup::where('type', 'country')->get();

        return Inertia::render('Building/Buildings/Create', [
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:buildings|max:2',
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
            'volume' => 'required|numeric|gt:0',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'address_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip_code' => 'required',

        ]);

        $building = new Building();
        $building->company_id = Auth::user()->company_id;
        $building->name = $request->name;
        $building->code = $request->code;
        $building->phone = $request->phone;
        $building->volume = $request->volume;
        $building->length = $request->length;
        $building->width = $request->width;
        $building->height = $request->height;
        $building->address_1 = $request->address_1;
        $building->address_2 = $request->address_2;
        $building->city = $request->city;
        $building->state = $request->state;
        $building->country = $request->country;
        $building->zip_code = $request->zip_code;
        $building->is_occupied = $request->is_occupied;
        $building->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $building->id  .'}',
            'module' => $building,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);
    
        $section = new Section();
        $section->company_id = Auth::user()->company_id;
        $section->code = 'S1';
        $section->building_id = $building->id;
        $section->volume = 1;
        $section->length = 1;
        $section->width = 1;
        $section->height = 1;
        $section->is_active = true;
        $section->is_occupied = false;
        $section->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $section->id  .'}',
            'module' => $section,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return redirect()->route('building.index')->with('success', 'Building Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($buildingCode)
    {
        $this->authorize('view', Building::class);

        $building = Building::with('sections.aisles.bays.levels.bins')->where('code', $buildingCode)->first();
        $settings = Setting::where('name', 'building')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $building->id  .'}',
            'module' => $building,
            'activity' => 'Show',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Building/Buildings/View', ['building' => $building, 'settings' => $settings]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Building::class);

        $countries = Lookup::where('type', 'country')->get();
        $building = Building::find($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $building->id  .'}',
            'module' => $building,
            'activity' => 'Edit',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Building/Buildings/Create', ['building' => $building, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|max:2',
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
            'volume' => 'required|numeric|gt:0',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'address_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
        ]);

        $buildingOld = Building::where('id', $id)->first();
        $building = Building::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $building->id  .'}',
            'module' => $building,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice.'/edit',
        ];
        $logData =  $this->logable($module);
        $details = $buildingOld;
    
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->is_old = 1;
         $LogDetail->details = $final_data;
         $LogDetail->save();

        $building->update($request->all());

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $building;
       
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return redirect()->route('building.index')->with('success', 'Building Updadted Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Building::class);

        $building = Building::where('id', $id)->first();
        $building->delete();

        $module = [
            'message' => '{' . $building->id  .'}',
            'module' => $building,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return redirect()->route('building.index')->with('delete', 'Building Deleted Successfully');
    }
}
