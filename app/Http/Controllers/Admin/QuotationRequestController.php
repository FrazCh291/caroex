<?php

namespace App\Http\Controllers\admin;


use Inertia\Inertia;
use App\Models\Lookup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Services\Traits\Filter;
use App\Models\QuotationRequest;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Traits\DefaultActiveLog;

class QuotationRequestController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', QuotationRequest::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\QuotationRequest',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $quotationRequests = QuotationRequest::query();
        if ($request->get('Adult')) {
            $quotationRequests = $request->get('Adult') ? $quotationRequests->where('industry', 'Adult') : $quotationRequests;
        }
        if ($request->get('Alcohol_and_Softdrink')) {
            $quotationRequests = $request->get('Alcohol_and_Softdrink') ? $quotationRequests->orWhere('industry', 'Alcohol and Softdrink') : $quotationRequests;
        }
        if ($request->get('Apparel')) {
            $quotationRequests = $request->get('Apparel') ? $quotationRequests->orWhere('industry', 'Apparel') : $quotationRequests;
        }
        if ($request->get('Arts_and_Craft')) {
            $quotationRequests = $request->get('Arts_and_Craft') ? $quotationRequests->orWhere('industry', 'Arts and Craft') : $quotationRequests;
        }
        if ($request->get('Automative_and_Parts')) {
            $quotationRequests = $request->get('Automative_and_Parts') ? $quotationRequests->orWhere('industry', 'Automative and Parts') : $quotationRequests;
        }
        if ($request->get('Baby_and_Toddler')) {
            $quotationRequests = $request->get('Baby_and_Toddler') ? $quotationRequests->orWhere('industry', 'Baby and Toddler') : $quotationRequests;
        }
        if ($request->get('Diy')) {
            $quotationRequests = $request->get('Diy') ? $quotationRequests->orWhere('industry', 'Diy') : $quotationRequests;
        }
        if ($request->get('Fitness_and_Sporting_food')) {
            $quotationRequests = $request->get('Fitness_and_Sporting_food') ? $quotationRequests->orWhere('industry', 'Fitness and Sporting food') : $quotationRequests;
        }
        if ($request->get('Homeware')) {
            $quotationRequests = $request->get('Homeware') ? $quotationRequests->orWhere('industry', 'Homeware') : $quotationRequests;
        }
        if ($request->get('Male_grooming')) {
            $quotationRequests = $request->get('Male_grooming') ? $quotationRequests->orWhere('industry', 'Male grooming') : $quotationRequests;
        }
        if ($request->get('Medical')) {
            $quotationRequests = $request->get('Medical') ? $quotationRequests->orWhere('industry', 'Medical') : $quotationRequests;
        }
        if ($request->get('Other')) {
            $quotationRequests = $request->get('Other') ? $quotationRequests->orWhere('industry', 'Other') : $quotationRequests;
        }
        if ($request->get('Pet_Products')) {
            $quotationRequests = $request->get('Pet_Products') ? $quotationRequests->orWhere('industry', 'Pet Products') : $quotationRequests;
        }

        if ($request->get('ecommerce')) {
            $quotationRequests = $request->get('ecommerce') ? $quotationRequests->orWhere('platform', 'ecommerce') : $quotationRequests;
        }
        if ($request->get('Amazon')) {
            $quotationRequests = $request->get('Amazon') ? $quotationRequests->orWhere('platform', 'Amazon') : $quotationRequests;
        }
        if ($request->get('BigCommerce')) {
            $quotationRequests = $request->get('BigCommerce') ? $quotationRequests->orWhere('platform', 'BigCommerce') : $quotationRequests;
        }
        if ($request->get('Shopify')) {
            $quotationRequests = $request->get('Shopify') ? $quotationRequests->orWhere('platform', 'Shopify') : $quotationRequests;
        }
        if ($request->get('Square')) {
            $quotationRequests = $request->get('Square') ? $quotationRequests->orWhere('platform', 'Square') : $quotationRequests;
        }
        if ($request->get('Squarespace')) {
            $quotationRequests = $request->get('Squarespace') ? $quotationRequests->orWhere('platform', 'Squarespace') : $quotationRequests;
        }
        if ($request->get('Walmart')) {
            $quotationRequests = $request->get('Walmart') ? $quotationRequests->orWhere('platform', 'Walmart') : $quotationRequests;
        }
        if ($request->get('Wix')) {
            $quotationRequests = $request->get('Wix') ? $quotationRequests->orWhere('platform', 'Wix') : $quotationRequests;
        }
        if ($request->get('Woocommerce')) {
            $quotationRequests = $request->get('Woocommerce') ? $quotationRequests->orWhere('platform', 'Woocommerce') : $quotationRequests;
        }
        if ($request->get('None/Other')) {
            $quotationRequests = $request->get('None/Other') ? $quotationRequests->orWhere('platform', 'None/Other') : $quotationRequests;
        }

        if ($request->get('100-199')) {
            $quotationRequests = $request->get('100-199') ? $quotationRequests->orWhere('shipment_month', '100-199') : $quotationRequests;
        }
        if ($request->get('200-299')) {
            $quotationRequests = $request->get('200-299') ? $quotationRequests->orWhere('shipment_month', '200-299') : $quotationRequests;
        }
        if ($request->get('1-99')) {
            $quotationRequests = $request->get('1-99') ? $quotationRequests->orWhere('shipment_month', '1-99') : $quotationRequests;
        }
        if ($request->get('300-399')) {
            $quotationRequests = $request->get('300-399') ? $quotationRequests->orWhere('shipment_month', '300-399') : $quotationRequests;
        }
        if ($request->get('400-499')) {
            $quotationRequests = $request->get('400-499') ? $quotationRequests->orWhere('shipment_month', '400-499') : $quotationRequests;
        }
        $quotationRequests = $this->search($quotationRequests, [
            'first_name',
            'last_name',
            'email',
            'phone',
            'company',
            'industry',
            'email',
            'message',
            'platform',
            'shipment_month',
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $quotationRequests = $this->sort($quotationRequests, $columns, $request->get('direction'));
        }

        $quotationRequests = $quotationRequests->paginate(10);
        $quotationIndustry = QuotationRequest::with('quotationRequest')->distinct('industry')->pluck('industry')->toArray();
        $quotationPlatform = QuotationRequest::distinct('platform')->pluck('platform')->toArray();
        $quotationShipment = QuotationRequest::distinct('shipment_month')->pluck('shipment_month')->toArray();

        $params = $request->all();

        return Inertia::render('Quotation_Requests/Index', [
            'quotation_requests' => $quotationRequests->withQueryString(),
            'params' => $params,
            'quotationIndustry' => $quotationIndustry,
            'quotationPlatform' => $quotationPlatform,
            'quotationShipment' => $quotationShipment,
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
            'first_name',
            'email',
            'phone',
            'company',
            'industry',
            'email',
            'message',
            'platform',
            'shipment_month',
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
        $this->authorize('create', QuotationRequest::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\QuotationRequest',
            'activity' => 'Create',
            'type' => 'fulfilment',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $questionnaires = Questionnaire::select('id', 'label', 'type', 'value')->get();
        $quotationType = Lookup::where('type', 'quotation_type')->get();
        $quotationPlatform = Lookup::where('type', 'quotation_platform')->get();
        $monthlyQuantityRequest = Lookup::where('type', 'monthly_quantity_request')->get();

        return Inertia::render('Quotation_Requests/Create', [
            'questionnaires' => $questionnaires,
            'quotation_types' => $quotationType,
            'quotation_platforms' => $quotationPlatform,
            'monthly_quantity_requests' => $monthlyQuantityRequest
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
        $this->validate($request, [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15', 'min:8'],
            'company' => ['required'],
            'industry' => ['required'],
            'email' => ['required'],
            'message' => ['required'],
            'platform' => ['required'],
            'shipment_month' => ['required']
        ]);

        $quotationRequests = new QuotationRequest();
        $quotationRequests->company_id = Auth::user()->company_id;
        $quotationRequests->first_name = $request->first_name;
        $quotationRequests->last_name = $request->last_name;
        $quotationRequests->email = $request->email;
        $quotationRequests->phone = $request->phone;
        $quotationRequests->company = $request->company;
        $quotationRequests->industry = $request->industry;
        $quotationRequests->message = $request->message;
        $quotationRequests->platform = $request->platform;
        $quotationRequests->shipment_month = $request->shipment_month;
        $quotationRequests->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $quotationRequests->id  . '}',
            'module' => $quotationRequests,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return redirect()->route('quotation-requests.index')->with('success', 'Questionnaire Create Successfully');
    }

    /**s
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
    public function edit($id)
    {
        $this->authorize('update', QuotationRequest::class);

        $questionnaires = Questionnaire::select('id', 'label', 'type', 'value')->get();
        $quotationType = Lookup::where('type', 'quotation_type')->get();
        $quotationRequest = Lookup::where('type', 'quotation_platform')->get();
        $monthlyQuantityRequest = Lookup::where('type', 'monthly_quantity_request')->get();
        $quotationRequests = QuotationRequest::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $quotationRequests->id  . '}',
            'module' => $quotationRequests,
            'activity' => 'Edit',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Quotation_Requests/Create', [
            'questionnaires' => $questionnaires,
            'quotation_types' => $quotationType,
            'quotation_platforms' => $quotationRequest,
            'monthly_quantity_requests' => $monthlyQuantityRequest,
            'quotation_request' => $quotationRequests
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
        $validate = $this->validate($request, [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'company' => ['required'],
            'industry' => ['required'],
            'email' => ['required'],
            'platform' => ['required'],
            'shipment_month' => ['required'],
            'message' => ['required']
        ]);
        $quotationRequests = QuotationRequest::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $quotationRequests->id  . '}',
            'module' => $quotationRequests,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice . '/edit',
        ];
        $logData =  $this->logable($module);
        $details = $quotationRequests;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->is_old = 1;
        $LogDetail->save();

        $quotationRequests->first_name = $request->first_name;
        $quotationRequests->last_name = $request->last_name;
        $quotationRequests->email = $request->email;
        $quotationRequests->phone = $request->phone;
        $quotationRequests->company = $request->company;
        $quotationRequests->industry = $request->industry;
        $quotationRequests->message = $request->message;
        $quotationRequests->platform = $request->platform;
        $quotationRequests->shipment_month = $request->shipment_month;
        $quotationRequests->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $quotationRequests;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return redirect()->route('quotation-requests.index')->with('success', 'Questionnaire Create Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('delete', QuotationRequest::class);

        $quotationRequests = QuotationRequest::findOrFail($id);
        $quotationRequests->delete();

        $module = [
            'message' => '{' . $quotationRequests->id  . '}',
            'module' => $quotationRequests,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return redirect()->route('quotation-requests.index')->with('success', 'Questionnaire Delete Successfully');
    }
}
