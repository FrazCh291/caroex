<?php

namespace App\Http\Controllers\SuperAdmin;

use Inertia\Inertia;
use App\Models\Company;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;


class BeneficiaryController extends Controller
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
     * @return \Inertia\Response
     */
    public function create($id)
    {
        return Inertia::render('SuperAdmin/Beneficiaries/Create', [
            'companyId' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'company_id' => ['required'],
            'bank_name' => ['required'],
            'swift' => ['required'],
            'beneficiary_name' => ['required'],
            'beneficiary_account_number' => ['required'],
            'address1' => ['required']
        ]);

        $beneficiary = new Beneficiary();
        $beneficiary->company_id = $validate['company_id'];
        $beneficiary->bank_name = $validate['bank_name'];
        $beneficiary->swift = $validate['swift'];
        $beneficiary->beneficiary_name = $validate['beneficiary_name'];
        $beneficiary->beneficiary_account_number = $validate['beneficiary_account_number'];
        $beneficiary->address1 = $validate['address1'];
        $beneficiary->address2 = $request['address2'];
        $beneficiary->save();

        return Redirect::route('companys.show', $request->company_id)->with('success', 'Beneficiary created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id,$beneficiaryId)
    {

        $beneficiary = Beneficiary::findOrFail($beneficiaryId);

        return Inertia::render('SuperAdmin/Beneficiaries/Create', [
            'beneficiary' => $beneficiary,
            'companyId' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Beneficiary $beneficiary)
    {
        $this->validate($request, [
            'company_id' => ['required'],
            'bank_name' => ['required'],
            'swift' => ['required'],
            'beneficiary_name' => ['required'],
            'beneficiary_account_number' => ['required'],
            'address1' => ['required']
        ]);

        $beneficiary->update($request->all());

        return Redirect::route('companys.show', $beneficiary->company_id)->with('success', 'Shipment Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function  destroy($id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        $company_id = $beneficiary->company_id;
        $beneficiary->delete();

        return Redirect::route('companys.show', $company_id)->with('success', 'Beneficiary deleted successfully');
    }
}
