<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notes;                  
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Cases;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Logger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class NotesController extends Controller
{
    use Logger;
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
     * @return Response
     */
    public function create($id)
    {
        $userName = Auth::user();
        $cases = Cases::with('notes.user')->where('id', $id)->first();

        return Inertia::render('Notes/Create', [
            'cases' => $cases,
            'userName' => $userName
        ]);
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
            'comment' => ['required'],
        ]);

        $cases = Cases::find($request->get('case_id'));

        $cases->notes()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'user_id' => Auth::user()->id,
            'comment' => $request->comment,
        ]);


        $lastRecorde = Notes::orderBy('id', 'DESC')->first();
        $slice = Str::afterLast($lastRecorde->notesable_type, '\\');
        $converted = Str::snake($slice);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -12);
     
        $module = [
            'message' => '{' . $lastRecorde->id  .'}',
            'module' => $lastRecorde,
            'activity' => 'Store',
            'type' => 'erp',
            'path' =>  $slice1.'/notes'.'/'.$lastRecorde->id.'/edit',
        ];

        $this->logable($module);

        return Redirect::route($converted . '.show', $lastRecorde->notesable_id)->with('success', 'Notes created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $userName = Auth::user();
        $notes = Notes::with('user')->where('id', $id)->first();
        $caseId = Cases::where('id', $notes->notesable_id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $notes->id  .'}',
            'module' => $notes,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Notes/Create', [
            'notes' => $notes,
            'caseId' => $caseId,
            'userName' => $userName
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $notesOld = Notes::where('id', $request->get('id'))->first();
        $notes = Notes::find($request->get('id'));

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $notes->id  .'}',
            'module' => $notes,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice.'/edit',
        ];
        $logData =  $this->logable($module);
        $details =  $notesOld;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

        $notes->company_id = $request->company_id;
        $notes->user_id = Auth::user()->id;
        $notes->comment = $request->comment;
        $notes->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $notes;
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        $lastRecorde = Notes::orderBy('updated_at', 'desc')->first();
        $slice = Str::afterLast($lastRecorde->notesable_type, '\\');
        $converted = Str::snake($slice);

        return Redirect::route($converted . '.show', $lastRecorde->notesable_id)->with('success', 'Notes created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notes = Notes::findOrFail($id);
        $notes->delete();

        $module = [
            'message' => '{' . $notes->id  .'}',
            'module' => $notes,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);
        return Redirect::back();
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
