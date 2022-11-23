<?php

namespace App\Http\Controllers\SuperAdmin;

use Inertia\Inertia;
use App\Models\Role;
use App\Models\Lookup;
use App\Models\Address;
use App\Models\Company;
use App\Models\Shippment;
use App\Models\Permission;
use App\Models\Beneficiary;
use App\Models\Intermediary;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Services\Traits\Sort;
use App\Models\ShippmentItem;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    use Search;
    use Sort;
    use Filter;

    /**
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Company::class);

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

        return Inertia::render('SuperAdmin/Companies/Index', [
            'companies' => $companies
        ]);
    }


    public function showCompany(Company $company)
    {
        $company = Company::with('users.role', 'subscription')->where('id', $company->id)->first();

        return Inertia::render('SuperAdmin/Companies/Show', [
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('createcompanys', Company::class);

        $companyTypes = Lookup::where('type','company_type')->get();

        return Inertia::render('SuperAdmin/Companies/Create', [
            'companyTypes' => $companyTypes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function createAddress($id)
    {
         return Inertia::render('SuperAdmin/Addresses/Create', [
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
            'phone' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
            'type' => ['required']
        ]);

        $company = new Company();
        $company->parent_id = Auth::user()->company_id;
        $company->name = $validate['name'];
        $company->contact_name = $validate['contact_name'];
        $company->email = $validate['email'];
        $company->phone = $validate['phone'];
        $company->type = $validate['type'];
        $company->save();

        return Redirect::route('companys.index')->with('success', 'Company created successfully');
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

        return Redirect::route('companys.show', $company->id)->with('success', 'Company address created successfully');
    }

    /**
     * @param Company $company
     * @return \Inertia\Response
     */
    // public function show(Company $company, $id)
    public function show($id)

    {
        $this->authorize('viewcompanys', Company::class);

        $company = Company::findOrFail($id);
        $beneficiaries = Beneficiary::where('company_id', $id)->get();
        $intermediaries = Intermediary::where('company_id', $id)->get();
        $addresses = Address::where('addressable_id', $id)->get();
        $shippments = Shippment::where('company_id', $id)->get();

        return Inertia::render('SuperAdmin/Companies/Show', [
            'company' => $company,
            'beneficiaries' => $beneficiaries,
            'intermediaries' => $intermediaries,
            'addresses' => $addresses,
            'shippments' => $shippments,
            'parentId' => $id
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
        $this->authorize('updatecompanys', Company::class);

        $companyTypes = Lookup::where('type','company_type')->get();
        $company = Company::findOrFail($id);

        return Inertia::render('SuperAdmin/Companys/Create', [
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
            'phone' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
            'type' => ['required']
        ]);

        $company->update($request->all());

        return Redirect::route('companys.index')->with('success', 'Company updated successfully');
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Address::find($id);
        $this->validate($request, [
            'addressable_id' => ['required'],
            'address_1' => ['required'],
            'town' => ['required'],
            'city' => ['required'],
            'county' => ['required'],
            'postcode' => ['required'],
            'country' => ['required']
        ]);

        $address->update($request->all());

        return Redirect::route('companys.show', $address->addressable_id)->with('success', 'Adreess updatedd successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $this->authorize('deletecompanys', Company::class);

        $company = Company::findOrFail($company->id);
        $addresses = Address::where('addressable_id', $company->id)->delete();
        $benificiary = Beneficiary::where('company_id', $company->id)->delete();
        $intermediaries = Intermediary::where('company_id', $company->id)->delete();
        $shippments = Shippment::where('company_id', $company->id)->delete();
        $shipmentItems = ShippmentItem::where('company_id', $company->id)->delete();
        $company->delete();

        return Redirect::route('companys.index', [$addresses, $benificiary, $intermediaries, $shippments, $shipmentItems])->with('success', 'Record deleted successfully');
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

        return Redirect::route('companys.show', $company_id)->with('success', 'Addres deleted successfully');
    }

    /**
     * @param $id
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function CompanyRoles($id)
    {
        $this->authorize('CompanyRoles', Company::findOrFail($id));
        $company = Company::with(['roles'=>function($query){
            $query->orderBy('slug','asc');}])->where('id', $id)->first();
        if(Auth::user()->is_admin){
            $company->setRelation('roles', $company->roles->reject(function (&$role) {
                return $role->slug=='admin';
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
