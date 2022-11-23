<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Quotation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\QuotationItem;
use App\Services\Traits\Logger;
use App\Models\ActivityLogsDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\DefaultActiveLog;


class QuotationItemController extends Controller
{
    use Logger;
    use DefaultActiveLog;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $this->authorize('viewAny',Quotation::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\QuotationItem',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $quotation = Quotation::with('supplier', 'quotationItems.product')->where('id', $id)->first();

        return Inertia::render('Quotations/index', [
            'quotation' => $quotation,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $this->authorize('create',Quotation::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\QuotationItem',
            'activity' => 'Create',
            'type' => 'fulfilment',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $products = Product::all();
        $quotation = Quotation::where('id', $id)->first();

        return Inertia::render('QuotationItem/Create', [
            'quotation' => $quotation,
            'products' => $products
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
            'product_id' => 'required',
            'quantity' => 'required|numeric|between:0,999.99',
            'unit_price' => 'required|numeric|between:0,999.99',
            'total_price' => 'required',
            'description' => 'required'
        ]);
        
        $quotationItem = new QuotationItem;
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
            'path' => $slice.'/'.$quotationItem->id,
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
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
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

        $quotationItems = QuotationItem::findOrFail($id);
        $products = Product::Select('name', 'id')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $quotationItems->id  .'}',
            'module' => $quotationItems,
            'activity' => 'Edit',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('QuotationItem/Create', [
            'quotationItems' => $quotationItems,
            'products' => $products
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
        $this->validate($request, [
            'product_id' => ['required'],
            'quantity' => 'required|numeric|between:0,999.99',
            'unit_price' => 'required|numeric|between:0,999.99',
            'total_price' => 'required',
            'description' => 'required'
        ]);
        $quotationItems =   QuotationItem::where('id', $request->id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $quotationItems->id  .'}',
            'module' => $quotationItems,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details = $quotationItems;

		$final_data = json_encode($details);
        
         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();


        $quotationItems =   QuotationItem::where('id', $request->id)->update([
            "quotation_id" => $request->quotation_id,
            "product_id" => $request->product_id,
            "description" => $request->description,
            "quantity" => $request->quantity,
            "unit_price" => $request->unit_price,
            "total_price" => $request->total_price,
        ]);

        $quotationItemsNew = QuotationItem::where('id', $request->id)->first();
        
         $currentURL = url()->current();
         $slice = Str::after($currentURL, '8000');

        $details = $quotationItemsNew;
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
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

        $quotationItem = QuotationItem::find($id);
        $quotationItem->delete();
        

        $module = [
            'message' => '{' . $quotationItem->id  .'}',
            'module' => $quotationItem,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return redirect()->back();
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
      return  $this->log($request);
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
