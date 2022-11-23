<?php

namespace App\Http\Controllers\Admin;

use App\Models\SalesChannel;
use Inertia\Inertia;
use App\Models\Lookup;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\accounts;
use App\Models\Supplier;
use App\Models\Documents;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Models\CompanyPayment;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Models\CurrencyExchange;
use App\Models\ActivityLogsDetails;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class PaymentController extends Controller
{
    use Sort;
    use Search;
    use Filter;
    use Logger;
    use DefaultActiveLog;


    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', CompanyPayment::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Payment',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $payments = CompanyPayment::query();

        $payments = $payments->where('company_id', Auth::user()->company_id);

        $payments = $this->search($payments, [
            'payment_reference',
            'amount',
            'payment_date',
        ]);

        $params = $request->all();

        if ($request->has('query')) {
            $payments = $payments->orWhereHas('company', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('query')) {
            $payments = $payments->orWhereHas('supplier', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('query')) {
            $payments = $payments->orWhereHas('invoice', function (Builder $query) {
                $this->search($query, ['invoice_number']);
            });
        }
        if ($request->has('query')) {
            $payments = $payments->orWhereHas('payeeAccount', function (Builder $query) {
                $this->search($query, ['first_name', 'last_name']);
            });
        }
        if ($request->has('query')) {
            $payments = $payments->orWhereHas('payerAccount', function (Builder $query) {
                $this->search($query, ['first_name', 'last_name']);
            });
        }
        if ($request->has('query')) {
            $payments = $payments->orWhereHas('paymentMethod', function (Builder $query) {
                $this->search($query, ['value']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $payments = $this->sort($payments, $columns, $request->get('direction'));
        }

        $payments = $payments->with(['company', 'supplier', 'customer', 'paymentMethod', 'payeeAccount', 'payerAccount', 'invoice'])->orderBy('id', 'desc')->paginate(10);

        if ($request->has('direction') && $request->get('supplier_id')) {
            $sortedDta = $payments->getCollection()->sortBy(function ($payment) {
                return $payment->supplier->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $payments->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('payer_account_id')) {
            $sortedDta = $payments->getCollection()->sortBy(function ($payment) {
                return $payment->payerAccount->first_name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $payments->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('payee_account_id')) {
            $sortedDta = $payments->getCollection()->sortBy(function ($payment) {
                return $payment->payeeAccount->first_name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $payments->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('invoice_id')) {
            $sortedDta = $payments->getCollection()->sortBy(function ($payment) {
                return $payment->invoice->invoice_number;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $payments->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('payment_method')) {
            $sortedDta = $payments->getCollection()->sortBy(function ($payment) {
                return $payment->paymentMethod->value;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $payments->setCollection(collect($sort));
        }
//        if ($request->has('direction') && $request->get('account_id')) {
//            $sortedDta = $payments->getCollection()->sortBy(function ($payment) {
//                return $payment->account->first_name;
//            }, 3, $request->get('direction') == 'desc' ? true : false);
//            $sort = [];
//            foreach ($sortedDta as $item) {
//                $sort[] = $item;
//            }
//            $payments->setCollection(collect($sort));
//        }
        return Inertia::render('CompanyPayments/Index', [
            'payments' => $payments->withQueryString(),
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
        foreach (['supplier_id',
                     'payee_account_id',
                     'payer_account_id',
                     'transaction_id',
                     'amount',] as $sort) {
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

    /**
     * @param $id
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        $this->authorize('create', CompanyPayment::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Payment',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $suppliers = Company::where('type', 'supplier_company')->where('parent_id', Auth::user()->company_id)->get();
        $method = Lookup::where('type', 'payment_method')->get();
        $payercurrency = Lookup::where('type', 'currency')->get();
        $payeeecurrency = Lookup::where('type', 'currency')->get();
        $payeraccount = accounts::select('first_name', 'last_name', 'id')->get();
        $payeeaccount = accounts::Select('first_name', 'last_name', 'id')->get();
        $invoices = Invoice::select('invoice_number','supplier_id', 'id')->get();
        if ($request->invoice_id) {
            $invoices = $invoices->where('id', $request->invoice_id)->first();
            $suppliers = $suppliers->where('id', $invoices->supplier_id)->first();
        }
        return Inertia::render('CompanyPayments/Create', [
            'suppliers' => $suppliers,
            'payercurrencys' => $payercurrency,
            'payeeecurrencys' => $payeeecurrency,
            'payeraccounts' => $payeraccount,
            'payeeaccounts' => $payeeaccount,
            'invoices' => $invoices,
            'methods' => $method,
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
            'supplier_id' => ['required', 'integer'],
            'payer_account_id' => ['required', 'integer'],
            'payer_currency_id' => ['required', 'string'],
            'payment_method' => ['required', 'string'],
            'payee_account_id' => ['required', 'integer'],
            'payee_currency_id' => ['required', 'string'],
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
//        $conversionrate = CurrencyExchange::where('slug', $payment->payer_currency_id)->first();
//        if ($conversionrate->from_to == 'GBP-CNY') {
//            $payment->conversion_rate_rmb = $conversionrate->amount;
//            $payment->total_rmb = $conversionrate->amount * $request->amount;
//        };
//        if ($conversionrate->from_to == 'GBP-USD') {
//            $payment->conversion_rate_usd = $conversionrate->amount;
//            $payment->total_usd = $conversionrate->amount * $request->amount;
//        };
//        $payment->total_gbp = $request->amount;
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
        $module = [
            'message' => '{' . $payment->id  .'}',
            'module' => $payment,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice.'/'.$payment->id,
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
            'title' => $invoice->invoice_number. '--POP',
            'file' => $path,
            'file_type' => $mimeType,
            'description' => 'Proof of Payment for Invoice# ' . $invoice->invoice_number,
        ]);

        if ($request->route_name === 'purchase-orders') {
            return Redirect::route($request->route_name . '.show', $request->route_id)->with('success', 'Payment create successfully');
        }

        return Redirect::route('invoices.index')->with('success', 'Payments Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $this->authorize('view', CompanyPayment::class);

        $payments = CompanyPayment::with('documents', 'supplier')->where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $payments->id  .'}',
            'module' => $payments,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('CompanyPayments/Show', [
            'payments' => $payments,
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
        $this->authorize('update', CompanyPayment::class);

        $payment = CompanyPayment::with('invoice')->findOrFail($id);
        $method = Lookup::where('type', 'payment_method')->get();
        $invoices = Invoice::select('invoice_number', 'id')->get();
        if($payment->invoice['is_sale']) {
            $suppliers = SalesChannel::get();
            $payeraccount = null;
            $payeeaccount = null;
        } else {
            $suppliers = Company::where('type', 'supplier_company')->where('parent_id', Auth::user()->company_id)->get();
            $payeraccount = accounts::select('first_name', 'last_name', 'id')->get();
            $payeeaccount = accounts::Select('first_name', 'last_name', 'id')->get();
        };
        $payercurrency = Lookup::where('type', 'currency')->get();
        $payeeecurrency =Lookup::where('type', 'currency')->get();

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
            'payments' => $payment
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
            'supplier_id' => ['required'],
            'payer_account_id' => ['required'],
            'payer_currency_id' => ['required'],
            'payment_method' => ['required'],
            'payee_account_id' => ['required'],
            'payee_currency_id' => ['required'],
            'payment_reference' => ['required'],
            'amount' => ['required'],
            'payee_total' => ['required'],
            'payment_date' => ['required'],
        ]);
        $payment = CompanyPayment::findOrFail($id);
        $paymentOld = CompanyPayment::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $payment->id  .'}',
            'module' => $payment,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details = $paymentOld;

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
        $invoice = Invoice::where('id', $request->invoice_id)->first();
        $payment->payer_account_id = $request->payer_account_id;
        $payment->payer_currency_id = $request->payer_currency_id;
//        $conversionrate = CurrencyExchange::where('slug', $payment->payer_currency_id)->first();
//        if ($conversionrate->from_to == 'GBP-CNY') {
//            $payment->conversion_rate_usd = Null;
//            $payment->conversion_rate_rmb = $conversionrate->amount;
//            $payment->total_rmb = $conversionrate->amount * $request->amount;
//        }
//        if ($conversionrate->from_to == 'GBP-USD') {
//            $payment->conversion_rate_rmb = Null;
//            $payment->conversion_rate_usd = $conversionrate->amount;
//            $payment->total_usd = $conversionrate->amount * $request->amount;
//        }
//        $payment->total_gbp = $request->amount;
        $payment->payee_account_id = $request->payee_account_id;
        $payment->payee_currency_id = $request->payee_currency_id;
        $payment->payment_reference = $request->payment_reference;
        $payment->payment_method = $request->payment_method;
        $payment->amount = $request->amount;
        $payment->payee_total = $request->payee_total;
        $payment->payment_date = $request->payment_date;
        $payment->description = $request->description;
        $payment->update();
        $paymentNew = CompanyPayment::where('id', $id)->first();

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
     

        $document = Documents::where([['documentable_id', $payment->id],['documentable_type', 'App\Models\CompanyPayment']])->first();
        // $documentOld = Documents::where('id', $id)->first();

//        $currentURL = url()->current();
//        $slice = Str::after($currentURL, '8000');
//
//        $module = [
//            'message' => '{' . $document->id  .'}',
//            'module' => $document,
//            'activity' => 'Update',
//            'type' => 'erp',
//            'path' => $slice,
//        ];
//        $logData =  $this->logable($module);
//        $details = $documentOld;
//
//		$final_data = json_encode($details);
//
//         $LogDetail = new ActivityLogsDetails();
//         $LogDetail->activity_log_id = $logData->id;
//         $LogDetail->company_id = Auth::user()->company_id;
//         $LogDetail->details = $final_data;
//         $LogDetail->save();

        if ($request->file('file')) {
            $path = 'storage/' . $request->file('file')[0]->store('docoments');
            $files = $request->file('file');
            $mimeType = $files[0]->getClientOriginalExtension();
            $document->company_id = Auth::user() ? Auth::user()->company_id : '';
            $document->title = $invoice->invoice_number. '--POP';
            $document->file = $path;
            $document->description = 'Proof of Payment for Invoice# ' . $invoice->invoice_number;
            $document->file_type = $mimeType;
        } else {
            $document->company_id = Auth::user() ? Auth::user()->company_id : '';
            $document->title = $invoice->invoice_number. '--POP';
            $document->description = 'Proof of Payment for Invoice# ' . $invoice->invoice_number;
        }
        $document->update();

        if ($request->route_name === 'purchase-orders') {
            return Redirect::route($request->route_name . '.show', $request->route_id)->with('success', 'Payment update successfully');
        }

        return Redirect::route('invoices.index')->with('success', 'Company Payments updated successfully');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function viewFile($id, $id2)
    {
        $this->authorize('view', CompanyPayment::class);

        $containerFileView = Documents::where('id', $id2)->firstOrFail();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $containerFileView->id  .'}',
            'module' => $containerFileView,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return response()->file(public_path($containerFileView->file));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function exportFile($id, $id2)
    {
        $this->authorize('view', CompanyPayment::class);

        $containerFileView = Documents::where('id', $id2)->firstOrFail();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $containerFileView->id  .'}',
            'module' => $containerFileView,
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);


        return response()->download(public_path($containerFileView->file));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', CompanyPayment::class);

        $payment = CompanyPayment::findOrFail($id);
        $document = Documents::where([['documentable_id', $payment->id],['documentable_type', 'App\Models\CompanyPayment']])->delete();
        $payment->delete();

        
        $module = [
            'message' => '{' . $payment->id  .'}',
            'module' => $payment,
            'activity' => 'Delete',
            'type' => 'super',
            'path' => null,
        ];
        $this->logable($module);
     
        return Redirect::back()->with('success', 'Company Payments deleted successfully');
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
