<?php

namespace App\Http\Controllers\Fulfilment\Company;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Role;
use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\Traits\Logger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;
use App\Notifications\PasswordCreateNotification;
use App\Actions\Fortify\PasswordValidationRules;

class UserController extends Controller
{
    use Logger;
    use DefaultActiveLog;
    use PasswordValidationRules;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Company::class);
    }

    public function index(Request $request)
    {
        $this->authorize('viewAnyuser',User::class);

        $authCompanyId = Auth::user()->company()->first()->id;
        $companyUsers = User::where('company_id', $authCompanyId)->get();

        return Inertia::render('Companies/Users/Index', [
            'company_id' => $authCompanyId,
            'users' => $companyUsers
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function userCreate()
    {
        $authCompany = Auth::user()->company()->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\user',
            'activity' => 'Create',
            'type' => 'fulfilment',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $this->authorize('createuser',User::class);

        $roles = Role::where('company_id', $authCompany->id)->where([['slug', '!=', 'super_user'],['slug', '!=', 'fulfilment_owner']])->get();

        return Inertia::render('Fulfilment/Companies/Users/Create', [
            'company_id' => $authCompany->id,
            'roles' => $roles
        ]);
    }


    public function companyUser()
    {
        $authCompany = Auth::user()->company()->first();
//        ->with('users.role', 'subscription')
        $this->authorize('viewAnyuser',User::class);
        $company = Company::with(['users.role', 'subscription'])->where('id', $authCompany->id)->first();
        return Inertia::render('Fulfilment/Companies/Users/Show', [
            'company' => $company
        ]);


//
//        $this->authorize('userCreate', $authCompany);
//        $roles = Role::where('company_id', $authCompany->id)->get();
//
//        return Inertia::render('Companies/Users/Show', [
//            'company_id' => $authCompany->id,
//            'roles' => $roles
//        ]);


//        $authCompany = Auth::user()->company()->first();
//        $users = User::with('role')->where('company_id', $authCompany->compnay_id)->get();
//
//
//        return Inertia::render('Companies/Users/Show', [
//            'users' => $users
//        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function userStore(Request $request)
    {
//        $authCompany = Auth::user()->company()->first();
//        $this->authorize('userStore', $authCompany);

        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required', 'unique:users', 'email'],
            'role_id' => ['required'],
        ]);

        $userData['name'] = $request->name;
        $userData['email'] = $request->email;
        $userData['company_id'] = $request->company_id;
        $userData['role_id'] = $request->role_id;
        $role = Role::where('id', $request->role_id)->first();
        $userData['is_admin'] = $role->slug == 'admin' ? true : false;
        $userData['password'] = rand();
        $user = User::create($userData);

        $user->notify(new PasswordCreateNotification());

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -6);
     
        $module = [
            'message' => '{' . $user->id  .'}',
            'module' => $user,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice1.'/index',
        ];

        $this->logable($module);


        return Redirect::route('companys.users.index', $user->company_id)->with('success', 'Company user created successfully');
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function companyUserDetail($id)
    {
        $this->authorize('viewuser',User::class);

        $userData = User::with('role.permissions')->where('id', $id)->first();
        $subscription = Subscription::where('company_id', $userData->company_id)->first();
        $package = $subscription->package()->first();
        $modules = $package->modules()->get();

        return Inertia::render('Companies/Users/Module', [
            'userData' => $userData,
            'modules' => $modules
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addRole(Request $request)
    {
//        $authCompany = Auth::user()->company()->first();
//
//        $this->authorize('addRole', $authCompany);

        $this->authorize('createuser',User::class);

        $this->validate($request, [
            'role' => ['required'],
            'slug' => ['required']
        ]);
        $request['order'] = 1;
        $request['status'] = 1;
        $data = $request->all();
        Role::create($data);

        return Redirect::back();
    }

//    public function allowPermission(Request $request)
//    {
//        $permission = Permission::where('action', $request->permission)->first();
//
//        $role = Role::findOrFail($request->role_id);
//        $isPermission = $role->permissions()->where('role_id', $role->id)->where('permission_id', $permission->id)->first();
//        if ($isPermission) {
//            $role->permissions()->detach($isPermission->id);
//        } else {
//            $role->permissions()->attach($permission->id);
//        }
//        return Redirect::back();
////
//    }
//
//
//    public function companyRolePermissions($id)
//    {
//
//        $role = Role::with('permissions')->where('id',$id)->first();
//
//        $subscription = Subscription::where('company_id', $role->company_id)->where('is_active',1)->first();
//        $package = $subscription->package()->first();
//        $modules = $package->modules()->get();
//
//
//        return Inertia::render('Companies/Roles/Role_permission', [
//            'modules' => $modules,
//            'role' => $role
//        ]);
//    }
//
//    public function allowCompanyPermission(Request $request)
//    {
//
//        $permission = Permission::where('action', $request->permission)->first();
//
//        $role = Role::findOrFail($request->role_id);
//        $isPermission = $role->permissions()->where('role_id', $role->id)->where('permission_id', $permission->id)->first();
//        if ($isPermission) {
//            $role->permissions()->detach($isPermission->id);
//        } else {
//            $role->permissions()->attach($permission->id);
//        }
//        return Redirect::back();
////
//    }

    /**
     * @return \Inertia\Response|void
     */
    public function createPassword()
    {
        abort_if(request('expires') <= now()->timestamp, 404);

        if (request()->hasValidSignature()) {
            $user = User::where('id', request('user'))->first();
            return Inertia::render('Auth/CreatePassword', [
                'user' => $user,
            ]);
        } else {
            abort(401);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => $this->passwordRules(),
            'email' => ['email']
        ]);

        $pass = Hash::make($request->password);
        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'password' => $pass,
        );

        User::where('email', $request->email)->update($data);

        return Redirect::route('login')->with('success', 'Password created cuccessfully.');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $this->authorize('deleteuser',User::class);


        $user = User::findOrfail($id);
        $user->role->permissions()->detach();
        $user->delete();

        $module = [
            'message' => '{' . $user->id  .'}',
            'module' => $user,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('companys.users.index')->with('success', 'User deleted successfully.');
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
}
