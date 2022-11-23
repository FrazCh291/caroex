<?php

namespace App\Http\Controllers\Admin;

use App\Models\Core;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Core::class);
        $cores = Core::orderBy('name', 'asc')->get();

        return Inertia::render('Cores/Index', [
            'cores' => $cores
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create',Core::class);

        return Inertia::render('Cores/Create');
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
            'name' => ['required'],
            'description' => ['required']
        ]);

        Core::create($request->all());

        return Redirect::route('cores.index')->with('success', 'Core created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view',Core::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(Core $core)
    {
        $this->authorize('update',Core::class);

        $core = Core::findOrFail($core->id);

        return Inertia::render('Cores/Create', [
            'core' => $core
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Core $core)
    {
        $this->validate($request, [
            'name' => ['required'],
            'description' => ['required']
        ]);

        $core->update($request->all());

        return Redirect::route('cores.index')->with('success', 'Core updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Core $core)
    {

        $this->authorize('delete',Core::class);

        $core = Core::findOrFail($core->id);
        $core->delete();

        return Redirect::route('cores.index')->with('success', 'Core deleted successfully');
    }
}
