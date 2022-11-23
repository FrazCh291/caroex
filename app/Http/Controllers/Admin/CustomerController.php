<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Cases;
use App\Models\Order;
use App\Models\Email;
use App\Models\Lookup;
use App\Models\Review;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Shipment;
use App\Models\accounts;
use App\Models\Delivery;
use App\Models\Documents;
use Illuminate\Support\Str;
use App\Models\InvoiceItem;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use App\Models\EmailSetting;
use App\Models\DeliveryItem;
use App\Services\Traits\Sort;
use App\Models\CompanyPayment;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Models\CurrencyExchange;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLogsDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Services\Traits\DefaultActiveLog;

class CustomerController extends Controller
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
        $this->authorize('viewAny', Customer::class);
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Customer',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $customers = Customer::query();

        
        if ($request->get('ejogga')) {
            $salesChannel = SalesChannel::where('slug', 'ejogga')->get();
            $customers = $request->get('ejogga') ? $customers->where('channel_id', $salesChannel[0]->id) : $customers;
        }
        if ($request->get('wowcher')) {
            $salesChannel = SalesChannel::where('slug', 'wowcher')->get();
            $customers = $request->get('wowcher') ? $customers->orWhere('channel_id', $salesChannel[0]->id) : $customers;
        }
        if ($request->get('gogroopie')) {
            $salesChannel = SalesChannel::where('slug', 'gogroopie')->get();
            $customers = $request->get('gogroopie') ? $customers->orWhere('channel_id', $salesChannel[0]->id) : $customers;
        }
        if ($request->get('xstreamgym')) {
            $salesChannel = SalesChannel::where('slug', 'xstreamgym')->get();
            $customers = $request->get('xstreamgym') ? $customers->orWhere('channel_id', $salesChannel[0]->id) : $customers;
        }
        if ($request->get('groupon')) {
            $salesChannel = SalesChannel::where('slug', 'groupon')->get();
            $customers = $request->get('groupon') ? $customers->orWhere('channel_id', $salesChannel[0]->id) : $customers;
        }
        if ($request->get('amazon')) {
            $salesChannel = SalesChannel::where('slug', 'amazon')->get();
            $customers = $request->get('amazon') ? $customers->orWhere('channel_id', $salesChannel[0]->id) : $customers;
        }
        if ($request->get('boomtekk')) {
            $salesChannel = SalesChannel::where('slug', 'boomtekk')->get();
            $customers = $request->get('boomtekk') ? $customers->orWhere('channel_id', $salesChannel[0]->id) : $customers;
        }
        if ($request->get('tracking')) {
            $salesChannel = SalesChannel::where('slug', 'tracking')->get();
            $customers = $request->get('tracking') ? $customers->orWhere('channel_id', $salesChannel[0]->id) : $customers;
        }

        $customers = $customers->where('company_id', Auth::user()->company_id);
        $customers = $request->get('enable') ? $customers->where('enable', 1) : $customers;
        $customers = $request->get('disable') ? $customers->orWhere('enable', 0) : $customers;
        $customers = $this->search($customers, [
            'name',
            'address1_2',
            'email',
            'house_number',
            'phone',
            'city',
            'postcode',
            'country',
        ]);

        if ($request->has('query')) {
            $customers = $customers->orWhereHas('channel', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        $direction = $request->get('direction');
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $customers = $this->sort($customers, $columns, $request->get('direction'));
        }

        if ($request->has('direction') && $request->get('channel_id')) {
            $customers = $customers->select('customers.id','customers.name', 'customers.address1_2', 'customers.phone', 'customers.email', 'sales_channels.name as channel')
            ->join('sales_channels', 'customers.channel_id', '=', 'sales_channels.id')
            ->orderBy('sales_channels.name',$direction)
            ->paginate(10);
         
        } else {
            $customers = $customers->select('customers.name', 'customers.address1_2', 'customers.phone', 'customers.email', 'sales_channels.name as channel')
            ->join('sales_channels', 'customers.channel_id', '=', 'sales_channels.id')->orderBy('customers.id', 'desc')->paginate(10);
        }

         $salesChannel = SalesChannel::whereIn('id',Customer::distinct('channel_id')->pluck('channel_id')->toArray())->get();

        $params = $request->all();

        return Inertia::render('Customers/Index', [
            'customers' => $customers->withQueryString(),
            'salesChannel'=>$salesChannel,
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
            'name',
            'email',
            'address1_2',
            'house_number',
            'phone',
            'city',
            'postcode',
            'country'
        ] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }

        return $sorts;
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
    
    public function create()
    {
        $chennals = SalesChannel::all();
        return Inertia::render('Customers/Create',[
            'chennals' => $chennals
        ]);
    }

    public function createPayment($customerId, $invoiceId)
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Customers',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $invoices = Invoice::findOrfail($invoiceId);
        $suppliers =  Customer::with('channel')->where('id', $customerId)->first();
        $method = Lookup::where('type', 'payment_method')->get();
        $payercurrency = Lookup::where('type', 'currency')->get();
        $payeeecurrency = Lookup::where('type', 'currency')->get();
        $payeraccount = accounts::select('first_name', 'last_name', 'id')->get();
        $payeeaccount = accounts::Select('first_name', 'last_name', 'id')->get();

        return Inertia::render('Customers/Createpayment', [
            'suppliers' => $suppliers,
            'payercurrencys' => $payercurrency,
            'payeeecurrencys' => $payeeecurrency,
            'payeraccounts' => $payeraccount,
            'payeeaccounts' => $payeeaccount,
            'invoices' => $invoices,
            'methods' => $method,
            'customerId' => $customerId,
        ]);
    }

    
      /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function createReview($id)
    {
        $this->authorize('create',Review::class);

        $customer = Customer::findOrfail($id);
        $products = Product::Select('name', 'id')->orderBy('name')->get();
        $review_statuses = Lookup::where('type', 'review_status')->orderBy('value')->get();
        $salesChannels = SalesChannel::Select('name', 'id')->orderBy('name')->get();
        $currentDate = date("Y-m-d", strtotime(Carbon::today()));
        
        return Inertia::render('Customers/CreateReview',[
            'products' => $products,
            'customer' => $customer,
            'review_statuses' => $review_statuses,
            'salesChannels' => $salesChannels,
            'currentDate' => $currentDate,
            'customer_id' => $id
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'chennal_id' => ['required'],
            'name' => ['required'],
            // 'email' => ['required'],
            // 'address1_2' => ['required'],
            // 'house_number' => ['required'],
            // 'phone' => ['required'],
            // 'city' => ['required'],
            // 'postcode' => ['required'],
            // 'country' => ['required'],
        ]);

        Customer::create([
            'company_id' => Auth::user()->company_id,
            'name' => $request->name,
            'email' => $request->name,
            'channel_id' =>  $request->channel_id,
            'address1_2' => $request->address1_2,
            'house_number' => $request->house_number ,
            'phone' =>  $request->phone,
            'city' =>  $request->city,
            'is_potential_customer' => 1,
            'postcode' =>  $request->postcode,
            'country' => $request->country ,

        ]);

        return redirect()->route('customers.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function InvoiceStore(Request $request)
    {
        $this->validate($request, [
            'supplier_id' => ['required'],
            'order_id' => ['required'],
            'invoice_number' => ['required'],
            'reference_number' => ['required'],
            'date' => ['required'],
            'currency' => ['required'],
        ]);
        $order = Order::where('id', $request->order_id)->first();

        $order->invoices()->create([
            'company_id' => Auth::user()->company_id,
            'customer_id' => $request->customer_id,
            'supplier_id' => $request->supplier_id,
            'invoice_number' => $request->invoice_number,
            'is_sale' => 1,
            'reference_number' => $request->reference_number,
            'invoice_date' => $request->date,
            'currency' => $request->currency,
            'sub_total' => $request->sub_total,
            'vat' => $request->vat,
            'status' => $request->status,
            'balance' => $request->balance,
            'total' => $request->total,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -16);
        
        $module = [
            'message' => '{' .  $order->id  . '}',
            'module' =>  $order,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice1.$order->id,
        ];

        $this->logable($module);

        return redirect()->route('customers.show', $request->customer_id);
    }

    public function storePayment(Request $request)
    {
        $this->validate($request, [
            'supplier_id' => ['required', 'integer'],
            'payer_account_id' => ['required', 'integer'],
            'payer_currency_id' => ['required'],
            'payment_method' => ['required'],
            'payee_account_id' => ['required', 'integer'],
            'payee_currency_id' => ['required'],
            'payment_reference' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'payee_total' => ['required', 'string'],
            'payment_date' => ['required', 'date'],
            'file' => ['required'],
        ]);
        $payment = new CompanyPayment();
        $payment->company_id = Auth::user()->company_id;
        $payment->supplier_id = $request->supplier_id;
        $payment->invoice_id = $request->invoice_id;
        $payment->payer_account_id = $request->payer_account_id;
        $payment->payer_currency_id = $request->payer_currency_id;
        $payment->total_gbp = $request->amount;
        $payment->payee_account_id = $request->payee_account_id;
        $payment->payee_currency_id = $request->payee_currency_id;
        $payment->payment_reference = $request->payment_reference;
        $payment->payment_method = $request->payment_method;
        $payment->amount = $request->amount;
        $payment->payee_total = $request->payee_total;
        $payment->payment_date = $request->payment_date;
        $payment->description = $request->description;
        $payment->save();
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -22);
        
        $module = [
            'message' => '{' . $payment->id  . '}',
            'module' => $payment,
            'activity' => 'Store',
            'type' => 'erp',
            'path' =>  $slice1 . $request->customer_id,
        ];

        $this->logable($module);

        $invoice = Invoice::where('id', $payment->invoice_id)->first();

        if ($request->file('file')) {
            $path = 'storage/' . $request->file('file')[0]->store('docoments');
            $files = $request->file('file');
            $mimeType = $files[0]->getClientOriginalExtension();
        }

        $payment->documents()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'documentable_id' => $payment->id,
            'title' => $invoice->invoice_number . '--POP',
            'file' => $path,
            'file_type' => $mimeType,
            'description' => 'Proof of Payment for Invoice# ' . $invoice->invoice_number,
        ]);

        if ($request->customer_id) {
            return redirect()->route('customers.show', $request->customer_id);
        }
    }

    public function storeCase(Request $request)
    {
        $this->validate($request, [
            'order_id' => ['required'],
            'status' => ['required'],
            'priority' => ['required'],
            'type' => ['required'],
            'customer_id' => ['required'],
            'note' => ['required'],
            'source' => ['required'],
        ]);

        $orders = Order::where('id', $request->order_id)->first();
        $channel_id = $orders['channel_id'];

        $case = new Cases();
        $case->company_id = Auth::user()->company_id;
        $case->order_id = $request->order_id;
        $case->status = $request->status;
        $case->priority = $request->priority;
        $case->channel_id = $channel_id;
        $case->source = $request->source;
        $case->description = $request->note;
        $case->type = $request->type;
        $case->save();
        $case->case_number = str_pad($case->id, 6, 0, STR_PAD_LEFT);
        $case->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -13);
       
        $module = [
            'message' => '{' . $case->id  . '}',
            'module' => $case,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice1.$request->customer_id,
        ];

        $this->logable($module);

        if ($request->source_other) {
            $case->source_other = $request->type_other;
            $case->save();
        }

        return redirect()->route('customers.show', $request->customer_id);
    }


    public function storeReview(Request $request)
    {
        $this->validate($request, [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required'],
        ]);

        $customer = Customer::findOrfail($request->customer_id);
        $review = new Review();
        $review->name = $customer['name'];
        $review->email = $customer['email'];
        $review->company_id = Auth::user()->company_id;
        $review->product_id = $request->product_id;
        $review->channel_id = $request->channel_id;
        $review->customer_id = $request->customer_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->url = $request->url;
        $review->status = $request->status;
        $review->is_active = $request->is_active;
        $review->last_sent_at = $request->last_sent_at;
        $review->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -22);
    
        $module = [
            'message' => '{' . $review->id  . '}',
            'module' => $review,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice1.$request->customer_id,
        ];

        $this->logable($module);

            return Redirect::route('customers.show', $request->customer_id)->with('success', 'Review Create Successfully');
        
    }

    public function storeDocument(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'file' => ['required'],

        ]);
        $filenameWithExt = $request['file'][0]->getClientOriginalName();
        $extension = $request['file'][0]->getClientOriginalExtension();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $fileNameToStore = $filename . '.' . $extension;
        $path = $request['file'][0]->storeAs('customerdocu', $fileNameToStore);
        $customer = Customer::findOrfail($request->customer_id);
        $customer->documents()->create([
            'company_id' => Auth::user()->company_id,
            'documentable_id' => $request->customer_id,
            'title' => $request->title,
            'file' => $path,
            'file_type' => $extension,
            'description' => $request->description
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -14);
      
        $module = [
            'message' => '{' . $customer->id  . '}',
            'module' => $customer,
            'activity' => 'Store',
            'type' => 'erp',
            'path' =>$slice1.$request->customer_id,
        ];

        $this->logable($module);

        return redirect()->route('customers.show', $request->customer_id);
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function ExportDocu($id)
    {
        $DocumentExport = Documents::where('id', $id)->firstOrFail();
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $DocumentExport->id  . '}',
            'module' => $DocumentExport,
            'activity' => 'create',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Storage::download($DocumentExport->file);
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function fileexport($id)
    {
        $DocumentExport = Documents::where('id', $id)->firstOrFail();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $DocumentExport->id  . '}',
            'module' => $DocumentExport,
            'activity' => 'create',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return response()->download(public_path($DocumentExport->file));
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('customer_id', $id)->first();
        if($order){
            $deliveryItem = DeliveryItem::where('order_id', $order->id)->first();
            $delivery = Delivery::where('id', $deliveryItem->delivery_id)->first();
        }else{
            $delivery = null;
        }
        $customer = Customer::with(
            'documents',
            'order.orderItems.product',
            'invoice.statuss',
            'import',
            'reviews',
            'reviews.products',
            'invoice.payments',
            'invoice.documents',
            'channel',
            'invoice.payments.documents',
            'order.case',
            'order.case.documents',
            'order.case.notes',
            'invoice',
            'invoice.supplier'
        )->where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        if($order){
        $module = [
            'message' => '{' . $order->id  . '}',
            'module' => $order,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->logable($module);
    }


        $customerEmail = Customer::Select('email')->where('id', $id)->first();
        $email = Email::where('from_email', $customerEmail['email'])->orWhere('to_email', $customerEmail['email'])->get();
        $supplier = Customer::with('channel')->where('id', $id)->get();
        $products = Product::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        $shipments = Shipment::Select('container_number', 'id')->where('company_id', Auth::user()->company_id)->get();
        $statuses = Lookup::where('type', 'invoice_status')->get();
        $currencys =  Lookup::where('type', 'currency')->get();
        $sources = Lookup::where('type', 'source')->get();
        $priorities = Lookup::where('type', 'priority')->get();
        $case_types = Lookup::where('type', 'case_type')->get();
        $case_statuses = Lookup::where('type', 'case_status')->get();

        return Inertia::render('Customers/Show', [
            'customer' => $customer,
            'sources' => $sources,
            'priorities' => $priorities,
            'case_types' => $case_types,
            'case_statuses' => $case_statuses,
            'suppliers' => $supplier,
            'products' => $products,
            'shipments' => $shipments,
            'statuses' => $statuses,
            'currencys' => $currencys,
            'emails' => $email,
            'delivery' => $delivery
        ]);
    }



    public function showcase($cid, $caseid)
    {
        $cases = Cases::with('order.customer', 'caseItem.product', 'notes.user', 'documents', 'emails.childEmails')->findOrFail($caseid);
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
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Cases/Show', [
            'cases' => $cases,
            'sources' => $sources,
            'priorities' => $priorities,
            'case_types' => $case_types,
            'case_statuses' => $case_statuses,
        ]);
    }



    public function edit($id)
    {
        $customer = Customer::findOrfail($id);
        $chennals = SalesChannel::all();
        return Inertia::render('Customers/Create',[
            'customer' => $customer,
            'chennals' => $chennals
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editinvoice($cid, $iid)
    {
        
        $invoice = Invoice::where([['id', $iid], ['invoiceable_type', 'App\Models\Order']])->first();
        $supplier = Customer::with('channel')->where('id', $cid)->get();
        $customer = Customer::Select('name', 'id')->where('id',   $invoice->customer_id)->first();
        $orders = Order::where('customer_id', $customer->id)->where('id', $invoice['invoiceable_id'])->get();
        $products = Product::Select('name', 'id')->where('company_id', Auth::user()->company_id)->get();
        $statuses = Lookup::where('type', 'invoice_status')->get();
        $currencys =  Lookup::where('type', 'currency')->get();
        $invoiceItem = InvoiceItem::where('invoice_id', $iid)->with('product')->get();
        $documents = Documents::where([['documentable_type', '=', 'App\Models\Invoice'], ['documentable_id', '=', $iid]])->get();

        return Inertia::render('Customers/ShowInvoice', [
            'suppliers' => $supplier,
            'customers' => $customer,
            'products' => $products,
            'orders' => $orders,
            'statuses' => $statuses,
            'currencys' => $currencys,
            'invoice' => $invoice,
            'invoiceItem' => $invoiceItem,
            'documents' =>  $documents
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
     

        $module = [
            'message' => '{' . $iid . '}',
            'module' => $invoice,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);
    }

    public function editPayment($cid, $iid, $id)
    {
        $payment = CompanyPayment::with('invoice')->findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
     

        $module = [
            'message' => '{' . $payment->id  . '}',
            'module' => $payment,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        $method = Lookup::where('type', 'payment_method')->get();
        $invoices = Invoice::select('invoice_number', 'id')->get();
        if ($payment->invoice['is_sale']) {
            $suppliers = SalesChannel::get();
            $payercurrency = Lookup::where('type', 'currency')->get();
            $payeeecurrency =  Lookup::where('type', 'currency')->get();
            $payeraccount = accounts::select('first_name', 'last_name', 'id')->get();
            $payeeaccount = accounts::Select('first_name', 'last_name', 'id')->get();
        } else {
            $suppliers = Customer::with('channel')->where('id',$cid)->first();
            $payercurrency = CurrencyExchange::Select('from_to', 'amount', 'slug')->latest('date')->get()->unique('from_to');
            $payeeecurrency = CurrencyExchange::Select('from_to', 'amount', 'slug')->latest('date')->get()->unique('from_to');
            $payeraccount = accounts::select('first_name', 'last_name', 'id')->get();
            $payeeaccount = accounts::Select('first_name', 'last_name', 'id')->get();
        };
        return Inertia::render('Customers/Createpayment', [
            'suppliers' => $suppliers,
            'payercurrencys' => $payercurrency,
            'payeeecurrencys' => $payeeecurrency,
            'payeraccounts' => $payeraccount,
            'payeeaccounts' => $payeeaccount,
            'invoices' => $invoices,
            'methods' => $method,
            'payments' => $payment,
            'customerId' => $cid,
        ]);
    }

    public function editReview($cid , $id)
    {
        $customer = Customer::findOrfail($cid);
        $review = Review::findorfail($id);
        $products = Product::Select('name', 'id')->orderBy('name')->get();
        $review_statuses = Lookup::where('type', 'review_status')->orderBy('value')->get();
        $salesChannels = SalesChannel::Select('name', 'id')->orderBy('name')->get();
        $currentDate = date("Y-m-d", strtotime(Carbon::today()));
        
        return Inertia::render('Customers/CreateReview',[
            'products' => $products,
            'customer' => $customer,
            'review' => $review,
            'review_statuses' => $review_statuses,
            'salesChannels' => $salesChannels,
            'currentDate' => $currentDate,
            'customer_id' => $id
        ]);
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000'); 

        $module = [
            'message' => '{' . $review->id  . '}',
            'module' => $review,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);
    }

    public function updatePayment(Request $request)
    {
        $this->validate($request, [
            'supplier_id' => ['required', 'integer'],
            'payer_account_id' => ['required', 'integer'],
            'payer_currency_id' => ['required'],
            'payment_method' => ['required'],
            'payee_account_id' => ['required', 'integer'],
            'payee_currency_id' => ['required'],
            'payment_reference' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'payee_total' => ['required', 'string'],
            'payment_date' => ['required', 'date'],
            'file' => ['required'],
        ]);
        $payment = CompanyPayment::findOrfail($request->id);
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -16);

        $module = [
            'message' => '{' . $payment->id  .'}',
            'module' => $payment,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice1.$request->customer_id,
        ];
        $logData =  $this->logable($module);
      
        $details = $payment;

		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 1;
        $LogDetail->details = $final_data;
        $LogDetail->save();
        $payment->company_id = Auth::user()->company_id;
        $payment->supplier_id = $request->supplier_id;
        $payment->invoice_id = $request->invoice_id;
        $payment->payer_account_id = $request->payer_account_id;
        $payment->payer_currency_id = $request->payer_currency_id;
        $payment->total_gbp = $request->amount;
        $payment->payee_account_id = $request->payee_account_id;
        $payment->payee_currency_id = $request->payee_currency_id;
        $payment->payment_reference = $request->payment_reference;
        $payment->payment_method = $request->payment_method;
        $payment->amount = $request->amount;
        $payment->payee_total = $request->payee_total;
        $payment->payment_date = $request->payment_date;
        $payment->description = $request->description;
        $payment->update();
     
        $paymentNew = CompanyPayment::where('id' ,$request->id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $paymentNew;
        
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        $invoice = Invoice::where('id', $payment->invoice_id)->first();

        if ($request->file('file')) {
            $path = 'storage/' . $request->file('file')[0]->store('docoments');
            $files = $request->file('file');
            $mimeType = $files[0]->getClientOriginalExtension();
        }

        $payment->documents()->create([
            'documentable_id'=> $payment->id,
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'title' => $invoice->invoice_number . '--POP',
            'file' => $path,
            'file_type' => $mimeType,
            'description' => 'Proof of Payment for Invoice# ' . $invoice->invoice_number,
        ]);

        if ($request->customer_id) {
            return redirect()->route('customers.show', $request->customer_id);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateInvoice(Request $request, $id)
    { 
        $this->validate($request, [
            'customer_id' => ['required'],
            'supplier_id' => ['required'],
            'invoice_number' => ['required'],
            'invoiceable_id' => ['required'],
            'reference_number' => ['required'],
            'invoice_date' => ['required'],
            'currency' => ['required'],
            'sub_total' => ['required'],
            'vat' => ['required'],
            'status' => ['required'],
            'balance' => ['required'],
            'total' => ['required'],
            'invoiceItems' => ['array', 'required'],
        ]);

        $invoiceOld = Invoice::where('id', $id)->first();
        $invoice = Invoice::findOrFail($id);
       
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -16);
       
        $module = [
            'message' => '{' . $invoice->id  .'}',
            'module' => $invoice,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice1.$request->customer_id.'/invoice'.'/'.$invoice->id ,
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

        $invoice = Invoice::findOrFail($id);
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
                $slice1 = substr($slice, 0, -16);
            
                $module = [
                    'message' => '{' . $invoiceDocOld->id  .'}',
                    'module' => $invoiceDocOld,
                    'activity' => 'Update',
                    'type' => 'erp',
                    'path' => $slice1.$request->customer_id.'/invoice'.'/'.$invoice->id ,
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
                //     $invoiceDocNew= Documents::where([['documentable_id', $id], ['documentable_type', 'App\Models\Invoice']])->first();

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
        if ($request->invoiceItems) {
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
                    $slice1 = substr($slice, 0, -16);

                    $module = [
                        'message' => '{' . $invoiceItem->id  .'}',
                        'module' => $invoiceItem,
                        'activity' => 'Update',
                        'type' => 'erp',
                        'path' => $slice1.$request->customer_id.'/invoice'.'/'.$invoice->id,
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

        return Redirect::route('customers.show', $request->customer_id)->with('success', 'Invoice update successfully');
    }

    public function update(Request $request , $id)
    {
        $this->validate($request, [
            'name' => ['required'],
        ]);

        Customer::where('id', $request->id)->create([
            'company_id' => Auth::user()->company_id,
            'name' => $request->name,
            'email' => $request->name,
            'channel_id' =>  $request->channel_id,
            'address1_2' => $request->address1_2,
            'house_number' => $request->house_number ,
            'phone' =>  $request->phone,
            'city' =>  $request->city,
            'is_potential_customer' => 1,
            'postcode' =>  $request->postcode,
            'country' => $request->country ,

        ]);

        return redirect()->route('customers.index');
    }


    public function updateReview(Request $request)
    {
        $this->validate($request, [
            'channel_id' => ['required'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required'],
        ]);

        $customer = Customer::findOrfail($request->customer_id);
        $review = Review::findorfail($request->id);
        $review->company_id = Auth::user()->company_id;
        $review->name = $customer['name'];
        $review->email = $customer['email'];
        $review->product_id = $request->product_id;
        $review->channel_id = $request->channel_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->url = $request->url;
        $review->status = $request->status;
        $review->is_active = $request->is_active;
        $review->last_sent_at = $request->last_sent_at;

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $slice1 = substr($slice, 0, -17);
   

        $module = [
            'message' => '{' . $review->id  .'}',
            'module' => $review,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice1.$request->customer_id.'/reviews'.'/edit'.'/'.$review->id,
        ];
        $logData =  $this->logable($module);
      
        $details = $review;

		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 1;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        $review->update();

        $reviewNew = Review::where('id' ,$request->id)->first();
       
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $reviewNew;
        
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return Redirect::route('customers.show' , $request->customer_id)->with('success', 'Review Update Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteInvoice($cid, $id)
    {
        $invoiceDel = Invoice::findOrfail($id);
        $invoiceDel->delete();

        $module = [
            'message' => '{' . $invoiceDel->id  . '}',
            'module' => $invoiceDel,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $customer = Customer::findOrfail($id);
        $customer->delete();

        $module = [
            'message' => '{' . $customer->id  . '}',
            'module' => $customer,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);


        return redirect()->route('customers.index');
    }

    public function DeleteDocu($id)
    {

        $documents = Documents::findOrfail($id);
        $documents->delete();

         $module = [
            'message' => '{' . $documents->id  . '}',
            'module' => $documents,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return redirect()->back();
    }

    public function destroyReview($cid, $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        $module = [
            'message' => '{' . $review->id  . '}',
            'module' => $review,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('customers.show', $cid)->with('success', 'Review Delete Successfully');
    }
    public function delcase($id)
    {
        $delCase = Cases::findOrfail($id);
        $delCase->delete();

        $module = [
            'message' => '{' . $delCase->id  . '}',
            'module' => $delCase,
            'activity' => 'Delete',
            'type' => 'erp',
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
        return $this->log($request);
    }
}
