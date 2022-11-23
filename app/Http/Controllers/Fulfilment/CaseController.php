<?php

namespace App\Http\Controllers\Fulfilment;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Cases;
use Inertia\Response;
use App\Models\Notes;
use App\Models\Order;
use App\Models\Lookup;
use App\Models\Product;
use App\Models\CaseItem;
use App\Models\Documents;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Logger;
use App\Services\Traits\Search;
use App\Models\ActivityLogsDetails;
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
        $this->authorize('viewAnyCase', Cases::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Cases',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $openCases = Cases::where('status', 'Open')
            ->with('lookup', 'order.customer', 'collection', 'channel', 'casetype')->orderBy('id', 'desc')->paginate(10);
        $inprogressCases = Cases::where('status', 'In Progress')
            ->with('lookup', 'order.customer', 'collection', 'channel', 'casetype')->orderBy('id', 'desc')->paginate(10);
        $closedCases = Cases::where('status', 'Closed')
            ->with('lookup', 'order.customer', 'collection', 'channel', 'casetype')->orderBy('id', 'desc')->paginate(10);

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

        return Inertia::render('Fulfilment/Cases/Index', [
            //            'casess' => $casess->withQueryString(),
            //            'params' => $params
            'openCases' => $openCases->withQueryString(),
            'closedCases' => $closedCases->withQueryString(),
            'inprogressCases' => $inprogressCases->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $this->authorize('createCase', Cases::class);

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

            return Inertia::render('Fulfilment/Cases/DefaultCaseCreate', [
                'orders' => $orders->withQueryString(),
                'params' => $params
            ]);
        } else {
            $params = $request->all();

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');

            $module = [
                'message' => 'page',
                'module' => 'App\Module\Cases',
                'activity' => 'Create',
                'type' => 'fulfilment',
                'path' => $slice
            ];
            $this->defaultFun($module);

            return Inertia::render('Fulfilment/Cases/DefaultCaseCreate', [
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
        $orders = Order::where('id', $request->order_id[0])->first();
        $case = new Cases();
        $case->company_id = Auth::user()->company_id;
        $case->order_id = $request->order_id[0];
        $case->status = 'Open';
        $case->priority = 'Low';
        $case->channel_id = $orders->channel_id;
        $case->save();
        $case->case_number = str_pad($case->id, 6, 0, STR_PAD_LEFT);
        $case->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $case->id  . '}',
            'module' => $case,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice,
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
                'message' => '{' . $caseItems->id  . '}',
                'module' => $caseItems,
                'activity' => 'Store',
                'type' => 'fulfilment',
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
                    'message' => '{' . $caseItems->id  . '}',
                    'module' => $caseItems,
                    'activity' => 'Store',
                    'type' => 'fulfilment',
                    'path' => $slice . '/' . $caseItems->id,
                ];

                $this->logable($module);
            }
        }

        return redirect::route('case.show', $case->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $this->authorize('viewCase', Cases::class);

        $cases = Cases::with('order.customer', 'caseItem.product', 'notes.user', 'documents', 'emails')->findOrFail($id);
        $sources = Lookup::where('type', 'source')->get();
        $priorities = Lookup::where('type', 'priority')->get();
        $case_types = Lookup::where('type', 'case_type')->get();
        $case_statuses = Lookup::where('type', 'case_status')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $cases->id  . '}',
            'module' => $cases,
            'activity' => 'Show',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Fulfilment/Cases/Show', [
            'cases' => $cases,
            'sources' => $sources,
            'priorities' => $priorities,
            'case_types' => $case_types,
            'case_statuses' => $case_statuses,
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
        $this->authorize('updateCase', Cases::class);

        $orders = Order::findOrFail($id);
        $order_statuses = Lookup::where('type', 'order_status')->get();
        $priorities = Lookup::where('type', 'priority')->get();
        $case_types = Lookup::where('type', 'case_type')->get();
        $order = Order::with('orderItems')->where('id', $id)->first();
        $productConditionStatuses = Lookup::where('type', 'product_conditions')->get();
        $requested_actions = Lookup::where('type', 'requested_action')->get();
        $products = Product::orderBy('name', 'asc')->get();

        return Inertia::render('Fulfilment/Cases/Create', [
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
            'message' => '{' . $cases->id  . '}',
            'module' => $cases,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
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

        return redirect::route('case.index');
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
            'message' => '{' . $cases->id  . '}',
            'module' => $cases,
            'activity' => 'Create',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Fulfilment/Cases/FileCreate', [
            'cases' => $cases
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function createNotes($id)
    {
        $userName = Auth::user();
        $cases = Cases::with('notes')->where('id', $id)->first();

        return Inertia::render('Notes/Create', [
            'cases' => $cases,
            'userName' => $userName
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

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -14);

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

        $module = [
            'message' => '{' . $cases->id  . '}',
            'module' => $cases,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice1 . $cases->id,
        ];

        $this->logable($module);

        return Redirect::route('case.show', $lastRecorde->documentable_id)->with('success', 'Cases Documents created successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function notesStore(Request $request)
    {
        $this->validate($request, [
            'comment' => ['required'],
        ]);

        $cases = Cases::find($request->get('case_id'));

        $cases->notes()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'user_id' => Auth::user(),
            'comment' => $request->comment
        ]);

        return Redirect::route('case.show', $cases->id)->with('success', 'Notes created successfully');
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
            'message' => '{' . $document->id  . '}',
            'module' => $document,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice1 . 's/' . $document->id . '/edit',
        ];
        $logData =  $this->logable($module);
        $details =  $documentOld;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->save();

         $currentURL = url()->current();
         $slice = Str::after($currentURL, '8000');
         $slice1 = substr($slice, 0, -3);

        $details = $document;
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 1;
        $LogDetail->details = $final_data;
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

        return Redirect::route('case.show', $cases->id)->with('success', 'Cases Document Updated Successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notesUpdate(Request $request)
    {
        $notesOld = Notes::where($request->get('id'))->first();
        $notes = Notes::find($request->get('id'));
        $notes->company_id = $request->company_id;
        $notes->user = $request->user;
        $notes->date = $request->date;
        $notes->comment = $request->comment;
        $notes->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $notes->id  . '}',
            'module' => $notes,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details =  $notesOld;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->save();

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

        return Redirect::route('case.show', $cases->id)->with('success', 'Notes Updated Successfully');
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
            'message' => '{' . $document->id  . '}',
            'module' => $document,
            'activity' => 'Edit',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Fulfilment/Cases/FileCreate', [
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
        $userName = Auth::user();
        $notes = Notes::where('id', $id)->first();
        $caseId = Cases::where('id', $notes->notesable_id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $notes->id  . '}',
            'module' => $notes,
            'activity' => 'Edit',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Fulfilment/Notes/Create', [
            'notes' => $notes,
            'userName' => $userName,
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

        $dealsFileView = Documents::where('id', $id)->firstOrFail();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $dealsFileView->id  . '}',
            'module' => $dealsFileView,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return response()->file(public_path($dealsFileView->file));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function exportFile($id)
    {
        $this->authorize('view', Cases::class);

        $dealsFileExport = Documents::where('id', $id)->firstOrFail();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $dealsFileExport->id  . '}',
            'module' => $dealsFileExport,
            'activity' => 'Create',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);


        return response()->download(public_path($dealsFileExport->file));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('deleteCase', Cases::class);

        $case = Cases::findOrFail($id);
        $case->delete();

        $module = [
            'message' => '{' . $case->id  . '}',
            'module' => $case,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('case.index')->with('success', 'Cases deleted successfully');
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
            'message' => '{' . $document->id  . '}',
            'module' => $document,
            'activity' => 'Delete',
            'type' => 'fulfilment',
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
    public function notesDelete($id)
    {
        $this->authorize('delete', Cases::class);

        $notes = Notes::findOrFail($id);
        $notes->delete();

        $message =  '{' . $notes->id  . '}';
        $message1 = 'Delete';
        $type = 'fulfilment';
        $this->logable($notes, $message, $message1,  $type);

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
