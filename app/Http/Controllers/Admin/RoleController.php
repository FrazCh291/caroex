<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Logger;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Traits\DefaultActiveLog;

class RoleController extends Controller
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
        $this->authorize('viewAny',Role::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Role',
            'activity' => 'View',
            'type' => 'super',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $roles = Role::query();
        $roles = $request->get('enable') ? $roles->where('status', 1) : $roles;
        $roles = $request->get('disable') ? $roles->orWhere('status', 0) : $roles;
        $roles = $this->search( $roles, [
            'id',
            'role',
            'company_id',
            'slug',
            'order',
           
        ]);
        if ($request->has('query')) {
            $roles = $roles->orWhereHas('company', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $roles = $this->sort($roles, $columns, $request->get('direction'));
        }
        
        $roles = $roles->with('company')->orderBy('id', 'asc')->paginate(10);

        if ($request->has('direction') && $request->get('company_id')) {
            $sortedDta = $roles->getCollection()->sortBy(function ($role) {
                return $role->company->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $roles->setCollection(collect($sort));
        }

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Roles/Index', [
            'roles' => $roles,
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
            'id',
            'role',
            'slug',
            'company_id',
            'order',
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
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create',Role::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Role',
            'activity' => 'Create',
            'type' => 'super',
            'path' => $slice
        ];
        $this->defaultFun($module);

        return Inertia::render('Roles/Create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'role' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'order' => ['required', 'integer'],
            'enable' => ['required', 'boolean']
        ]);

        $user = auth()->user();
        $role = new Role($request->all());
        $user->company->id ? $role->company_id = $user->company->id : null;
        $role->status = $request->enable;
        $role->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $role->id  .'}',
            'module' => $role,
            'activity' => 'Store',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('roles.index');
    }

    /**
     * @param Role $company
     */
    public function show(Role $company)
    {
        //
    }

    /**
     * @param Role $role
     * @return \Inertia\Response
     */
    public function edit(Role $role)
    {
        $this->authorize('update',Role::class);

        return Inertia::render('Roles/Create', [
            'role' => $role
        ]);
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'role' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'order' => ['required', 'integer'],
            'enable' => ['required', 'boolean']
        ]);

        $request['status'] = $request->enable;

        $role->update($request->all());

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' .  $role->id  .'}',
            'module' =>  $role,
            'activity' => 'Update',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('roles.index');
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete',Role::class);

        $role->delete();

        $module = [
            'message' => '{' . $role->id  .'}',
            'module' => $role,
            'activity' => 'Delete',
            'type' => 'super',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
