<?php

namespace App\Http\Controllers\Fulfilment;

use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\EmailAccount;
use Illuminate\Http\Request;
use App\Models\SalesChannel;
use App\Models\EmailSetting;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;

class EmailSettingController extends Controller
{

    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;

//    public function __construct()
//    {
//        return $this->authorizeResource(Core::class);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', EmailSetting::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\EmailSettings',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $emails = EmailSetting::query();

        if($request->get('enable')){
            $emails = $request->get('enable')?$emails->Where('status', 1):$emails;
        }
        if($request->get('disable')){
            $emails = $request->get('disable')?$emails->orWhere('status', 0):$emails;
        }

        $emails = $this->search($emails, [
            'username',
            'protocol',
        ]);
        if(strtolower($request->get('query')) == 'active') {
            $emails = $request->get('query') ? $emails->orWhere('status', 1) : $emails;
        }
        if(strtolower($request->get('query')) == 'inactive') {
            $emails = $request->get('query') ? $emails->orWhere('status', 0) : $emails;
        }
        if ($request->has('query')) {
            $emails =  $emails->orWhereHas('emailAccount', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $emails = $this->sort($emails, $columns, $request->get('direction'));
        }

//        $emails = $emails->with('channel')->orderBy('username', 'asc')->paginate(10);
        $emails = $emails->with('emailAccount')->orderBy('username', 'asc')->paginate(10);

//        if ($request->has('direction') && $request->get('channel_id')) {
//            $sortedDta = $emails->getCollection()->sortBy(function ($emails) {
//                return $emails->channel->name;
//            }, 3, $request->get('direction') == 'desc' ? true : false);
//            $sort = [];
//            foreach ($sortedDta as $item) {
//                $sort[] = $item;
//            }
//            $emails->setCollection(collect($sort));
//        }
        if ($request->has('direction') && $request->get('email_account_id')) {
            $sortedDta = $emails->getCollection()->sortBy(function ($emails) {
                return $emails->channel->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $emails->setCollection(collect($sort));
        }
        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('EmailSetting/Index', [
            'emails' => $emails->withQueryString(),
            'params' => $params
        ]);

    }

    /**
     * @param Request $request
     * @return array
     */
    public function sortables(Request $request)
    {
        $sorts = [];
        foreach (['username', 'channel_id', 'protocol','status'] as $sort) {
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
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', EmailSetting::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\EmailSettings',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $emailAccounts = EmailAccount::orderBy('name', 'asc')->get();

//        $channels = SalesChannel::where('name', '!=', 'Tracking')->orderBy('name', 'asc')->get();
        return Inertia::render('EmailSetting/Create', [
            'emailAccounts' => $emailAccounts
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
            'username' => ['required'],
            'password' => ['required'],
            'smtp_outgoing_server' => ['required'],
            'smtp_outgoing_port' => ['required'],
            'smtp_outgoing_encryption' => ['required'],
            'incoming_server' => ['required'],
            'incoming_port' => ['required'],
            'incoming_encryption' => ['required'],
            'protocol' => ['required'],
            'status' => ['required'],
            'email_account_id' => ['required'],
        ]);
////        $pass = Crypt::encryptString($request->password);
//        if ($request->status == true) {
//            EmailSetting::where('channel_id', $request->channel_id)->where('company_id', Auth::user()->company_id)->update(['status' => false]);
//        }
        $data = ([
            'username' => $request->username,
            'company_id' => Auth::user()->company_id,
            'password' => $request->password,
            'smtp_outgoing_server' => $request->smtp_outgoing_server,
            'smtp_outgoing_port' => $request->smtp_outgoing_port,
            'smtp_outgoing_encryption' => $request->smtp_outgoing_encryption,
            'incoming_server' => $request->incoming_server,
            'incoming_port' => $request->incoming_port,
            'incoming_encryption' => $request->incoming_encryption,
            'status' => $request->status,
            'protocol' => $request->protocol,
            'email_account_id' => $request->email_account_id,
        ]);
        $request['company_id'] = Auth::user() ? Auth::user()->company_id : '';

        $emailSetting =  EmailSetting::create($data);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $emailSetting->id  .'}',
            'module' => $emailSetting,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('email-settings.index')->with('success', 'Email created successfully');
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
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $this->authorize('update', EmailSetting::class);

        $emailSetting = EmailSetting::findOrFail($id);
        $emailAccounts = EmailAccount::orderBy('name', 'asc')->get();
//        $channels = SalesChannel::orderBy('name', 'asc')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $emailSetting->id  .'}',
            'module' => $emailSetting,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('EmailSetting/Create', [
            'emailSetting' => $emailSetting,
            'emailAccounts' => $emailAccounts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => ['required'],
            'password' => ['required'],
            'smtp_outgoing_server' => ['required'],
            'smtp_outgoing_port' => ['required'],
            'smtp_outgoing_encryption' => ['required'],
            'incoming_server' => ['required'],
            'incoming_port' => ['required'],
            'incoming_encryption' => ['required'],
            'protocol' => ['required'],
            'status' => ['required'],
            'email_account_id' => ['required'],
        ]);
//        $pass = Crypt::encryptString($request->password);
//        $pass = Hash::make($request->password);
//            if ($request->status == true) {
//
//                EmailSetting::where('channel_id', $request->channel_id)->where('company_id', Auth::user()->company_id)->update(['status' => false]);
//            }

        $data = ([
            'username' => $request->username,
            'password' => $request->password,
            'smtp_outgoing_server' => $request->smtp_outgoing_server,
            'smtp_outgoing_port' => $request->smtp_outgoing_port,
            'smtp_outgoing_encryption' => $request->smtp_outgoing_encryption,
            'incoming_server' => $request->incoming_server,
            'incoming_port' => $request->incoming_port,
            'incoming_encryption' => $request->incoming_encryption,
            'status' => $request->status,
            'protocol' => $request->protocol,
            'email_account_id' => $request->email_account_id,
        ]);
        $emailSettingOld = EmailSetting::where('id', $id)->first();

        $emailSetting = EmailSetting::where('id', $id)->update($data);
        $emailSetting = EmailSetting::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $emailSetting->id  .'}',
            'module' => $emailSetting,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details = $emailSettingOld;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->is_old = 1;
        $LogDetail->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $emailSetting;
        
        $final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('email-settings.index')->with('success', 'Email updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', EmailSetting::class);

        $emailSettings = EmailSetting::findOrFail($id);
        $emailSettings->delete();

        $module = [
            'message' => '{' . $emailSettings->id  .'}',
            'module' => $emailSettings,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('email-settings.index')->with('success', 'Email deleted successfully');
    }
}
