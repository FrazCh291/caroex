<?php

namespace App\Http\Controllers\Admin;

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
use App\Services\Traits\Logger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Support\Facades\Redirect;
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
        $this->authorize('viewAnyuser',User::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\User',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $users = User::where('company_id', Auth::user()->company_id)->orderBy('name', 'asc')->get();

        if ($request->has('query')) {
            $users = $users->orWhereHas('users', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $users = $this->sort($users , $columns, $request->get('direction'));
        }

        $params = $request->all();

        return Inertia::render('Fulfilment/Users/Index', [
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
        $this->authorize('createuser',User::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\User',
            'activity' => 'Create',
            'type' => 'fulfilment',
            'path' => $slice
        ];
        $this->defaultFun($module);

        return Inertia::render('Fulfilment/Users/Create');
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
            'name' => ['required'],
            'email' => ['required'],
        ]);

            $user = new user();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =  rand();
            $user->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $user->id  .'}',
            'module' => $user,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

             return Redirect::route('users.index')->with('success', 'users created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('viewuser',User::class);

        $user = user::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $user->id  .'}',
            'module' => $user,
            'activity' => 'Show',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Fulfilment/Users/Show',[
            'user' => $user
        ]);


    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $this->authorize('updateuser',User::class);

        $user = user::findOrFail($id);
        $warehouse = Warehouse::select('name', 'id')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $user->id  .'}',
            'module' => $user,
            'activity' => 'Edit',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Fulfilment/Users/Create', [
            'user' => $user,

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
        $request->validate([

            'name' => ['required'],
            'email' => ['required'],
        ]);

        $user =  user::where('id', $id)->update([
            "name" => $request->name,
            "email" => $request->email,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $user->id  .'}',
            'module' => $user,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('users.index')->with('success', 'users created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('deleteuser',User::class);

        $user = user::find($id);
        $user->delete();

        $module = [
            'message' => '{' . $user->id  .'}',
            'module' => $user,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return redirect() ->back();
    }
}
