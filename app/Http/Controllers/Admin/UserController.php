<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\Logger;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
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
            'module' => 'App\Module\User',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);


        $users = User::where('company_id', Auth::user()->company_id)->orderBy('name', 'asc')->get();
        $users = $this->search($users, [
            'product_title',
            'email',
            'name'
        ]);

        if ($request->has('query')) {
            $users = $users->orWhereHas('users', function (Builder $query) {
                $this->search($query, ['name']);
            });
            if ($request->has('query')) {
                $users = $users->orWhereHas('users', function (Builder $query) {
                    $this->search($query, ['email']);
                });
            }
            if ($request->has('query')) {
                $users = $users->orWhereHas('users', function (Builder $query) {
                    $this->search($query, ['role_id']);
                });
            }
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $users = $this->sort($users, $columns, $request->get('direction'));
        }

        $params = $request->all();

        return Inertia::render('Users/Index', [
            'users' => $users,
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];

        foreach ([
                     'name',
                     'email',

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
            'message' => 'page',
            'module' => 'App\Module\User',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        return Inertia::render('Users/Create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required'],
        ]);

        $user = new user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = rand();
        $user->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $user->id . '}',
            'module' => $user,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);


        return Redirect::route('users.index')->with('success', 'users created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = user::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $user->id . '}',
            'module' => $user,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Users/Show', [
            'user' => $user
        ]);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = user::findOrFail($id);
        $warehouse = Warehouse::select('name', 'id')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $user->id . '}',
            'module' => $user,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);


        return Inertia::render('Users/Edit', [
            'user' => $user,

        ]);
    }

    public function Editprofile($id)
    {
        $editUser = User::findOrfail($id);

        return Inertia::render('Users/Create', [
            'user' => $editUser
        ]);
    }

    public function updateprofile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'profile_photo_path' => ['required'],
        ]);
        $user = User::where('id', $request->id)->first();
        $path = $user->profile_photo_path;
        if ($request->file('profile_photo_path')) {
            if ($path) {
                Storage::delete($path);
            }
            $path = $request->file('profile_photo_path')[0]->store('profiles');
        }
        $user->name = $request->name;
        $user->profile_photo_path = $path ??  null;
        $user->email = $request->email;
        $user->update();

        return Redirect::route('dashboard.index')->with('success', 'users created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'name' => ['required'],
            'email' => ['required'],
        ]);

        $user = user::where('id', $id)->update([
            "name" => $request->name,
            "email" => $request->email,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $user->id . '}',
            'module' => $user,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('users.index')->with('success', 'users created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = user::find($id);
        $user->delete();

        $module = [
            'message' => '{' . $user->id . '}',
            'module' => $user,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return redirect()->back();
    }
}
