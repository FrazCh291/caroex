<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Cases;
use App\Models\Order;
use App\Models\Notes;
use App\Models\Email;
use App\Models\Lookup;
use App\Models\Product;
use App\Models\CaseItem;
use App\Models\CaseTask;
use App\Models\Documents;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Models\CaseSparePartItems;
use App\Models\ActivityLogsDetails;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Database\Eloquent\Builder;

class CaseController extends Controller
{
    use Sort;
    use Search;
    use Logger;
    use DefaultActiveLog;

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Cases::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Case',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);
        $sources = Lookup::where('type', 'source')->get();
        $priorities = Lookup::where('type', 'priority')->get();
        $case_types = Lookup::where('type', 'case_type')->get();
        $case_statuses = Lookup::where('type', 'case_status')->get();


        $openCases = Cases::where('status', 'Open')
            ->with('lookup', 'order.customer', 'collection','customer', 'channel', 'casetype')->orderBy('id', 'desc')->paginate(10);
        $inprogressCases = Cases::where('status', 'In Progress')
            ->with('lookup', 'order.customer', 'collection', 'channel','customer', 'casetype')->orderBy('id', 'desc')->paginate(10);
        $closedCases = Cases::where('status', 'Closed')
            ->with('lookup', 'order.customer', 'collection', 'channel','customer', 'casetype')->orderBy('id', 'desc')->paginate(10);
        //        $casess = Cases::query();
        //        $casess = $casess->where('company_id', Auth::user()->company_id);
        //        $casess = $this->search($casess, [
        //            'type',
        //            'description',
        //            'tracking_number'
        //        ]);
        //        $params = $request->all();
        //        if ($request->has('query')) {
        //            $casess = $casess->orWhereHas('lookup', function (Builder $query) {
        //                $this->search($query, ['value']);
        //            });
        //        }
        //        if ($request->has('query')) {
        //            $casess = $casess->orWhereHas('order', function (Builder $query) {
        //                $this->search($query, ['shipping_customer_name']);
        //            });
        //        }
        //        $casess = $casess->with('lookup', 'order', 'collection', 'channel','casetype')->orderBy('id', 'desc')->paginate(10);

        return Inertia::render('Cases/Index', [
            //            'casess' => $casess->withQueryString(),
            //            'params' => $params
            'openCases' => $openCases->withQueryString(),
            'closedCases' => $closedCases->withQueryString(),
            'inprogressCases' => $inprogressCases->withQueryString(),
            'sources' => $sources,
            'priorities' => $priorities,
            'case_types' => $case_types,
            'case_statuses' => $case_statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Case',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);
        $orders = Order::query();

        if ($request->has('query')) {
            $orders = $this->search($orders, [
                'customer_id', 'order_number', 'shipment_tracking_number'
            ]);
            $emailId = '';
            if (array_key_exists('email_id', $request->all())) {
                $emailId = $request->email_id;
            }
            if ($request->has('query')) {
                $orders = $orders->orWhereHas('customer', function (Builder $query) {
                    $this->search($query, ['name', 'phone', 'email', 'address1_2', 'postcode', 'city', 'order_number']);
                });
            }

            if ($request->has('direction')) {
                $columns = $this->sortables($request);
                $orders = $this->sort($orders, $columns, $request->get('direction'));
            }

            $orders = $orders->with('customer', 'orderItems')->orderBy('id', 'DESC')->paginate(10);
            $params = $request->all();

            return Inertia::render('Cases/DefaultCaseCreate', [
                'orders' => $orders->withQueryString(),
                'params' => $params,
                'emailId' => $emailId
            ]);
        } else {
            $params = $request->all();

            return Inertia::render('Cases/DefaultCaseCreate', [
                'params' => $params
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Request $request)
    {
        if (array_key_exists('order_id', $request->all())) {
            $orders = Order::where('id', $request->order_id[0])->first();
            $case = new Cases();
            $case->company_id = Auth::user()->company_id;
            $case->order_id = $request->order_id[0];
            $case->channel_id = $orders->channel_id;
            $case->save();

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');
            $module = [
                'message' => '{' . $case->id . '}',
                'module' => $case,
                'activity' => 'Store',
                'type' => 'erp',
                'path' => $slice . '/' . $case->id,
            ];

            $this->logable($module);


            if ($request->product_id == null) {
                $caseItems = new CaseItem();
                $case->company_id = Auth::user()->company_id;
                $caseItems->order_id = $request->order_id[0];
                $caseItems->case_id = $case->id;
                $caseItems->order_product_id = $orders->product_id;
                $caseItems->save();

                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');
                $module = [
                    'message' => '{' . $caseItems->id . '}',
                    'module' => $caseItems,
                    'activity' => 'Store',
                    'type' => 'erp',
                    'path' => $slice . '/' . $caseItems->id,
                ];

                $this->logable($module);
            } else {
                foreach ($request->product_id as $productId) {
                    $caseItems = new CaseItem();
                    $case->company_id = Auth::user()->company_id;
                    $caseItems->order_id = $request->order_id[0];
                    $caseItems->case_id = $case->id;
                    $caseItems->order_product_id = $productId;
                    $caseItems->save();

                    $currentURL = url()->current();
                    $slice = Str::after($currentURL, '8000');
                    $module = [
                        'message' => '{' . $caseItems->id . '}',
                        'module' => $caseItems,
                        'activity' => 'Store',
                        'type' => 'erp',
                        'path' => $slice . '/' . $caseItems->id,
                    ];

                    $this->logable($module);
                }
            }
        }
        if (!array_key_exists('order_id', $request->all())) {
            $case = new Cases();
            $case->company_id = Auth::user()->company_id;
            $case->customer_email = $request->from_email;
            $case->save();
            $emails = Email::where('email_account_id', $request->email_account_id)->where('from_email', $request->from_email)->get();
            foreach ($emails as $email) {
                $email->case_id = $case->id;
                $email->save();
            }
        }

        $case->case_number = str_pad($case->id, 6, 0, STR_PAD_LEFT);
        $case->save();
        if (array_key_exists('email_id', $request->all())) {
            $email = Email::findOrFail($request->email_id);
            $email->case_id = $case->id;
            $email->save();
        }
        if (!array_key_exists('email_id', $request->all())) {
            $email = Email::where('from_email', $orders->shipping_email)->first();
            if ($email) {
                $email->case_id = $case->id;
                $email->save();
            }
        }

        return redirect::route('cases.show', $case->id);
    }

    public function newCustomer(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'address_1' => ['required'],
            'address_2' => ['required'],
            'house_number' => ['required'],
            'city' => ['required'],
            'postcode' => ['required'],
            'country' => ['required'],
            'source' => ['required'],
            'priority' => ['required'],
            'case_status' => ['required'],
            'customer_note' => ['required'],
        ]);
       
        
        $custmer = new Customer();
        $custmer->company_id = Auth::user()->company_id;
        $custmer->name = $request->name;
        $custmer->email = $request->email;
        $custmer->phone = $request->phone;
        $custmer->address1_2 = $request->address_1 . $request->address_2;
        $custmer->house_number = $request->house_number;
        $custmer->city = $request->city;
        $custmer->postcode = $request->postcode;
        $custmer->country = $request->country;
        if($request->is_potential_customer == true){
            $custmer->is_potential_customer = 1;
        }
        else{
            $custmer->is_potential_customer = 0; 
        }
        $custmer->save();
        $customerCase = new Cases();
        $customerCase->company_id = Auth::user()->company_id;
        $customerCase->customer_id = $custmer->id;
        $customerCase->source = $request->source;
        $customerCase->priority = $request->priority;
        $customerCase->status = $request->case_status;
        $customerCase->description = $request->customer_note;
        $customerCase->save();
        $customerCase->case_number =  str_pad($customerCase->id, 6, 0, STR_PAD_LEFT);
        $customerCase->save();

        return redirect::route('cases.index');
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function typeStore(Request $request)
    {
        $this->validate($request, [
            'case_type' => ['required']
        ]);

        $caseTask = new CaseTask();
        $caseTask->company_id = Auth::user() ? Auth::user()->company_id : '';
        $caseTask->user_id = Auth::user() ? Auth::user()->id : '';
        $caseTask->case_id = $request->case_id;
        $caseTask->case_type = $request->case_type;
        $caseTask->description = $request->description;
        $caseTask->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -10);

        $module = [
            'message' => '{' . $caseTask->id . '}',
            'module' => $caseTask,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice1.$caseTask->case_id,
        ];

        $this->logable($module);

        if ($request->value) {
            foreach ($request->value as $Part) {
                $sparePart = new CaseSparePartItems();
                $sparePart->company_id = Auth::user() ? Auth::user()->company_id : '';
                $sparePart->case_id = $request->case_id;
                $sparePart->case_task_id = $caseTask->id;
                $sparePart->sparepart_id = $Part;
                $sparePart->status = 'case_sparepart_pending';
                $sparePart->save();

                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');
                $slice1 = substr($slice, 0, -10);
            
                $module = [
                    'message' => '{' . $sparePart->id . '}',
                    'module' => $sparePart,
                    'activity' => 'Store',
                    'type' => 'erp',
                    'path' => $slice1.$sparePart->id,
                ];

                $this->logable($module);
            }
        }

        return Redirect::route('cases.show', $request->case_id)->with('success', 'Notes created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        $cases = Cases::with('order.customer', 'caseItem.product', 'notes.user', 'documents', 'emails.childEmails', 'caseSparePartItem.sparePart', 'caseSparePartItem.statuss', 'caseTask.case_types', 'caseTask.usertask')->findOrFail($id);
        $sources = Lookup::where('type', 'source')->get();
        $priorities = Lookup::where('type', 'priority')->get();
        $case_types = Lookup::where('type', 'case_type')->get();
        $case_statuses = Lookup::where('type', 'case_status')->get();
        $sparePartStatuss = Lookup::where('type', 'case_sparePart_status')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $cases->id . '}',
            'module' => $cases,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        $spareParts = Product::where('product_type', 'spare_part')->orderBy('name', 'asc')->get();

        return Inertia::render('Cases/Show', [
            'cases' => $cases,
            'sources' => $sources,
            'priorities' => $priorities,
            'spareParts' => $spareParts,
            'case_types' => $case_types,
            'case_statuses' => $case_statuses,
            'sparePartStatuss' => $sparePartStatuss,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Cases::class);

        $orders = Order::findOrFail($id);
        $order_statuses = Lookup::where('type', 'order_status')->get();
        $priorities = Lookup::where('type', 'priority')->get();
        $case_types = Lookup::where('type', 'case_type')->get();
        $order = Order::with('orderItems')->where('id', $id)->first();
        $productConditionStatuses = Lookup::where('type', 'product_conditions')->get();
        $requested_actions = Lookup::where('type', 'requested_action')->get();
        $products = Product::orderBy('name', 'asc')->get();

        return Inertia::render('Cases/Create', [
            'orders' => $orders,
            'order' => $order,
            'products' => $products,
            'case_types' => $case_types,
            'priorities' => $priorities,
            'order_statuses' => $order_statuses,
            'productConditionStatuses' => $productConditionStatuses,
            'requested_actions' => $requested_actions
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
        $casesOld = Cases::where('id', $id)->first();
        $cases = Cases::with('order.customer')->findOrFail($id);
        $cases->priority = $request->priority;
        $cases->source = $request->source;
        if ($request->source_other) {
            $cases->source_other = $request->source_other;
        }
        if ($request->source_other) {
            $cases->type_other = $request->type_other;
        }
        $cases->type = $request->type;
        $cases->description = $request->description;
        $cases->company_id = Auth::user()->company_id;
        $cases->order_id = $request->order_id;
        $cases->channel_id = $request->channel_id;
        $cases->case_number = str_pad($cases->id, 6, 0, STR_PAD_LEFT);
        $cases->status = $request->status;
        $cases->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $cases->id . '}',
            'module' => $cases,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];

        $logData = $this->logable($module);
        $details = $casesOld;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->is_old = 1;
        $LogDetail->save();

      $currentURL = url()->current();
      $slice = Str::after($currentURL, '8000');

       $details = $cases;
       $final_data = json_encode($details);
       
       $LogDetail = new ActivityLogsDetails();
       $LogDetail->company_id = Auth::user()->company_id;
       $LogDetail->activity_log_id = $logData->id;
       $LogDetail->is_old = 0;
       $LogDetail->details = $final_data;
       $LogDetail->save();

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function typeUpdate(Request $request, $id)
    {
        if ($request->spare_part_status) {
            $caseSparePartOld = CaseSparePartItems::findOrFail($id);
            $caseSparePart = CaseSparePartItems::where('id', $request->id)->first();
            $caseSparePart->status = $request->spare_part_status;
            $caseSparePart->update();
            $caseSparePartNew = CaseSparePartItems::findOrFail($id);

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');
            $slice1 = substr($slice, 0, -7);

            $module = [
                'message' => '{' . $caseSparePart->id . '}',
                'module' => $caseSparePart,
                'activity' => 'Update',
                'type' => 'erp',
                'path' => $slice1.'/'.$caseSparePart->case_id,
            ];
            $logData = $this->logable($module);
            $details =  $caseSparePartOld;
            $final_data = json_encode($details);

            $LogDetail = new ActivityLogsDetails();
            $LogDetail->activity_log_id = $logData->id;
            $LogDetail->company_id = Auth::user()->company_id;
            $LogDetail->details = $final_data;
            $LogDetail->is_old = 1;
            $LogDetail->save();

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');
    
            $details = $caseSparePartNew;
            $final_data = json_encode($details);
            
            $LogDetail = new ActivityLogsDetails();
            $LogDetail->company_id = Auth::user()->company_id;
            $LogDetail->activity_log_id = $logData->id;
            $LogDetail->is_old = 0;
            $LogDetail->details = $final_data;
            $LogDetail->save();

            return Redirect::route('cases.show', $request->id2)->with('success', 'Notes created successfully');
        }
        $this->validate($request, [
            'case_type' => ['required']
        ]);
        $caseTaskOld = CaseTask::findOrFail($id);
        $caseTask = CaseTask::findOrFail($id);
        $caseTask->company_id = Auth::user() ? Auth::user()->company_id : '';
        $caseTask->user_id = Auth::user() ? Auth::user()->id : '';
        $caseTask->case_type = $request->case_type;
        $caseTask->description = $request->description;

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -7);
       
        $module = [
            'message' => '{' . $caseTask->id . '}',
            'module' => $caseTask,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice1.$caseTask->case_id
        ];
        $logData = $this->logable($module);
        $details = $caseTaskOld;
        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->is_old = 1;
        $LogDetail->save();

        $caseTask->update();
        $caseTaskNew = CaseTask::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
    
       $details = $caseTaskNew;
       $final_data = json_encode($details);
       
       $LogDetail = new ActivityLogsDetails();
       $LogDetail->company_id = Auth::user()->company_id;
       $LogDetail->activity_log_id = $logData->id;
       $LogDetail->is_old = 0;
       $LogDetail->details = $final_data;
       $LogDetail->save();

        if ($request->value && $request->case_type !== 'spareparts') {
            CaseSparePartItems::where([['case_task_id', $caseTask->id], ['status', 'case_sparepart_pending']])->delete();
        }
        if ($request->value && $request->case_type == 'spareparts') {
            CaseSparePartItems::where([['case_task_id', $caseTask->id], ['status', 'case_sparepart_pending']])->delete();
            foreach ($request->value as $Part) {
                CaseSparePartItems::updateOrCreate([
                    'case_id' => $caseTask->case_id,
                    'case_task_id' => $caseTask->id,
                    'sparepart_id' => $Part,
                    'status' => 'case_sparepart_pending',
                ], [
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'case_id' => $caseTask->case_id,
                    'case_task_id' => $caseTask->id,
                    'sparepart_id' => $Part,
                    'status' => 'case_sparepart_pending',
                ]);
            }
        }

        return Redirect::route('cases.show', $caseTask->case_id)->with('success', 'Notes created successfully');
    }

    /**
     * @param $id
     * @return Response
     */
    public function createDocuments($id)
    {
        $cases = Cases::with('documents')->where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $cases->id . '}',
            'module' => $cases,
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->logable($module);


        return Inertia::render('Cases/FileCreate', [
            'cases' => $cases
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function createNotes($id)
    {
        $cases = Cases::with('notes')->where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $cases->id . '}',
            'module' => $cases,
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->logable($module);


        return Inertia::render('Notes/Create', [
            'cases' => $cases
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function documentStore(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:100'],
            'file' => ['required'],
        ]);

        $cases = Cases::find($request->get('case_id'));
        $className = get_class($cases);
        $lastRecorde = Documents::orderBy('created_at', 'desc')->first();
        $slice = Str::afterLast($className, '\\');
        $converted = Str::snake($slice);
        if ($request->file('file')) {
            $guessExtension = $request->file('file')[0]->getClientOriginalExtension();
            $fileName = $converted;
            $filesPath = Documents::where('documentable_type', 'App\Models\Cases')->orderBy('created_at', 'desc')->select('file')->first();
            if ($filesPath) {
                $test = preg_match_all('/[^0-9]/', '', $filesPath);
                $num = $test + 1;
                $path = 'storage/' . $request->file('file')[0]->storeAs('caseDocuments', $fileName . $num . '.' . $guessExtension);
            } else {
                $path = 'storage/' . $request->file('file')[0]->storeAs('caseDocuments', $fileName . '.' . $guessExtension);
            }
            $files = $request->file('file');
            $mimeType = $files[0]->getClientOriginalExtension();
        }

        $cases->documents()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'title' => $request->title,
            'file' => $path,
            'file_type' => $mimeType,
            'description' => $request->description,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -14);

        $module = [
            'message' => '{' . $cases->id . '}',
            'module' => $cases,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice1 . $cases->id,
        ];

        $this->logable($module);

        return Redirect::route($converted . '.show', $lastRecorde->documentable_id)->with('success', 'Cases Documents created successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function notesStore(Request $request)
    {
        $this->validate($request, [
            'user' => ['required', 'string', 'max:100'],
            'date' => ['required'],
            'comment' => ['required'],
        ]);

        $cases = Cases::find($request->get('case_id'));

        $cases->notes()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'user' => $request->user,
            'date' => $request->date,
            'comment' => $request->comment,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $request->get('case_id') . '}',
            'module' => $cases,
            'activity' => 'Store',
            'type' => 'super',
            'path' => $slice,
        ];

        $this->logable($module);

        return Redirect::route('cases.show', $cases->id)->with('success', 'Notes created successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function documentUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:100'],
        ]);
        $documentOld = Documents::where('id', $request->get('id'))->first();
        $document = Documents::find($request->get('id'));

        if ($request->file('file')) {
            $path = 'storage/' . $request->file('file')[0]->store('caseDocuments');
            $files = $request->file('file');
            $mimeType = $files[0]->getClientOriginalExtension();
            $document->company_id = Auth::user() ? Auth::user()->company_id : '';
            $document->title = $request->title;
            $document->file = $path;
            $document->description = $request->description;
            $document->file_type = $mimeType;
        } else {
            $document->company_id = Auth::user() ? Auth::user()->company_id : '';
            $document->title = $request->title;
            $document->description = $request->description;
        }
        $document->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -3);

        $module = [
            'message' => '{' . $document->id . '}',
            'module' => $document,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice1 . 's/' . $document->id . '/edit',
        ];
        $logData = $this->logable($module);
        $details = $documentOld;
        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->is_old = 1;
        $LogDetail->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $document;
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        $cases = Cases::where('id', $document->documentable_id)->first();

        return Redirect::route('cases.show', $cases->id)->with('success', 'Cases Document Updated Successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notesUpdate(Request $request)
    {
        $notesOld = Notes::where($request->get('id'))->first();
        $notes = Notes::find($request->get('id'));

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $notes->id . '}',
            'module' => $notes,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice . '/edit',
        ];
        $logData = $this->logable($module);
        $details = $notesOld;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->is_old = 1;
        $LogDetail->save();

        $notes->company_id = $request->company_id;
        $notes->user = $request->user;
        $notes->date = $request->date;
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

        $cases = Cases::where('id', $notes->notesable_id)->first();

        return Redirect::route('cases.show', $cases->id)->with('success', 'Notes Updated Successfully');
    }

    /**
     * @param $id
     * @return Response
     */
    public function editDocuments($id)
    {
        $document = Documents::where('id', $id)->first();
        $caseId = Cases::where('id', $document->documentable_id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $document->id . '}',
            'module' => $document,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Cases/FileCreate', [
            'document' => $document,
            'caseId' => $caseId
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function editNotes($id)
    {
        $notes = Notes::where('id', $id)->first();
        $caseId = Cases::where('id', $notes->notesable_id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $notes->id . '}',
            'module' => $notes,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Notes/Create', [
            'notes' => $notes,
            'caseId' => $caseId
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function viewFile($id)
    {
        $this->authorize('view', Cases::class);

        $caseDocumentView = Documents::where('id', $id)->firstOrFail();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $caseDocumentView->id . '}',
            'module' => $caseDocumentView,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return response()->file(public_path($caseDocumentView->file));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function exportFile($id)
    {
        $this->authorize('view', Cases::class);

        $caseDocumentExport = Documents::where('id', $id)->firstOrFail();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $caseDocumentExport->id . '}',
            'module' => $caseDocumentExport,
            'activity' => 'create',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);


        return response()->download(public_path($caseDocumentExport->file));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', Cases::class);

        $case = Cases::findOrFail($id);
        $email = Email::where('case_id', $id)->first();
        if ($email) {
            $email->case_id = null;
            $email->save();
        }
        $case->delete();

        $module = [
            'message' => '{' . $case->id . '}',
            'module' => $case,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('cases.index')->with('success', 'Cases deleted successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id)
    {
        $this->authorize('delete', Cases::class);

        $document = Documents::findOrFail($id);
        $document->delete();

        $module = [
            'message' => '{' . $document->id . '}',
            'module' => $document,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function typeDestroy($id)
    {
        $this->authorize('delete', Cases::class);

        $caseSparePartItems = CaseSparePartItems::where('case_task_id', $id)->first();
        if($caseSparePartItems){
            $module = [
                'message' => '{' . $id . '}',
                'module' => $caseSparePartItems,
                'activity' => 'Delete',
                'type' => 'erp',
                'path' => null,
            ];
            $this->logable($module);
        }
        $caseTask = CaseTask::where('id', $id)->first();
        $module = [
            'message' => '{' . $id . '}',
            'module' => $caseTask,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];
        $this->logable($module);
        CaseSparePartItems::where('case_task_id', $id)->delete();
        CaseTask::where('id', $id)->delete();

        return Redirect::back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function sparepartDestroy($id)
    {
        $this->authorize('delete', Cases::class);
        $caseSparePartItems = CaseSparePartItems::where('id', $id)->first();

        $module = [
            'message' => '{' . $id . '}',
            'module' => $caseSparePartItems,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);
        CaseSparePartItems::where('id', $id)->delete();


        return Redirect::back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function notesDelete($id)
    {
        $this->authorize('delete', Cases::class);

        $notes = Notes::findOrFail($id);
        $notes->delete();

        $module = [
            'message' => '{' . $notes->id . '}',
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
