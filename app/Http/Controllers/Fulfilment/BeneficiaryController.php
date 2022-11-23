<?php

namespace App\Http\Controllers\Fulfilment;

use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Support\Str;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use App\Services\Traits\Logger;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;


class BeneficiaryController extends Controller
{
    use Logger;
    use DefaultActiveLog;
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
        return Inertia::render('Fulfilment/Beneficiaries/Create', [
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
            'swift' => ['required'],
            'beneficiary_name' => ['required'],
            'beneficiary_account_number' => ['required'],
            'address1' => ['required']
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -12);

        $beneficiary = new Beneficiary();
        $beneficiary->company_id = $validate['company_id'];
        $beneficiary->bank_name = $validate['bank_name'];
        $beneficiary->swift = $validate['swift'];
        $beneficiary->beneficiary_name = $validate['beneficiary_name'];
        $beneficiary->beneficiary_account_number = $validate['beneficiary_account_number'];
        $beneficiary->address1 = $validate['address1'];
        $beneficiary->address2 = $request['address2'];
        $beneficiary->save();


        $module = [
            'message' => '{' . $beneficiary->id  . '}',
            'module' => $beneficiary,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice1 . 'company' . '/' . $request->company_id,
        ];

        $this->logable($module);

        return Redirect::route('company.show', $request->company_id)->with('success', 'Beneficiary created successfully');
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $beneficiaryId)
    {

        $beneficiary = Beneficiary::findOrFail($beneficiaryId);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
     

        $module = [
            'message' => '{' . $beneficiary->id  . '}',
            'module' => $beneficiary,
            'activity' => 'Edit',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Fulfilment/Beneficiaries/Create', [
            'beneficiary' => $beneficiary,
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
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -15);
        
        $module = [
            'message' => '{' . $beneficiary->id  . '}',
            'module' => $beneficiary,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice1 . 'company' . '/' . $request->company_id,
        ];
        $logData =  $this->logable($module);
        $details = $beneficiary;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->is_old = 1;
        $LogDetail->save();

        $beneficiary->update($request->all());

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $beneficiary;
        
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('company.show', $beneficiary->company_id)->with('success', 'Shipment Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function  destroy($id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        $company_id = $beneficiary->company_id;
        $beneficiary->delete();
        $module = [
            'message' => '{' . $beneficiary->id  . '}',
            'module' => $beneficiary,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('company.show', $company_id)->with('success', 'Beneficiary deleted successfully');
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
