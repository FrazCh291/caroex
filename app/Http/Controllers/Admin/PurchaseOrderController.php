<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Lookup;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\Address;
use App\Models\accounts;
use App\Models\Supplier;
use App\Models\Shippment;
use App\Models\Documents;
use Illuminate\Support\Str;
use App\Models\Invoiceable;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Services\Traits\Sort;
use App\Models\CompanyPayment;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use App\Services\Traits\Search;
use App\Models\CurrencyExchange;
use App\Models\PurchaseOrderItem;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Database\Eloquent\Builder;

class PurchaseOrderController extends Controller
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
        $this->authorize('viewAny', PurchaseOrder::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\PurchaseOrder',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $query = $request['query'];
        if (substr($query, 0, 2) === '£') {
            $request['query'] = explode("£", $query)[1];
        }
        if (str_contains($query, " x")) {
            $request['query'] = explode(" x", $query)[0];
        }

        $purchaseOrders = PurchaseOrder::query();
        $purchaseOrders = $request->get('new') ? $purchaseOrders->where('status', 'new') : $purchaseOrders;
        $purchaseOrders = $request->get('released') ? $purchaseOrders->orWhere('status', 'released') : $purchaseOrders;
        $purchaseOrders = $request->get('received') ? $purchaseOrders->orWhere('status', 'received') : $purchaseOrders;
        $purchaseOrders = $request->get('canceled') ? $purchaseOrders->orWhere('status', 'canceled') : $purchaseOrders;
        $purchaseOrders = $request->get('closed') ? $purchaseOrders->orWhere('status', 'closed') : $purchaseOrders;


        $purchaseOrders = $this->search($purchaseOrders, [
            'purchase_order_number',
            'total',
            'order_date',
            'currency',
            'total',
        ]);
        if(strtolower($request->get('query')) == 'new') {
            $purchaseOrders = $request->get('query') ? $purchaseOrders->orWhere('status', 'new') : $purchaseOrders;
        }
        if(strtolower($request->get('query')) == 'released') {
            $purchaseOrders = $request->get('query') ? $purchaseOrders->orWhere('status', 'released') : $purchaseOrders;
        }
        if(strtolower($request->get('query')) == 'received') {
            $purchaseOrders = $request->get('query') ? $purchaseOrders->orWhere('status', 'received') : $purchaseOrders;
        }
        if(strtolower($request->get('query')) == 'canceled') {
            $purchaseOrders = $request->get('query') ? $purchaseOrders->orWhere('status', 'canceled') : $purchaseOrders;
        }
        if(strtolower($request->get('query')) == 'closed') {
            $purchaseOrders = $request->get('query') ? $purchaseOrders->orWhere('status', 'closed') : $purchaseOrders;
        }

        if ($request->has('query')) {
            $purchaseOrders = $purchaseOrders->orWhereHas('purchaseOrderItem.product', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $purchaseOrders = $this->sort($purchaseOrders, $columns, $request->get('direction'));
        }

        $request['query'] = $query;
        $params = $request->all();
        $params['new'] = $request->get('new') == 'true' ? 'true' : '';
        $params['released'] = $request->get('released') == 'true' ? 'true' : '';
        $params['received'] = $request->get('received') == 'true' ? 'true' : '';
        $params['canceled'] = $request->get('canceled') == 'true' ? 'true' : '';
        $params['closed'] = $request->get('closed') == 'true' ? 'true' : '';

        $purchaseOrders = $purchaseOrders->with(['purchaseOrderItem', 'purchaseOrderItem.product'])->orderBy('id', 'desc')->paginate(15);

        if ($request->has('direction') && $request->get('name')) {
            $sortedDta = $purchaseOrders->getCollection()->sortBy(function ($purchaseOrder) {
                if(sizeOf($purchaseOrder->purchaseOrderItem)>0) {
                    return $purchaseOrder->purchaseOrderItem[0]->product->name;
                }
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $purchaseOrders->setCollection(collect($sort));
        }

        return Inertia::render('PurchaseOrders/Index', [
            'purchaseOrders' => $purchaseOrders->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {

        $sorts = [];
        foreach (['purchase_order_number',
                     'total',
                     'order_date', 'status'] as $sort) {
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
        $this->authorize('create', PurchaseOrder::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\PurchaseOrder',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $item_types = Lookup::where('type' , "item_type")->get();
        $suppliers = Company::where("type", "supplier_company")->orderBy('name')->get();
        $customers = Company::where('type', 'purchaser_company')->orderBy('name')->get();
        $currencies = Lookup::where('type', 'currency')->get();
        $purchase_order_statuses = Lookup::where('type', 'purchase_order_status')->orderBy('value')->get();
        $products = Product::Select('name', 'id')->orderBy('name')->get();

        return Inertia::render('PurchaseOrders/Create', [
            'suppliers' => $suppliers,
            'currencies' => $currencies,
            'customers' => $customers,
            'purchase_order_statuses' => $purchase_order_statuses,
            'products' => $products,
            'item_types' => $item_types
        ]);
    }

    /**
     * /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => ['required'],
            'supplier_id' => ['required'],
            'purchase_order_number' => ['required'],
            'order_date' => ['required'],
            'currency' => ['required'],
//            'conversion_rate' => ['required'],
            'sub_total' => ['required'],
            'vat' => ['required'],
            'total' => ['required'],
        ]);

        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->saas_id = Auth::user()->company_id;
        $purchaseOrder->supplier_id = $request->supplier_id;
        $purchaseOrder->customer_id = $request->customer_id;
        $purchaseOrder->purchase_order_number = $request->purchase_order_number;
        $purchaseOrder->currency = $request->currency;
//      $purchaseOrder->conversion_rate = $request->conversion_rate;
        $purchaseOrder->sub_total = $request->sub_total;
        $purchaseOrder->vat = $request->vat;
        $purchaseOrder->total = $request->total;
        $purchaseOrder->order_date = $request->order_date;
        $purchaseOrder->status = 'new';
        $purchaseOrder->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $purchaseOrder->id  .'}',
            'module' => $purchaseOrder,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice.'/'.$purchaseOrder->id,
        ];

        $this->logable($module);

        foreach ($request->purchaseOrderItems as $purchaseOrderItem) {
            $purchaseOrderItems = new PurchaseOrderItem();
            $purchaseOrderItems->company_id = Auth::user()->company_id;
            $purchaseOrderItems->purchase_order_id = $purchaseOrder->id;
            $purchaseOrderItems->product_id = array_key_exists('product_id', $purchaseOrderItem) ? $purchaseOrderItem['product_id'] : null;
            $purchaseOrderItems->currency = $purchaseOrderItem['currency'];
            $purchaseOrderItems->unit_price = array_key_exists('unit_price', $purchaseOrderItem) ? $purchaseOrderItem['unit_price'] : null;
            $purchaseOrderItems->quantity = array_key_exists('quantity', $purchaseOrderItem) ? $purchaseOrderItem['quantity'] : null;
            $purchaseOrderItems->total = $purchaseOrderItem['total'];
            $purchaseOrderItems->item_type = $purchaseOrderItem['item_type'];
            
            $purchaseOrderItems->save();

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');
            $module = [
                'message' => '{' . $purchaseOrderItems->id  .'}',
                'module' => $purchaseOrderItems,
                'activity' => 'Store',
                'type' => 'erp',
                'path' => $slice.'/'.$purchaseOrder->id,
            ];
           $this->logable($module);
    
        }

        return Redirect::route('purchase-orders.index')->with('success', 'Purchase Order created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', PurchaseOrder::class);

        $purchaseOrder = PurchaseOrder::where('id', $id)->with(['supplier', 'supplier.addresses', 'customer',
            'customer.addresses','currency', 'purchaseOrderItem','purchaseOrderItem.product','purchaseOrderItem.lookup',
            'customer.addresses', 'currency', 'purchaseOrderItem', 'purchaseOrderItem.product',
            'purchaseOrderItem.currencies'])->first();

        $invoices =Invoice::all();
        $purchaseOrderInvoices = Invoiceable::where('invoiceable_id', $id)->with(['invoice','invoice.exchang','invoice.payments','invoice.payments.currencies'])->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $purchaseOrder->id  .'}',
            'module' => $purchaseOrder,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);


        return Inertia::render('PurchaseOrders/Show', [
            'purchaseOrder' => $purchaseOrder,
            'invoices' => $invoices,
            'purchaseOrderInvoices' => $purchaseOrderInvoices
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', PurchaseOrder::class);

        $purchaseOrder = PurchaseOrder::where('id', $id)->with(['supplier.addresses', 'customer.addresses'])->first();
        $purchaseOrderItems = PurchaseOrderItem::where('purchase_order_id', $id)->with(['product', 'currencies'])->get();
        $item_types = Lookup::where('type' , "item_type")->get();
        $suppliers = Company::where('type', 'supplier_company')->orderBy('name')->get();
        $customers = Company::where('type', 'purchaser_company')->orderBy('name')->get();
        $currencies = Lookup::where('type', 'currency')->get();
        $purchase_order_statuses = Lookup::where('type', 'purchase_order_status')->orderBy('value')->get();
        $products = Product::Select('name', 'id')->orderBy('name')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $purchaseOrder->id  .'}',
            'module' => $purchaseOrder,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice.'/'.$purchaseOrder->id,
        ];

        $this->logable($module);

        return Inertia::render('PurchaseOrders/Create', [
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderItem' => $purchaseOrderItems,
            'suppliers' => $suppliers,
            'currencies' => $currencies,
            'customers' => $customers,
            'purchase_order_statuses' => $purchase_order_statuses,
            'products' => $products,
            'item_types' => $item_types
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
            'customer_id' => ['required'],
            'supplier_id' => ['required'],
            'purchase_order_number' => ['required'],
            'order_date' => ['required'],
            'currency' => ['required'],
//          'conversion_rate' => ['required'],
            'sub_total' => ['required'],
            'vat' => ['required'],
            'total' => ['required'],
            'status' => ['required'],
        ]);
        $purchaseOrderOld = PurchaseOrder::where('id', $id)->first();
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->saas_id = Auth::user()->company_id;
        $purchaseOrder->supplier_id = $request->supplier_id;
        $purchaseOrder->customer_id = $request->customer_id;
        $purchaseOrder->purchase_order_number = $request->purchase_order_number;
        $purchaseOrder->currency = $request->currency;
//        $purchaseOrder->conversion_rate = $request->conversion_rate;
        $purchaseOrder->sub_total = $request->sub_total;
        $purchaseOrder->vat = $request->vat;
        $purchaseOrder->total = $request->total;
        $purchaseOrder->order_date = $request->order_date;
        $purchaseOrder->status = $request->status;

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $purchaseOrder->id  .'}',
            'module' => $purchaseOrder,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
    
        $details = $purchaseOrderOld;
      
		$final_data = json_encode($details);
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->is_old = 1;
        $LogDetail->save();

        $purchaseOrder->update();
       

        $purchaseOrderNew = PurchaseOrder::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

       $details = $purchaseOrderNew;
       $final_data = json_encode($details);
       
       $LogDetail = new ActivityLogsDetails();
       $LogDetail->company_id = Auth::user()->company_id;
       $LogDetail->activity_log_id = $logData->id;
       $LogDetail->is_old = 0;
       $LogDetail->details = $final_data;
       $LogDetail->save();

        foreach ($request->purchaseOrderItems as $purchaseItem) {
            if (array_key_exists('id', $purchaseItem) && array_key_exists('purchase_order_id', $purchaseItem)) {
                $purchaseOrderItem = PurchaseOrderItem::findOrfail($purchaseItem['id']);
                $purchaseOrderItemOld = PurchaseOrderItem::findOrfail($purchaseItem['id'])->first();
                $purchaseOrderItem->company_id = Auth::user()->company_id;
                $purchaseOrderItem->purchase_order_id = $id;
                $purchaseOrderItem->product_id = array_key_exists('product_id', $purchaseItem) ? $purchaseItem['product_id'] : null;
                $purchaseOrderItem->currency = $purchaseItem['currency'];
                $purchaseOrderItem->unit_price = array_key_exists('unit_price', $purchaseItem) ? $purchaseItem['unit_price'] : null;
                $purchaseOrderItem->quantity = array_key_exists('quantity', $purchaseItem) ? $purchaseItem['quantity'] : null;
                $purchaseOrderItem->total = $purchaseItem['total'];

                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');
    
                $module = [
                    'message' => '{' . $purchaseOrderItem->id  .'}',
                    'module' => $purchaseOrderItem,
                    'activity' => 'Update',
                    'type' => 'erp',
                    'path' => $slice,
                ];
                $logData =  $this->logable($module);
            
                $details = $purchaseOrderItemOld;
            
                $final_data = json_encode($details);
                $LogDetail = new ActivityLogsDetails();
                $LogDetail->activity_log_id = $logData->id;
                $LogDetail->company_id = Auth::user()->company_id;
                $LogDetail->details = $final_data;
                $LogDetail->is_old = 1;
                $LogDetail->save();

                $purchaseOrderItem->update();

                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');
    
                $details = $purchaseOrderItem;
                $final_data = json_encode($details);
                
                $LogDetail = new ActivityLogsDetails();
                $LogDetail->company_id = Auth::user()->company_id;
                $LogDetail->activity_log_id = $logData->id;
                $LogDetail->is_old = 0;
                $LogDetail->details = $final_data;
                $LogDetail->save();
                    
            } else {
                $purchaseOrderItems = new PurchaseOrderItem();
                $purchaseOrderItems->company_id = Auth::user()->company_id;
                $purchaseOrderItems->purchase_order_id = $id;
                $purchaseOrderItems->product_id = array_key_exists('product_id', $purchaseItem) ? $purchaseItem['product_id'] : null;
                $purchaseOrderItems->currency = $purchaseItem['currency'];
                $purchaseOrderItems->unit_price = array_key_exists('unit_price', $purchaseItem) ? $purchaseItem['unit_price'] : null;
                $purchaseOrderItems->quantity = array_key_exists('quantity', $purchaseItem) ? $purchaseItem['quantity'] : null;
                $purchaseOrderItems->total = $purchaseItem['total'];
                $purchaseOrderItems->save();
            }
    
        }
        return Redirect::route('purchase-orders.index')->with('success', 'Purchase Order update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', PurchaseOrder::class);

        $purchaseOrder = PurchaseOrder::findOrFail($id);
        PurchaseOrderItem::where('purchase_order_id', $id)->delete();
        Invoiceable::where('invoiceable_id', $id)->delete();
        $purchaseOrder->delete();
                $module = [
                    'message' => '{' . $purchaseOrder->id  .'}',
                    'module' => $purchaseOrder,
                    'activity' => 'Delete',
                    'type' => 'erp',
                    'path' => null,
                ];
        
                $this->logable($module);
        

        return Redirect::route('purchase-orders.index')->with('success', 'Purchase Order delete successfully');
    }

    public function searchSupplier(Request $request)
    {
        $supplier = Company::find($request->id);
        $address = Address::where('addressable_id', $request->id)->first();
    

        return response()->json([
            'supplier' => $supplier,
            'address' => $address
        ]);
    }

    public function searchCustomer(Request $request)
    {
        $customer = Company::find($request->id);
        $address = Address::where('addressable_id', $request->id)->first();

        return response()->json([
            'customer' => $customer,
            'address' => $address
        ]);
    }

    public function deletePurchaseOrderItem(Request $request)
    {
        PurchaseOrderItem::where('id', $request->id)->delete();
        return response()->json([
        ]);
    }

    public function searchInvoices(Request $request)
    {
        $invoices = Invoice::where('invoice_number', 'like', '%' . $request->word . '%')->with(['purchaseOrders', 'purchaseOrders.supplier', 'purchaseOrders.customer', 'purchaseOrders.currency'])->get();

        return response()->json([
            'invoices' => $invoices
        ]);
    }

    public function saveInvoices(Request $request)
    {
        $purchaseOrder = PurchaseOrder::where('id', $request->id)->first(); 

                $currentURL = url()->current();
                 $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $purchaseOrder->id  .'}',
            'module' => $purchaseOrder,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice.'/'.$purchaseOrder->id,
        ];
        $this->logable($module);

        foreach ($request->invoicesId as $id) {
            $purchaseOrder->invoiceable()->create([
                'saas_id' => Auth::user()->company_id,
                'invoice_id' => $id,
            ]);
        }

        return Redirect::route('purchase-orders.show', $request->id)->with('success',
            'Purchase Order invoice save successfully');
    }

    public function editInvoice($urlName, $urlId, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceItem = InvoiceItem::where('invoice_id', $id)->with('product', 'conversion')->get();
        $documents = Documents::where([['documentable_type', '=', 'App\Models\Invoice'], ['documentable_id', '=', $id]])->get();
        $suppliers = Supplier::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        $products = Product::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        $shipments = Shippment::Select('container_number', 'id')->where('company_id', Auth::user()->company_id)->get();
        $customers = Company::Select('name', 'id')->where('id', Auth::user()->company_id)->get();
        $statuses = Lookup::where('type', 'invoice_status')->get();
        $currencys = CurrencyExchange::Select('from_to', 'amount', 'id')->latest('date')->get()->unique('from_to');

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $invoiceItem->id  .'}',
            'module' => $invoiceItem,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Invoices/Create', [
            'suppliers' => $suppliers,
            'currencys' => $currencys,
            'documents' => $documents,
            'products' => $products,
            'shipments' => $shipments,
            'customers' => $customers,
            'statuses' => $statuses,
            'invoiceItem' => $invoiceItem,
            'invoice' => $invoice,
            'routeName' => $urlName,
            'routeId' => $urlId
        ]);
    }

    public function deleteInvoice(Request $request)
    {
        $invoiceable = Invoiceable::where('invoiceable_id', $request->purchaseOrderId)->where('invoice_id',
            $request->purchaseOrderInvoiceId)->first();
        $invoiceable->delete();

        $module = [
            'message' => '{' . $invoiceable->id  .'}',
            'module' => $invoiceable,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);


        return Redirect::route('purchase-orders.show',$request->purchaseOrderId)->with('success',
            'Purchase Order invoice delete successfully');
    }

    public function createPayment($urlName, $urlId, $urlNextName, $invoiceId)
    {
        $suppliers = Supplier::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        $method = Lookup::where('type', 'payment_method')->get();
        $payercurrency = CurrencyExchange::Select('from_to', 'amount', 'id')->latest('date')->get()->unique('from_to');
        $payeeecurrency = CurrencyExchange::Select('from_to', 'amount', 'id')->latest('date')->get()->unique('from_to');
        $invoices = Invoice::select('invoice_number', 'id')->get();
        $payeraccount = accounts::select('first_name', 'last_name', 'id')->get();
        $payeeaccount = accounts::Select('first_name', 'last_name', 'id')->get();


        return Inertia::render('CompanyPayments/Create', [
            'suppliers' => $suppliers,
            'payercurrencys' => $payercurrency,
            'payeeecurrencys' => $payeeecurrency,
            'payeraccounts' => $payeraccount,
            'payeeaccounts' => $payeeaccount,
            'invoices' => $invoices,
            'methods' => $method,
            'routeName' => $urlName,
            'routeId' => $urlId,
            'paymentInvoiceId' => $invoiceId
        ]);
    }

    public function editPayment($urlName, $urlId, $urlNextName, $invoiceId, $paymentId)
    {
        $payment = CompanyPayment::findOrFail($paymentId);
        $suppliers = Supplier::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        $method = Lookup::where('type', 'payment_method')->get();
        $payercurrency = CurrencyExchange::Select('from_to', 'amount', 'id')->latest('date')->get()->unique('from_to');
        $payeeecurrency = CurrencyExchange::Select('from_to', 'amount', 'id')->latest('date')->get()->unique('from_to');
        $invoices = Invoice::select('invoice_number', 'id')->get();
        $payeeaccount = accounts::Select('first_name', 'last_name', 'id')->get();
        $payeraccount = accounts::select('first_name','last_name', 'id')->get();
        $payeeaccount = accounts::Select('first_name','last_name', 'id')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $payment->id  .'}',
            'module' => $payment,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('CompanyPayments/Create', [
            'suppliers' => $suppliers,
            'payercurrencys' => $payercurrency,
            'payeeecurrencys' => $payeeecurrency,
            'payeraccounts' => $payeraccount,
            'payeeaccounts' => $payeeaccount,
            'invoices' => $invoices,
            'methods' => $method,
            'payments' => $payment,
            'routeName' => $urlName,
            'routeId' => $urlId,
            'paymentInvoiceId' => $invoiceId
        ]);
    }

    public function deletePayment(Request $request)
    {
        $payment = CompanyPayment::findOrFail($request->paymentId);
        $payment->delete();

        $module = [
            'message' => '{' . $payment->id  .'}',
            'module' => $payment,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('purchase-orders.show', $request->purchaseOrderId)->with('success', 'Payments deleted successfully');
    }

}
