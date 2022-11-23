<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Lookup;
use App\Models\Address;
use App\Models\Courrier;
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
use Illuminate\Database\Eloquent\Builder;

class CourrierController extends Controller
{
    use Search;
    use Sort;
    use Filter;
    use Logger;
    use DefaultActiveLog;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Courrier',
            'activity' => 'View',
            'type' => 'super',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $courriers = Courrier::query();
        $courriers = $this->search($courriers, [
            'name',
        ]);
        if ($request->has('query')) {
            $courriers = $courriers->orWhereHas('warehousebuilding', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $courriers = $this->sort($courriers, $columns, $request->get('direction'));
        }
        $courriers = $courriers->with('warehousebuilding')->orderBy('id', 'desc')->paginate(10);
        $params = $request->all();

        if ($request->has('direction') && $request->get('warehouseBuilding')) {

            $sortedDta = $courriers->getCollection()->sortBy(function ($courrier) {
                return $courrier->warehousebuilding->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $courriers->setCollection(collect($sort));
        }

        return Inertia::render('Courriers/Index', [
            'courriers' => $courriers,
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
            'name'
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'module' => 'App\Module\Courrier',
            'message' => 'page',
            'activity' => 'Create',
            'type' => 'super',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $warehouseBuildings = Building::orderBy('name', 'asc')->get();

        return Inertia::render('Courriers/Create', [
            'WarehouseBuildings' => $warehouseBuildings
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function createCourrierAddress($id)
    {
        $countries = Lookup::where('type', 'country')->get();
        $courrier = Courrier::where('id', $id)->first();
        
        return Inertia::render('Courriers/Address', [
            'courrier' => $courrier,
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
        $this->validate($request, [
            'name' => ['required'],
            'warehouseBuilding_id' => ['required']
        ]);
        $courrierCompany = new Courrier();
        $courrierCompany->name = $request->name;
        $courrierCompany->warehouseBuilding_id = $request->warehouseBuilding_id;
        $courrierCompany->company_id = Auth::user()->company_id;
        $courrierCompany->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
    
        $module = [
            'message' => '{' . $courrierCompany->id  .'}',
            'module' => $courrierCompany,
            'activity' => 'Store',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return redirect()->route('courriers.index');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function addressStore(Request $request)
    {
        $this->validate($request, [
            'address_1' => ['required'],
            'address_2' => ['required'],
            'town' => ['required'],
            'city' => ['required'],
            'county' => ['required'],
            'postcode' => 'required',
            'country' => ['required'],
        ]);
        $courrier = Courrier::find($request->get('courrier_id'));
        $courriers =  $courrier->addresses()->create([
            'company_id' => Auth::user()->company_id,
            'addressable_id' => $request->courrier_id,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'town' => $request->town,
            'city' => $request->city,
            'county' => $request->county,
            'postcode' => $request->postcode,
            'country' => $request->country,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -21);

        $module = [
            'message' => '{' . $courriers->id  .'}',
            'module' => $courriers,
            'activity' => 'Store',
            'type' => 'super',
            'path' => $slice1.'s'.'/'.$request->courrier_id,
        ];

        $this->logable($module);

        return redirect()->route('courriers.show', $courrier->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $courrier = Courrier::find($id)->with('addresses')->where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $courrier->id  .'}',
            'module' => $courrier,
            'activity' => 'Show',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Courriers/Show', [
            'courrier' => $courrier,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courriers = Courrier::where('id', $id)->first();
        $warehuseBuildings = Building::Select('name', 'id')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $courriers->id  .'}',
            'module' => $courriers,
            'activity' => 'Edit',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Courriers/Create', [
            'courriers' => $courriers,
            'WarehouseBuildings' => $warehuseBuildings
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAddress($id)
    {
        $countries = Lookup::where('type', 'country')->get();
        $address = Address::where('id', $id)->first();
        $courrier = Courrier::where('id', $address->addressable_id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $address->id  .'}',
            'module' => $address,
            'activity' => 'Edit',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Courriers/Address', [
            'address' => $address,
            'courrier' => $courrier,
            'countries' => $countries
        ]);
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
        $this->validate($request, [
            'name' => ['required'],
            'warehouseBuilding_id' => ['required']
        ]);

        $courrierOld = Courrier::where('id', $id)->first();
        $courrier = Courrier::where('id', $id)->first();
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        
        $module = [
            'message' => '{' . $courrier->id  .'}',
            'module' => $courrier,
            'activity' => 'Update',
            'type' => 'super',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details = $courrierOld;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->save();

        $courrier = Courrier::where('id', $id)->update([
            "name" => $request->name,
            "warehouseBuilding_id" => $request->warehouseBuilding_id
        ]);
        $courrierNew= Courrier::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

       $details =  $courrierNew;
       $final_data = json_encode($details);
       
       $LogDetail = new ActivityLogsDetails();
       $LogDetail->company_id = Auth::user()->company_id;
       $LogDetail->activity_log_id = $logData->id;
       $LogDetail->is_old = 0;
       $LogDetail->details = $final_data;
       $LogDetail->save();

        return redirect()->route('courriers.index');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAddress(Request $request, $id)
    {
        $this->validate($request, [
            'address_1' => ['required'],
            'address_2' => ['required'],
            'town' => ['required'],
            'city' => ['required'],
            'county' => ['required'],
            'postcode' => ['required'],
            'country' => ['required'],
        ]);
            $addressOld = Address::where('id', $id)->first();
            $address = Address::where('id', $id)->first();

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');
            $slice2 = Str::before($slice, 'update/');
            
            $module = [
                'message' => '{' . $id  .'}',
                'module' =>  $address,
                'activity' => 'Update',
                'type' => 'super',
                'path' => $slice2. 'edit'.'/'.$id,
            ];
            $logData =  $this->logable($module);
            $details =  $addressOld;
            
            $final_data = json_encode($details);
            
            $LogDetail = new ActivityLogsDetails();
            $LogDetail->activity_log_id = $logData->id;
            $LogDetail->company_id = Auth::user()->company_id;
            $LogDetail->details = $final_data;
            $LogDetail->is_old = 1;
            $LogDetail->save();

      $address =  Address::where('id', $id)->update([
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'town' => $request->town,
            'city' => $request->city,
            'county' => $request->county,
            'postcode' => $request->postcode,
            'country' => $request->country
        ]);
        $courrier = Courrier::where('id', $request->addressable_id)->first();
        $addressNew = Address::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

       $details =  $addressNew;
       $final_data = json_encode($details);
       
       $LogDetail = new ActivityLogsDetails();
       $LogDetail->company_id = Auth::user()->company_id;
       $LogDetail->activity_log_id = $logData->id;
       $LogDetail->is_old = 0;
       $LogDetail->details = $final_data;
       $LogDetail->save();

        

        return redirect()->route('courriers.show', $courrier->id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courrier = Courrier::find($id);
        $courrier->delete();

        $module = [
            'message' => '{' . $courrier->id  .'}',
            'module' => $courrier,
            'activity' => 'Delete',
            'type' => 'super',
            'path' => null,
        ];
        $this->logable($module);

        return redirect()->route('courriers.index');
    }

    public function addressDelete($id)
    {

        $address = Address::find($id);
        $address->delete();

        $module = [
            'message' => '{' . $address->id  .'}',
            'module' => $address,
            'activity' => 'Delete',
            'type' => 'super',
            'path' => null,
        ];
        $this->logable($module);

        return redirect()->back();
    }
}
