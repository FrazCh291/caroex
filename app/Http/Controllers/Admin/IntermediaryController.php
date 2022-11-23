<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Intermediary;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class IntermediaryController extends Controller
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
    public function create($id)
    {
        return Inertia::render('Intermediaries/Create', [
            'companyId' => $id
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
        $validate = $this->validate($request, [
            'company_id' => ['required'],
            'bank_name' => ['required'],
            'swift' => ['required']
        ]);
        $intermediary = new Intermediary();
        $intermediary->company_id = $validate['company_id'];
        $intermediary->bank_name = $validate['bank_name'];
        $intermediary->swift = $validate['swift'];
        $intermediary->save();

        return Redirect::route('companies.show', $request->company_id)->with('success', 'Intermediary created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $intermediaryId)
    {   
        $intermediary = Intermediary::findOrFail($intermediaryId);

        return Inertia::render('Intermediaries/Create', [
            'intermediary' => $intermediary,
            'companyId' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Intermediary $intermediary)
    {
        $this->validate($request, [
            'company_id' => ['required'],
            'bank_name' => ['required'],
            'swift' => ['required']
        ]);
        $intermediary->update($request->all());

        return Redirect::route('companies.show', $intermediary->company_id)->with('success', 'Intermediary updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $intermediary = Intermediary::findOrFail($id);
        $company_id = $intermediary->company_id;
        $intermediary->delete();

        return Redirect::route('companies.show', $company_id)->with('success', 'Intermediary deleted successfully');
    }
}
