<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Company;
use App\Models\Quotation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\QuotationItem;
use App\Services\Traits\Sort;
use App\Services\Traits\Logger;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Quotation::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Quotation',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $quotations = Quotation::query();
        $quotations = $quotations->where('company_id', Auth::user()->company_id);
        $quotations = $this->search($quotations, [
            'description',
            'supplier_id'
        ]);

        if ($request->has('query')) {
            $quotations = $quotations->orWhereHas('supplier', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $quotations = $this->sort($quotations, $columns, $request->get('direction'));
        }
        $quotations = $quotations->with('supplier')->orderBy('id', 'desc')->paginate(10);
        $params = $request->all();

        if ($request->has('direction') && $request->get('supplier_id')) {
            $sortedDta = $quotations->getCollection()->sortBy(function ($quotation) {
                return $quotation->supplier->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $quotations->setCollection(collect($sort));
        }
        return Inertia::render('Quotations/Index', [
            'quotation' => $quotations->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
            'supplier_id',
            'description',
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
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create',Quotation::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Quotation',
            'activity' => 'Create',
            'type' => 'fulfilment',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $suppliers = Company::where('parent_id', Auth::user()->company_id)->where('type', 'supplier_company')->orderBy('name')->get();

        return Inertia::render('Quotations/Create', [
            'suppliers' => $suppliers
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
            'supplier_id' => ['required'],
            'description' => ['required']
        ]);

        $quotation = new Quotation;
        $quotation->supplier_id = $request->supplier_id;
        $quotation->company_id = Auth::user()->company_id;
        $quotation->description = $request->description;
        $quotation->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $quotation->id  .'}',
            'module' => $quotation,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice.'/'.$quotation->id,
        ];

        $this->logable($module);

        return redirect()->route('quotations.index');
    }


    public function storeQuotationItem(Request $request)
    {
        $this->validate($request, [
            'product_id' => ['required'],
            'quantity' => ['required'],
            'unit_price' => 'required|numeric|between:0,999.99',
            'total_price' => 'required|numeric|between:0,999.99',
            'description' => 'required'
        ]);

        $quotationItem = new Quotationitem;
        $quotationItem->quotation_id = $request->quotation_id;
        $quotationItem->product_id = $request->product_id;
        $quotationItem->description = $request->description;
        $quotationItem->quantity = $request->quantity;
        $quotationItem->unit_price = $request->unit_price;
        $quotationItem->total_price = $request->total_price;
        $quotationItem->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $quotationItem->id  .'}',
            'module' => $quotationItem,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);


        return redirect()->route('quotations.show', $quotationItem->quotation_id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $this->authorize('view',Quotation::class);

        $quotation = Quotation::with('supplier', 'quotationItems.product')->where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $quotation->id  .'}',
            'module' => $quotation,
            'activity' => 'Show',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Quotations/Show', [
            'quotation' => $quotation,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update',Quotation::class);

        $quotations = Quotation::where('id', $id)->first();
        $suppliers = Company::where('parent_id', Auth::user()->company_id)->where('type', 'supplier_company')->orderBy('name')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $quotations->id  .'}',
            'module' => $quotations,
            'activity' => 'Edit',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Quotations/Create', [
            'quotations' => $quotations,
            'suppliers' => $suppliers
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required',
            'description' => 'required'
        ]);
       $quotationRequest = Quotation::where('id', $id)->first();
       $quotationRequests =  Quotation::where('id', $id)->update([
           "supplier_id" => $request->supplier_id,
           "description" => $request->description
        ]);
       $quotationRequestNew = Quotation::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $quotationRequest->id  .'}',
            'module' => $quotationRequest,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details = $quotationRequest;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

         $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $quotationRequestNew;
        
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return redirect()->route('quotations.index')->with('success', 'sdkfhasjdf');
    }

    public function updateQuotationitem(Request $request)
    {
        $this->validate($request, [
            'product_id' => ['required'],
            'quantity' => ['required'],
            'unit_price' => 'required|numeric|between:0,999.99',
            'total_price' => 'required|numeric|between:0,999.99',
            'description' => 'required'
        ]);

     $quotationItem =   QuotationItem::where('id', $request->id)->update([
            "quotation_id" => $request->quotation_id,
            "product_id" => $request->product_id,
            "description" => $request->description,
            "quantity" => $request->quantity,
            "unit_price" => $request->unit_price,
            "total_price" => $request->total_price,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $quotationItem->id  .'}',
            'module' => $quotationItem,
            'activity' => 'update',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details = $quotationItem;
        
		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->save();

        return redirect()->route('quotations.show', $request->quotation_id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete',Quotation::class);

        $quotation = Quotation::find($id);
        $quotation->delete();

        $module = [
            'message' => '{' . $quotation->id  .'}',
            'module' => $quotation,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return redirect()->route('quotations.index');
    }
}
