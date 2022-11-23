<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDemoEmailRequest;
use App\Http\Requests\UpdateDemoEmailRequest;
use App\Models\DemoEmail;

class DemoEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDemoEmailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDemoEmailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DemoEmail  $demoEmail
     * @return \Illuminate\Http\Response
     */
    public function show(DemoEmail $demoEmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DemoEmail  $demoEmail
     * @return \Illuminate\Http\Response
     */
    public function edit(DemoEmail $demoEmail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDemoEmailRequest  $request
     * @param  \App\Models\DemoEmail  $demoEmail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDemoEmailRequest $request, DemoEmail $demoEmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DemoEmail  $demoEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(DemoEmail $demoEmail)
    {
        //
    }
}
