<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Role;
use App\Models\Lookup;
use App\Models\Address;
use App\Models\Company;
use App\Models\Shipment;
use App\Models\Permission;
use Illuminate\Support\Str;
use App\Models\ShipmentItem;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLogsDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Calculation\Database\DStDev;

class CompanyController extends Controller
{
    use Search;
    use Sort;
    use Filter;
    use Logger;
    use DefaultActiveLog;

    /**
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Company::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Company',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $companies = Company::query();

        $companies = $companies->where('parent_id', Auth::user()->company_id);
        $companies = $this->search($companies, [
            'name',
            'contact_name',
            'email',
            'phone',
            'type',
        ]);
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $companies = $this->sort($companies, $columns, $request->get('direction'));
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $companies = $this->sort($companies, $columns, $request->get('direction'));
        }

        $companies = $companies->orderBy('id', 'desc')->paginate(10);
        $params = $request->all();

        return Inertia::render('Companies/Index', [
            'companies' => $companies->withQueryString(),
            'params' => $params
        ]);
    }


    public function loginCompany()
    {
        $companies = Company::latest()->get();

        return Inertia::render('Companies/Index', [
            'companies' => $companies
        ]);
    }


    public function showCompany(Company $company)
    {
        $company = Company::with('users.role', 'subscription')->where('id', $company->id)->first();

        return Inertia::render('Companies/Show', [
            'company' => $company
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
                     'name',
                     'contact_name',
                     'email',
                     'phone',
                     'type',
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
        $this->authorize('create', Company::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Company',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $companyTypes = Lookup::where('type', 'company_type')->get();
        $warehouses = Lookup::where('type', 'company_type')->get();

        return Inertia::render('Companies/Create', [
            'companyTypes' => $companyTypes,
            'warehouses' => $warehouses,
        ]);
    }

    public function createSupplierCompany()
    {
        $this->authorize('create', Company::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Company',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $companyTypes = Lookup::where('type', 'company_type')->get();
        $warehouses = Lookup::where('type', 'company_type')->get();
        $supplier = Lookup::where('slug', 'supplier_company')->first();

        return Inertia::render('Companies/Create', [
            'companyTypes' => $companyTypes,
            'warehouses' => $warehouses,
            'supplier' => $supplier,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function createAddress($id)
    {

        return Inertia::render('Addresses/Create', [
            'companyId' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'name' => ['required'],
            'contact_name' => ['required'],
            'email' => ['required'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
            'type' => ['required']
        ]);

        if($request->type == "supplier_company"){
            $id = DB::table('companies')->max('id') + 1;
        $company = new Company();
        $company->id = $id;
        $company->parent_id = Auth::user()->company_id;
        $company->name = $validate['name'];
        $company->contact_name = $validate['contact_name'];
        $company->email = $validate['email'];
        $company->phone = $validate['phone'];
        $company->type = $validate['type'];
        $company->save();
        
        
        $company = Company::find($company->id);
        $company->addresses()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'town' => $request->town,
            'city' => $request->city,
            'county' => $request->county,
            'postcode' => $request->postcode,
            'country' => $request->country,
        ]);
        }else{
        $id = DB::table('companies')->max('id') + 1;
        $company = new Company();
        $company->id = $id;
        $company->parent_id = Auth::user()->company_id;
        $company->name = $validate['name'];
        $company->contact_name = $validate['contact_name'];
        $company->email = $validate['email'];
        $company->phone = $validate['phone'];
        $company->type = $validate['type'];
        $company->save();
        }
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $company->id  .'}',
            'module' => $company,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice.'/'.$company->id,
        ];

        $this->logable($module);

        return Redirect::route('companies.index')->with('success', 'Company created successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addCompanyAddress(Request $request)
    {
        $this->validate($request, [

            'address_1' => ['required'],
            'town' => ['required'],
            'city' => ['required'],
            'county' => ['required'],
            'postcode' => ['required', 'string', 'max:8'],
            'country' => ['required'],
        ]);

        $company = Company::find($request->company_id);

        $company->addresses()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
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
        $module = [
            'message' => '{' . $company->id  .'}',
            'module' => $company,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('companies.show', $company->id)->with('success', 'Company address created successfully');
    }

    /**
     * @param Company $company
     * @return \Inertia\Response
     */
    // public function show(Company $company, $id)
    public function show($id)
    {

        $this->authorize('view', Company::class);

        $company = Company::findOrFail($id);
        $countries = Lookup::where('type','country')->get();
        $addresses = Address::where('addressable_id', $id)->where('addressable_type', 'App\Models\Company')->with('company')->orderBy('id' , 'desc')->first();
      
        $shipments = Shipment::where('company_id', $id)->get();
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $company->id  .'}',
            'module' => $company,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Companies/Show', [
            'company' => $company,
            'addresses' => $addresses,
            'shipments' => $shipments,
            'parentId' => $id,
            'countries' => $countries
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Company::class);

        $companyTypes = Lookup::where('type', 'company_type')->get();
        $company = Company::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $company->id  .'}',
            'module' => $company,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Companies/Create', [
            'company' => $company,
            'companyTypes' => $companyTypes
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editAddress($id)
    {
        $address = Address::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $address->id  .'}',
            'module' => $address,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Addresses/Create', [
            'address' => $address,
            'companyId' => $address->addressable_id

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:3', 'max:250'],
            'contact_name' => ['required'],
            'email' => ['required'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
            'type' => ['required']
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $company->id  .'}',
            'module' => $company,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details = $company;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

       $company->name = $request->name;
       $company->contact_name = $request->contact_name;
       $company->email = $request->email;
       $company->phone = $request->phone;
       $company->type = $request->type;
       $company->update();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $company;
        
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('companies.index')->with('success', 'Company updated successfully');
    }

    public function updateAddress(Request $request, $id)
    {

     
        $addressOld =Address::where('id', $id)->first();

        $this->validate($request, [
            'address_1' => ['required'],
            'town' => ['required'],
            'city' => ['required'],
            'county' => ['required'],
            'postcode' => ['required', 'string', 'max:8'],
            'country' => ['required'],
            'name' => ['required'],
            'type' => ['required'],
        ]);
            
            
        $address = Address::find($id);
        
        $companyAddress = Address::where('id', $id)->first();
        $companyAddress->company_id =  $request->company_id;
        $companyAddress->address_1 = $request->address_1;
        $companyAddress->address_2 = $request->address_2;
        $companyAddress->town = $request->town;
        $companyAddress->city = $request->city;
        $companyAddress->county =$request->county;
        $companyAddress->postcode = $request->postcode;
        $companyAddress->country = $request->country;
        $companyAddress->update();

        $companyAddress = Company::where('id',$request->company_id)->first();
        $companyAddress->name = $request->name;
        $companyAddress->type = $request->type;
        $companyAddress->update();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $address->id  .'}',
            'module' => $address,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details = $addressOld;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

        $address->update($request->all());

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $address;
        
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('companies.show', $address->addressable_id)->with('success', 'Adreess updatedd successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', Company::class);

        $company = Company::findOrFail($company->id);
        $addresses = Address::where('addressable_id', $company->id)->delete();
        $shipments = Shipment::where('company_id', $company->id)->delete();
        $shipmentItems = ShipmentItem::where('company_id', $company->id)->delete();
        $company->delete();

        $module = [
            'message' => '{' . $company->id  .'}',
            'module' => $company,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('companies.index', [$addresses, $shipments, $shipmentItems])->with('success', 'Record deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function addressDelete($id)
    {
        $address = Address::findOrFail($id);
        $company_id = $address->addressable_id;
        $address->delete();

        $module = [
            'message' => '{' . $address->id  .'}',
            'module' => $address,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('companies.show', $company_id)->with('success', 'Addres deleted successfully');
    }

    /**
     * @param $id
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function CompanyRoles($id)
    {
        $this->authorize('CompanyRoles', Company::findOrFail($id));
        $company = Company::with(['roles' => function ($query) {
            $query->orderBy('slug', 'asc');
        }])->where('id', $id)->first();
        if (Auth::user()->is_admin) {
            $company->setRelation('roles', $company->roles->reject(function (&$role) {
                return $role->slug == 'admin';
            }));
        };
        return Inertia::render('Companies/Roles/Index', [
            'company' => $company
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function companyModulesPermissions($id)
    {
        $authCompany = Auth::user()->company()->first();
        $this->authorize('companyModulesPermissions', $authCompany);
        $role = Role::with('permissions')->where('id', $id)->first();
        $subscription = Subscription::where('company_id', $role->company_id)->where('is_active', 1)->first();
        $package = $subscription->package()->first();
        $modules = $package->modules()->orderBy('name', 'asc')->get();
        return Inertia::render('Companies/Roles/Role_permission', [
            'modules' => $modules,
            'role' => $role
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function allowCompanyModulesPermission(Request $request)
    {
        $authCompany = Auth::user()->company()->first();
        $this->authorize('allowCompanyModulesPermission', $authCompany);
        $permission = Permission::where('action', $request->permission)->first();
        $role = Role::findOrFail($request->role_id);
        $isPermission = $role->permissions()->where('role_id', $role->id)->where('permission_id', $permission->id)->first();
        if ($isPermission) {
            $role->permissions()->detach($isPermission->id);
        } else {
            $role->permissions()->attach($permission->id);
        }
        return Redirect::back();
    }
}
