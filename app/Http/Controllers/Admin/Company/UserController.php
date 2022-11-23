<?php

namespace App\Http\Controllers\Admin\Company;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\Traits\Logger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;
use App\Actions\Fortify\PasswordValidationRules;
use App\Notifications\PasswordCreateNotification;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Sort;

class UserController extends Controller
{
    use Sort;
    // use Filter;
    // use Search;
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
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\User',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $authCompanyId = Auth::user()->company()->first()->id;
        $companyUsers = User::where('company_id', $authCompanyId)->get();



        return Inertia::render('Companies/Users/Index', [
            'company_id' => $authCompanyId,
            'users' => $companyUsers
        ]);
    }
    public function sortables(Request $request)
    {
        $sorts = [];

        foreach ([
            'name',
            'email',
            'role_id',
        ] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }

        return $sorts;
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function userCreate()
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\user',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $authCompany = Auth::user()->company()->first();

        $this->authorize('create', User::class);

        $roles = Role::where('company_id', $authCompany->id)->where([['slug', '!=', 'super_user'], ['slug', '!=', 'erp_owner']])->get();

        return Inertia::render('Companies/Users/Create', [
            'company_id' => $authCompany->id,
            'roles' => $roles
        ]);
    }


    public function companyUser(Request $request)
    {
        // dd($request->all());
        $this->authorize('viewAny', User::class);

        $authCompany = Auth::user()->company()->first();

        $company = Company::with(['users' => function ($query) use ($request) {
            $direction = $request->get('direction');
            $query->when($request->get('name'), function ($q) use ($direction) {
                return $q->orderBy('name', $direction)->paginate(10);
            })->when($request->get('email'), function ($q) use ($direction) {
                return $q->orderBy('email', $direction)->paginate(10);
            });
        }, 'users.role', 'subscription'])->where('id', $authCompany->id)->first();
        // $company = $this->search($company->users, [
        //     'name',
        //     'email',
        // ]);
        
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $company = $this->sort($company, $columns, $request->get('direction'));
        }
        
        $user = user::distinct('role_id')->pluck('role_id')->toArray();
        
        if ($request->has('direction') && $request->get('role_id')) {
            $sortedDta = $company->users->sortBy(function ($user) {
                    return $user->role->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);

            $company->setRelation('users',collect(array_values($sortedDta->toArray())));
        }
        $params = $request->all();
        

        $this->authorize('viewAny',User::class);
        
        $company = Company::with(['users'=>function($query) use($request){
            $direction = $request->get('direction');
           $query->when($request->get('name'),function($q) use($direction){
             return $q->orderBy('name',$direction)->paginate(10);
           })->when($request->get('email'),function($q) use($direction){
            return $q->orderBy('email',$direction)->paginate(10);
           });
        },'users.role', 'subscription'])->where('id', $authCompany->id)->first();
        // $company = $this->search($company->users, [
        //     'name',
        //     'email',
        // ]);
        // if ($request->has('direction') && $request->get('role_id')) {
        //     $sortedDta = $company->users->sortBy(function ($user) {
        //             return $user->role->name;
        //     }, 3, $request->get('direction') == 'desc' ? true : false);
            
        //     $company->setRelation('users',collect(array_values($sortedDta->toArray())));
        // }
        $user = user::distinct('role_id')->pluck('role_id')->toArray();
        // dd($user);
        $params = $request->all();
        return Inertia::render('Companies/Users/Show', [
            'params' => $params,
            'company' => $company,
            'user' => $user,
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

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -6);

        $module = [
            'message' => '{' . $user->id  . '}',
            'module' => $user,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice1 . '/index',
        ];

        $this->logable($module);

        $user->notify(new PasswordCreateNotification());

        return Redirect::route('company.users.index', $user->company_id)->with('success', 'Company user created successfully');
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function companyUserDetail($id)
    {
        $this->authorize('view', User::class);

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

        $this->authorize('create', User::class);

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
        $this->authorize('viewAny', User::class);

        $user = User::findOrfail($id);
        $user->role->permissions()->detach();
        $user->delete();

        $module = [
            'message' => '{' . $user->id  . '}',
            'module' => $user,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('company.users.index')->with('success', 'User deleted successfully.');
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
