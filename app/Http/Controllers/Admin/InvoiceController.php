<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\Lookup;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Shipment;
use App\Models\Supplier;
use App\Models\Documents;
use Illuminate\Support\Str;
use App\Models\InvoiceItem;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Models\CompanyPayment;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use App\Models\CurrencyExchange;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Database\Eloquent\Builder;

class InvoiceController extends Controller
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
        $this->authorize('viewAny', Invoice::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Invoice',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $invoices = Invoice::query();
        if ($request->get('paid')) {
            $invoices = $request->get('paid') ? $invoices->where('status', 'paid') : $invoices;
        }
        if ($request->get('un_paid')) {
            $invoices = $request->get('un_paid') ? $invoices->orWhere('status', 'un_paid') : $invoices;
        }
        $invoices = $this->search($invoices, [
            'invoice_number',
            'invoice_date',
            'total',
            'currency',
            'status',
        ]);
        if(strtolower($request->get('query')) == 'paid') {
            $invoices = $request->get('query') ? $invoices->orWhere('status', 1) : $invoices;
        }

        if(strtolower($request->get('query')) == 'un_paid') {
            $invoices = $request->get('query') ? $invoices->orWhere('status', 0) : $invoices;
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $invoices = $this->sort($invoices, $columns, $request->get('direction'));
        }
        // if ($request->has('query')) {
        //     $invoices = $invoices->orWhereHas('exchang', function (Builder $query) {
        //         $this->search($query, ['from_to']);
        //     });
        // }
        $invoices = $invoices->with('statuss','payments','customer','supplier', 'suppliers','customers')->orderBy('id', 'desc')->paginate(10);
        // if ($request->has('direction') && $request->get('currency')) {
        //     $sortedDta = $invoices->getCollection()->sortBy(function ($invoices) {
        //         return $invoices->exchang->from_to;
        //     }, 3, $request->get('direction') == 'desc' ? true : false);
        //     $sort = [];
        //     foreach ($sortedDta as $item) {
        //         $sort[] = $item;
        //     }
        //     $invoices->setCollection(collect($sort));
        // }
        $params = $request->all();
        return Inertia::render('Invoices/Index',[
            'invoices' => $invoices->withQueryString(),
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
        foreach ([
            'invoice_number',
            'invoice_date',
            'total',
            'currency',
            'status'

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', Invoice::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Invoice',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $suppliers = Company::where('type', 'supplier_company')->where('parent_id', Auth::user()->company_id)->get();
        $products = Product::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        $shipments = Shipment::Select('container_number', 'id')->where('company_id', Auth::user()->company_id)->get();
        $customers = Company::Select('name', 'id')->where('id', Auth::user()->company_id)->get();
        $statuses = Lookup::where('type', 'invoice_status')->get();
        $currencys =  Lookup::where('type', 'currency')->get();

        return Inertia::render('Invoices/Create', [
            'suppliers' => $suppliers,
            'currencys' => $currencys,
            'products' => $products,
            'shipments' => $shipments,
            'customers' => $customers,
            'statuses' => $statuses
        ]);
    }
    /**
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
            'invoiceable_id' => ['required'],
            'invoice_number' => ['required'],
            'reference_number' => ['required'],
            'invoice_date' => ['required'],
            'currency' => ['required'],
            'invoiceItems' => ['array','required'],
             'status' => ['required'],
        ]);

        $shipment = Shipment::where('id', $request->invoiceable_id)->first();

        $invoice = $shipment->invoices()->create([
            'company_id' => Auth::user()->company_id,
            'customer_id' => $request->customer_id,
            'supplier_id' => $request->supplier_id,
            'invoice_number' => $request->invoice_number,
            'reference_number' => $request->reference_number,
            'invoice_date' => $request->invoice_date,
            'currency' => $request->currency,
            'sub_total' => $request->sub_total,
            'vat' => $request->vat,
            'status' => $request->status,
            'balance' => $request->balance,
            'total' => $request->total,
        ]);
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $invoice->id  .'}',
            'module' => $invoice,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        if ($request->invoiceDocs) {
            foreach ($request->invoiceDocs as $invoiceDoc) {
                if ($invoiceDoc['files']) {
                    $path = 'storage/' . $invoiceDoc['files'][0]->store('docoments');
                    $files = $invoiceDoc['files'];
                    $mimeType = $files[0]->getClientOriginalExtension();
                }

                $invoiceDocu = $invoice->documents()->create([
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'title' => $invoiceDoc['title'],
                    'file' => $path,
                    'file_type' => $mimeType,
                    'description' => $invoiceDoc['description'],
                ]);

                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');
                $module = [
                    'message' => '{' . $invoiceDocu->id  .'}',
                    'module' => $invoiceDocu,
                    'activity' => 'Store',
                    'type' => 'erp',
                    'path' => $slice,
                ];

                $this->logable($module);

          }
        }
        if ($request->invoiceItems) {
            foreach ($request->invoiceItems as $invoiceIte) {
                $invoiceItem = new InvoiceItem();
                $invoiceItem->company_id = Auth::user()->company_id;
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->product_id = $invoiceIte['product_id'];
                $invoiceItem->item_name = $invoiceIte['product_name'];
                $invoiceItem->currency = $invoiceIte['currency'];
                $invoiceItem->unit_price = $invoiceIte['unit_price'];
                $invoiceItem->quantity = $invoiceIte['quantity'];
                $invoiceItem->total = $invoiceIte['total'];
                $invoiceItem->save();

                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');
                $module = [
                    'message' => '{' . $invoiceItem->id  .'}',
                    'module' => $invoiceItem,
                    'activity' => 'Store',
                    'type' => 'erp',
                    'path' => $slice,
                ];

                $this->logable($module);
            }
        }

        return Redirect::route('invoices.index')->with('success', 'Invoice create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Invoice::class);


        $invoice = Invoice::findOrFail($id);
        $invoiceItem = InvoiceItem::where('invoice_id', $id)->with('product', 'conversion')->get();
        $documents = Documents::where([['documentable_type', '=', 'App\Models\Invoice'], ['documentable_id', '=', $id]])->get();
        $suppliers = Company::where('type', 'supplier_company')->where('parent_id', Auth::user()->company_id)->get();
        $products = Product::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        $shipments = Shipment::Select('container_number', 'id')->where('company_id', Auth::user()->company_id)->get();
        $customers = Company::Select('name', 'id')->where('id', Auth::user()->company_id)->get();
        $statuses = Lookup::where('type', 'invoice_status')->get();
        $currencys = CurrencyExchange::Select('from_to', 'amount', 'id')->latest('date')->get()->unique('from_to');

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $invoice->id  .'}',
            'module' => $invoice,
            'activity' => 'Show',
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
            'invoice' => $invoice
        ]);



        //    $invoice = Invoice::where('id', $id)->with(['addresses', 'addressess', 'invoiceable'])->first();
        //    $invoiceItems = InvoiceItem::where('invoice_id', $id)->get();

        //    return Inertia::render('Invoices/Show', [
        //        'id' => $id,
        //        'invoice' => $invoice,
        //        'invoiceItems' => $invoiceItems
        //    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Invoice::class);

        $invoice = Invoice::findOrFail($id);
        $invoiceItem = InvoiceItem::where('invoice_id', $id)->with('product')->get();
        $documents = Documents::where([['documentable_type', '=', 'App\Models\Invoice'], ['documentable_id', '=', $id]])->get();
        if($invoice->is_sale == 1){
            $suppliers = SalesChannel::Select('name', 'id')->get();
            $shipments = Order::Select('order_number', 'id')->where('company_id', Auth::user()->company_id)->get();
            $customers = Customer::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        } else {
            $suppliers = Company::where('type', 'supplier_company')->where('parent_id', Auth::user()->company_id)->get();
            $shipments = Shipment::Select('container_number', 'id')->where('company_id', Auth::user()->company_id)->get();
            $customers = Company::Select('name', 'id')->where('id', Auth::user()->company_id)->get();
        }
        $products = Product::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        $statuses = Lookup::where('type', 'invoice_status')->get();
        $currencys =  Lookup::where('type', 'currency')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $invoice->id  .'}',
            'module' => $invoice,
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
            'invoice' => $invoice
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
            'invoice_number' => ['required'],
            'reference_number' => ['required'],
            'invoice_date' => ['required'],
            'currency' => ['required'],
            'sub_total' => ['required'],
            'vat' => ['required'],
            'status' => ['required'],
            'balance' => ['required'],
            'total' => ['required'],
        ]);

        $invoiceOld = Invoice::where('id', $id)->first();
        $invoice = Invoice::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $invoice->id  .'}',
            'module' => $invoice,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice.'/edit',
        ];
        $logData =  $this->logable($module);
        $details = $invoiceOld;

		$final_data = json_encode($details);

         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

        $invoice->company_id = $request->company_id;
        $invoice->customer_id = $request->customer_id;
        $invoice->supplier_id = $request->supplier_id;
        $invoice->invoice_number = $request->invoice_number;
        $invoice->reference_number = $request->reference_number;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->currency = $request->currency;
        $invoice->conversion_rate = $request->conversion_rate;
        $invoice->sub_total = $request->sub_total;
        $invoice->vat = $request->vat;
        $invoice->status = $request->status;
        $invoice->balance = $request->balance;
        $invoice->total = $request->total;
        $invoice->update();

         $currentURL = url()->current();
         $slice = Str::after($currentURL, '8000');

        $details = $invoice;
		$final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();


        if ($request->invoiceDocs) {
            foreach ($request->invoiceDocs as $invoiceDoc) {
                // $invoiceDocOld = Documents::where([['documentable_id', $id], ['documentable_type', 'App\Models\Invoice']])->first();
                $invoiceDocOld = Documents::where('id', $id)->first();
                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');

                $module = [
                    'message' => '{' . $invoiceDocOld->id  .'}',
                    'module' => $invoiceDocOld,
                    'activity' => 'Update',
                    'type' => 'erp',
                    'path' => $slice.'/edit',
                ];
                $logData =  $this->logable($module);
                $details = $invoiceDocOld;

                $final_data = json_encode($details);

                $LogDetail = new ActivityLogsDetails();
                $LogDetail->activity_log_id = $logData->id;
                $LogDetail->company_id = Auth::user()->company_id;
                $LogDetail->details = $final_data;
                $LogDetail->is_old = 1;
                $LogDetail->save();
                if (array_key_exists('id', $invoiceDoc) && array_key_exists('documentable_id', $invoiceDoc)) {
                    if ($invoiceDoc['file'][0] == 's') {
                        if ($invoiceDoc['file']) {
                            $path = $invoiceDoc['file'];
                        }
                    } else {
                        if ($invoiceDoc['files']) {
                            $path = 'storage/' . $invoiceDoc['files'][0]->store('docoments');
                            $files = $invoiceDoc['files'];
                            $mimeType = $files[0]->getClientOriginalExtension();
                        }
                    }
                    $invoiceDoc = Documents::updateOrCreate(
                        [
                            'id' => $invoiceDoc['id'],
                            'documentable_id' => $invoiceDoc['documentable_id'],
                            'documentable_type' => 'App\Models\Invoice'
                        ],
                        [
                            'company_id' => Auth::user() ? Auth::user()->company_id : '',
                            'title' => $invoiceDoc['title'],
                            'file' => $path,
                            'description' => $invoiceDoc['description'],
                        ]
                    );
                    $currentURL = url()->current();
                    $slice = Str::after($currentURL, '8000');

                   $details = $invoiceDoc;
                   $final_data = json_encode($details);

                   $LogDetail = new ActivityLogsDetails();
                   $LogDetail->company_id = Auth::user()->company_id;
                   $LogDetail->activity_log_id = $logData->id;
                   $LogDetail->is_old = 0;
                   $LogDetail->details = $final_data;
                   $LogDetail->save();
                } else {
                    if ($invoiceDoc['files']) {
                        $path = 'storage/' . $invoiceDoc['files'][0]->store('docoments');
                        $files = $invoiceDoc['files'];
                        $mimeType = $files[0]->getClientOriginalExtension();
                    }
                    $invoice->documents()->create([
                        'company_id' => Auth::user() ? Auth::user()->company_id : '',
                        'title' => $invoiceDoc['title'],
                        'file' => $path,
                        'file_type' => $mimeType,
                        'description' => $invoiceDoc['description'],
                    ]);
                 $invoiceDoc = Documents::orderBy('id', 'desc')->first();
                }

            }
        }
        if($request->invoiceItems) {
            foreach ($request->invoiceItems as $invoiceIte) {
                if (array_key_exists('id', $invoiceIte) && array_key_exists('invoice_id', $invoiceIte)) {
                    $invoiceItemOld = InvoiceItem::where('id', $invoiceIte['id'])->first();
                    $invoiceItem = InvoiceItem::updateOrCreate(
                        [
                            'id' => $invoiceIte['id'],
                            'invoice_id' => $invoiceIte['invoice_id'],
                        ],
                        [
                            'company_id' => Auth::user()->company_id,
                            'invoice_id' => $id,
                            'product_id' => $invoiceIte['product_id'],
                            'item_name' => $invoiceIte['item_name'],
                            'currency' => $invoiceIte['currency'],
                            'unit_price' => $invoiceIte['unit_price'],
                            'quantity' => $invoiceIte['quantity'],
                            'total' => $invoiceIte['total'],
                        ]
                    );
                    $invoiceItemNew = InvoiceItem::where('id', $invoiceIte['id'])->first();

                    $currentURL = url()->current();
                    $slice = Str::after($currentURL, '8000');

                    $module = [
                        'message' => '{' . $invoiceItem->id  .'}',
                        'module' => $invoiceItem,
                        'activity' => 'Update',
                        'type' => 'erp',
                        'path' => $slice.'/edit',
                    ];
                    $logData =  $this->logable($module);
                    $details = $invoiceItemOld;

                    $final_data = json_encode($details);

                    $LogDetail = new ActivityLogsDetails();
                    $LogDetail->activity_log_id = $logData->id;
                    $LogDetail->company_id = Auth::user()->company_id;
                    $LogDetail->details = $final_data;
                    $LogDetail->is_old = 1;
                    $LogDetail->save();

                    $currentURL = url()->current();
                    $slice = Str::after($currentURL, '8000');

                   $details =  $invoiceItemNew;
                   $final_data = json_encode($details);

                   $LogDetail = new ActivityLogsDetails();
                   $LogDetail->company_id = Auth::user()->company_id;
                   $LogDetail->activity_log_id = $logData->id;
                   $LogDetail->is_old = 0;
                   $LogDetail->details = $final_data;
                   $LogDetail->save();
                } else {
                    $invoiceItem = InvoiceItem::updateOrCreate([
                        'company_id' => Auth::user()->company_id,
                        'invoice_id' => $id,
                        'product_id' => $invoiceIte['product_id'],
                        'item_name' => $invoiceIte['product_name'],
                        'currency' => $invoiceIte['currency'],
                        'unit_price' => $invoiceIte['unit_price'],
                        'quantity' => $invoiceIte['quantity'],
                        'total' => $invoiceIte['total']
                    ]);
                };

            };
        }

        if ($request->route_name === 'purchase-orders') {
            return Redirect::route($request->route_name . '.show', $request->route_id)->with('success', 'Invoice update successfully');
        }

         return Redirect::route('invoices.index')->with('success', 'Invoice update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', Invoice::class);

        $invoice = Invoice::findOrFail($id);
        InvoiceItem::where('invoice_id', $id)->delete();
        CompanyPayment::where('invoice_id', $id)->delete();
        Documents::where([['documentable_type', '=', 'App\Modles\Invoice'], ['documentable_id', '=', $id]])->delete();
        $invoice->delete();

        $module = [
            'message' => '{' . $invoice->id  .'}',
            'module' => $invoice,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::back()->with('success', 'Invoice deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function itemDelete($id)
    {
        $invoiceItem = InvoiceItem::findOrFail($id);
        $invoiceItem->delete();

        $module = [
            'message' => '{' . $invoiceItem->id  .'}',
            'module' => $invoiceItem,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::back()->with('success', 'Invoice Item deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function docDelete($id)
    {
        $document = Documents::findOrFail($id);
        $document->delete();

        $module = [
            'message' => '{' . $document->id  .'}',
            'module' => $document,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::back()->with('success', 'Invoice Item deleted successfully');
    }

    /**
     * @param $id
     * @return mixed
     *
     */
    public function invoiceReportExport($id)
    {
        $invoice = Invoice::where('id', $id)->with('invoiceItems', 'supplier', 'exchang', 'customer', 'statuss')->first();
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape');

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $invoice->id  .'}',
            'module' => $invoice,
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        //
        //        $total = 0;
        //        foreach ($invoice->invoiceItems as $invoiceItem) {
        //            $total = $total + ($invoiceItem->carton * $invoiceItem->quantity * $invoiceItem->unit_price);
        //        }
        return view('invoices.invoice', [
            'invoice' => $invoice,
        ]);

        return $pdf->loadView('invoices.invoice', ['invoice' => $invoice])->download('Invoice.pdf', Excel::DOMPDF);
    }
}
