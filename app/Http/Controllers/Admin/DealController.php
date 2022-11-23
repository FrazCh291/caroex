<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Deal;
use App\Models\Order;
use App\Models\Lookup;
use App\Models\Product;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\accounts;
use App\Models\OrderItem;
use App\Models\Documents;
use Illuminate\Support\Str;
use App\Models\InvoiceItem;
use App\Models\SalesChannel;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\DealsProducts;
use App\Services\Traits\Sort;
use App\Models\CompanyPayment;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use App\Models\DealsProductsRates;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class DealController extends Controller
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
        $this->authorize('viewAny', Deal::class);
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Deal',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);
        $deals = Deal::query();
        $activeLog = ActivityLog::query();
        if ($request->get('create')) {
            $deals = $request->get('create') ? $activeLog->where('activity', 'Create') : $deals;
        }
        if ($request->get('gogroopie')) {
            $deals = $request->get('gogroopie') ? $deals->orWhere('channel_name', 'Gogroopie') : $deals;
        }
        if ($request->get('groupon')) {
            $deals = $request->get('groupon') ? $deals->orWhere('channel_name', 'Groupon') : $deals;
        }
        if ($request->get('wowcher')) {
            $deals = $request->get('wowcher') ? $deals->orWhere('channel_name', 'Wowcher') : $deals;
        }
        $deals = $deals->with('orders', 'dealProducts.dealProductsRates')->where('company_id', Auth::user()->company_id);
        $salesChannel = SalesChannel::all();

        $deals = $request->get('enable') ? $deals->where('status', 1) : $deals;
        $deals = $request->get('disable') ? $deals->orWhere('status', 0) : $deals;

        $deals = $this->search($deals, [
            'deal_number',
            'channel_name',
            'deal_type',
            'signed_by_supplier_name',
            'signed_by_customer_name',
            'contract_signed_at',
        ]);

        if ($request->has('query')) {
            $deals = $deals->orWhereHas('dealProducts.product', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $deals = $this->sort($deals, $columns, $request->get('direction'));
        }

        $deals = $deals->orderBy('id', 'DESC')->paginate(10);
        $deals1 = Deal::distinct('channel_name')->pluck('channel_name')->toArray();

        if ($request->has('direction') && $request->get('product_id')) {
            $sortedDta = $deals->getCollection()->sortBy(function ($deals) {
                return $deals->product->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $deals->setCollection(collect($sort));
        }

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        $params['gogroopie'] = $request->get('gogroopie') == 'true' ? 'true' : '';
        $params['groupon'] = $request->get('groupon') == 'true' ? 'true' : '';
        $params['wowcher'] = $request->get('wowcher') == 'true' ? 'true' : '';

        return Inertia::render('Deal/Index', [
            'params' => $params,
            'salesChannel' => $salesChannel,
            'deals1' => $deals1,
            'deals' => $deals->withQueryString()
        ]);
    }

    public function sortables(Request $request)
    {
        $sorts = [];
        foreach (['id', 'signed_by_customer_name', 'channel_name', 'signed_by_supplier_name'] as $sort) {
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
        $this->authorize('create', Deal::class);

        $products = Product::select('id', 'name', 'sku', 'image')->orderBy('name', 'asc')->orderBy('sku', 'asc')->get();
        $channelTitle = SalesChannel::select('id', 'name')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Deal',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);


        return Inertia::render('Deal/Create', [
            'products' => $products,
            'channelTitles' => $channelTitle
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function createDocuments($id)
    {
        $this->authorize('create', Deal::class);

        $deal = Deal::with('documents')->where('id', $id)->first();

        //        $currentURL = url()->current();
        //        $slice = Str::after($currentURL, '8000');
        //
        //        $module = [
        //            'message' => '{' . $deal->id . '}',
        //            'module' => $deal,
        //            'activity' => 'Create',
        //            'type' => 'erp',
        //            'path' => $slice . '/' . $deal->id,
        //        ];
        //
        //        $this->logable($module);

        return Inertia::render('Deal/FileCreate', [
            'deal' => $deal
        ]);
    }

    public function addPayments($id)
    {
        $companyId = Auth::user()->company_id;
        $deal = Deal::where('deal_number', $id)->first();
        $channels = SalesChannel::select('id', 'name')->get();
        $paymentMethods = Lookup::where('type', 'payment_methods')->get();
        $accounts = accounts::where('company_id', $companyId)->get();
        $invoices = Invoice::where([
            ['invoiceable_type', '=', 'App\Modles\Deal'],
            ['invoiceable_id', '=', $deal->id]
        ])->get();
        $dealInvoice = Invoice::where('invoiceable_id', '=', $deal->id)->first();

        return Inertia::render('Deal/CreatePayment', [
            'channels' => $channels,
            'invoices' => $invoices,
            'paymentMethods' => $paymentMethods,
            'accounts' => $accounts,
            'dealInvoice' => $dealInvoice
        ]);
    }

    public function paymentStore(Request $request)
    {
        $dealPayment = new CompanyPayment();
        $dealPayment->company_id = Auth::user() ? Auth::user()->company_id : '';
        $dealPayment->channel_id = $request->channel_id;
        $dealPayment->invoice_id = $request->invoice_id;
        $dealPayment->payee_account_id = $request->payee_account_id;
        $dealPayment->payer_account_id = $request->payer_account_id;
        $dealPayment->payer_ammount = $request->payer_ammount;
        $dealPayment->date = $request->date;
        $dealPayment->payment_reference = $request->payment_reference;
        $dealPayment->payment_method = $request->payment_method;
        $dealPayment->notes = $request->notes;
        $dealPayment->save();

        //        $currentURL = url()->current();
        //        $slice = Str::after($currentURL, '8000');
        //
        //        $module = [
        //            'message' => '{' . $dealPayment->id . '}',
        //            'module' => $dealPayment,
        //            'activity' => 'Store',
        //            'type' => 'erp',
        //            'path' => $slice . '/' . $dealPayment->id,
        //        ];
        //
        //        $this->logable($module);

        $dealPayment = CompanyPayment::where('id', $request->get('deal_invoice_id'))->first();
        if ($request->file('payment_proof')) {
            $path = 'storage/' . $request->file('payment_proof')[0]->store('paymentProve');
            $files = $request->file('payment_proof');
            $mimeType = $files[0]->getClientOriginalExtension();
            $paymentDocuments = CompanyPayment::find($dealPayment->id);
            $paymentDocuments->documents()->create([
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'file' => $path,
                'file_type' => $mimeType,
            ]);
        }

        return Redirect::route('deals.index')->with('success', 'Deal created successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'deal_number' => ['required', 'string', 'unique:deals,deal_number'],
                'channel_name' => ['required'],
                'contract_signed_at' => ['required'],
                'dealItems' => ['array', 'required'],
                'dealItems.*.product_id' => ['required', 'integer'],
                'dealItems.*.product_title' => ['required', 'string'],
                'dealItemsRate' => ['array', 'required'],
                'dealItemsRate.*.deal_price' => ['required', 'numeric'],
                'dealItemsRate.*.plateform_fee' => ['required', 'numeric'],
            ],
        );

        $deal = new Deal();
        $deal->deal_type = $request->deal_type;
        $deal->company_id = Auth::user() ? Auth::user()->company_id : '';
        $deal->channel_name = $request->channel_name;
        $deal->email = $request->email;
        $deal->address = $request->address;
        $deal->deal_number = $request->deal_number;
        $deal->deal_title = $request->deal_title;
        $deal->account_manager = $request->account_manager;
        $deal->category = $request->category;
        $deal->subcategory = $request->subcategory;
        $deal->start_date = $request->start_date;
        $deal->contract_signed_at = $request->contract_signed_at;
        $deal->gross_revenue = $request->gross_revenue;
        $deal->redeemed_units = $request->redeemed_units;
        $deal->refunded_units = $request->refunded_units;
        $deal->refund_rate = $request->refund_rate;
        $deal->auv = $request->auv;
        $deal->signed_by_supplier_name = $request->signed_by_supplier_name;
        $deal->signed_by_customer_name = $request->signed_by_customer_name;
        $deal->save();

        //    $currentURL = url()->current();
        //    $slice = Str::after($currentURL, '8000');

        //    $module = [
        //        'message' => '{' . $deal->id . '}',
        //        'module' => $deal,
        //        'activity' => 'Store',
        //        'type' => 'erp',
        //        'path' => $slice . '/' . $deal->id,
        //    ];

        //    $this->logable($module);

        foreach ($request->dealDocs as $doc) {
            if ($doc['files']) {
                $files = $doc['files'];
                $mimeType = strtolower($files[0]->getClientOriginalExtension());
                $newName = str_replace("-", "", str_replace(" ", "_", strtolower($doc['title'])));
                $hash = Str::random(40);
                $newName = $newName . "_" . $hash . "." . $mimeType;
                $path = 'storage/' . $files[0]->storeAs('deals', $newName);
            }

            $deal->documents()->create([
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'user_id' => Auth::user() ? Auth::user()->id : '',
                'title' => $doc['title'],
                'file' => $path,
                'file_type' => $mimeType,
                'description' => $doc['description'],
            ]);
        }
        if ($request->dealItems) {
            foreach ($request->dealItems as $key => $item) {

                $deatItemId = $item['id'];

                $dealProduct = new DealsProducts();
                $dealProduct->deal_id = $deal->id;
                $dealProduct->deal_number = $request->deal_number;
                $dealProduct->product_id = $item['product_id'];
                $dealProduct->product_title = $item['product_title'];
                $dealProduct->product_code = $item['product_code'];
                $dealProduct->link = $item['link'];
                $dealProduct->save();

                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');

                $module = [
                    'message' => '{' . $dealProduct->id . '}',
                    'module' => $dealProduct,
                    'activity' => 'Store',
                    'type' => 'erp',
                    'path' => $slice . '/' . $dealProduct->id,
                ];

                $this->logable($module);

                foreach ($request->dealItemsRate as $dealItemsRat) {
                    if ($dealItemsRat['dealProduct'] == $item['product_name']) {
                        $vat = $dealItemsRat['deal_price'] * 20 / 120;
                        $unitPriceCommition = $dealItemsRat['deal_price'] * $dealItemsRat['plateform_fee'] / 100;
                        $vatPriceCommition = $unitPriceCommition * 20 / 100;
                        $total_receivable = $dealItemsRat['deal_price'] + $dealItemsRat['standard_postage'] - $unitPriceCommition - $vatPriceCommition;
                        $deal_price = $dealItemsRat['deal_price'];
                        $p_p_vat = $dealItemsRat['standard_postage'] * 20 / 120;
                        $vat_amount = $vat + $p_p_vat;
                        $exclusive_text_amount = $dealItemsRat['deal_price'] - $vat;
                        $commission_amount = $dealItemsRat['deal_price'] * $dealItemsRat['plateform_fee'] / 100;
                        $vat_deduct_commission = $commission_amount * 20 / 100;
                        $total_net_vat = $vat_amount - $vat_deduct_commission;
                        $vat = number_format((float)$vat, 2, '.', '');
                        $total_receivable = number_format((float)$total_receivable, 2, '.', '');
                        $deal_price = number_format((float)$deal_price, 2, '.', '');
                        $p_p_vat = number_format((float)$p_p_vat, 2, '.', '');
                        $vat_amount = number_format((float)$vat_amount, 2, '.', '');
                        $exclusive_text_amount = number_format((float)$exclusive_text_amount, 2, '.', '');
                        $commission_amount = number_format((float)$commission_amount, 2, '.', '');
                        $vat_deduct_commission = number_format((float)$vat_deduct_commission, 2, '.', '');
                        $total_net_vat = number_format((float)$total_net_vat, 2, '.', '');

                        $dealProductRate = new DealsProductsRates();
                        $dealProductRate->deal_product_id = $dealProduct->id;
                        $dealProductRate->deal_number = $request->deal_number;
                        $dealProductRate->deal_price = $dealItemsRat['deal_price'];
                        $dealProductRate->plateform_fee = $dealItemsRat['plateform_fee'];
                        $dealProductRate->standard_postage = $dealItemsRat['standard_postage'];
                        if (isset($dealItemsRat['standard_incremental_unit_fee'])) {
                            $dealProductRate->standard_incremental_unit_fee = $dealItemsRat['standard_incremental_unit_fee'];
                        }
                        if (isset($dealItemsRat['deal_cap'])) {
                            $dealProductRate->deal_cap = $dealItemsRat['deal_cap'];
                        }
                        if (isset($dealItemsRat['highlands_postage'])) {
                            $dealProductRate->highlands_postage = $dealItemsRat['highlands_postage'];
                        }
                        if (isset($dealItemsRat['market_fee_percentage_rate'])) {
                            $dealProductRate->market_fee_percentage_rate = $dealItemsRat['market_fee_percentage_rate'];
                        }
                        $dealProductRate->vat = $vat;
                        $dealProductRate->exclusive_text_amount = $exclusive_text_amount;
                        $dealProductRate->p_p_vat = $p_p_vat;
                        $dealProductRate->vat_amount = $vat_amount;
                        $dealProductRate->commission_amount = $commission_amount;
                        $dealProductRate->vat_deduct_commission = $vat_deduct_commission;
                        $dealProductRate->total_net_vat = $total_net_vat;
                        $dealProductRate->contract_signed_at = $request->contract_signed_at;
                        $dealProductRate->total_receivable = $total_receivable;
                        $dealProductRate->start_date = $dealItemsRat['start_date'];
                        $dealProductRate->end_date = $dealItemsRat['end_date'];
                        $dealProductRate->is_primary = 1;
                        $dealProductRate->is_active = 1;
                        $dealProductRate->save();

                        //     $currentURL = url()->current();
                        //     $slice = Str::after($currentURL, '8000');
                        //     $module = [
                        //         'message' => '{' . $dealProductRate->id . '}',
                        //         'module' => $dealProductRate,
                        //         'activity' => 'Store',
                        //         'type' => 'erp',
                        //         'path' => $slice . '/' . $dealProductRate->id,
                        //     ];

                        //    $this->logable($module);

                        OrderItem::whereHas('order', function ($query) use ($deal, $dealProduct, $dealProductRate) {
                            $query->where([['deal_id', $deal->deal_number], ['product_id', $dealProduct->product_id]])
                                ->whereDate('order_date', '>=', $dealProductRate->start_date);
                        })->where('deal_product_rate_id', null)->update(['deal_product_rate_id' => $dealProductRate->id]);
                    }
                }
            }
        }

        return Redirect::route('deals.index')->with('success', 'Deal created successfully');
    }

    public function dealItemCreate(Request $request)
    {
        $deal = Deal::with('dealProducts.product')->where('id', $request->deal_id)->first();
        $dealproducts = new DealsProducts();
        $dealproducts->deal_id = $deal->id;
        $dealproducts->product_id = $request->product_id;
        $dealproducts->deal_number = $deal->deal_number;
        $dealproducts->product_title = $request->product_title;
        $dealproducts->product_code = $request->product_code;
        $dealproducts->link = $request->link;
        $dealproducts->save();

        return Redirect::route('deals.show', $dealproducts->deal_number)->with('success', 'Deal Product added successfully');
    }

    public function dealRateCreate(Request $request)
    {
        $vat = $request->deal_price * 20 / 120;
        $unitPriceCommition = $request->deal_price * $request->plateform_fee / 100;
        $vatPriceCommition = $unitPriceCommition * 20 / 100;
        $total_receivable = $request->deal_price + $request->standard_postage - $unitPriceCommition - $vatPriceCommition;
        $deal_price = $request->deal_price + $request->standard_postage;
        $p_p_vat = $request->standard_postage * 20 / 120;
        $vat_amount = $vat + $p_p_vat;
        $exclusive_text_amount = $request->deal_price - $vat;
        $commission_amount = $request->deal_price * $request->plateform_fee / 100;

        $vat_deduct_commission = $commission_amount * 20 / 100;
        $total_net_vat = $vat_amount - $vat_deduct_commission;
        $vatam = number_format((float)$vat, 2, '.', '');
        $total_receivable = number_format((float)$total_receivable, 2, '.', '');
        $deal_price = number_format((float)$deal_price, 2, '.', '');
        $p_p_vat = number_format((float)$p_p_vat, 2, '.', '');
        $vat_amount = number_format((float)$vat_amount, 2, '.', '');
        $exclusive_text_amount = number_format((float)$exclusive_text_amount, 2, '.', '');
        $commission_amount = number_format((float)$commission_amount, 2, '.', '');
        $vat_deduct_commission = number_format((float)$vat_deduct_commission, 2, '.', '');
        $total_net_vat = number_format((float)$total_net_vat, 2, '.', '');

        $dealProduct = DealsProducts::where('product_id', $request->product_id)->where('deal_id', $request->deal_id)->first();
        $rate = DealsProductsRates::where([['deal_product_id', $dealProduct->id], ['is_active', 1]])->first();

        if ($rate) {
            $rate->update(['is_active' => 0]);
        }
        $dealProductRate = new DealsProductsRates();
        $dealProductRate->deal_product_id = $dealProduct->id;
        $dealProductRate->deal_number = $dealProduct->deal_number;
        if (isset($request->deal_cap)) {
            $dealProductRate->standard_incremental_unit_fee = $request->deal_cap;;
        }
        if (isset($request->highlands_postage)) {
            $dealProductRate->deal_cap = $request->highlands_postage;
        }
        if (isset($request->market_fee_percentage_rate)) {
            $dealProductRate->highlands_postage = $request->market_fee_percentage_rate;
        }
        if (isset($request->standard_incremental_unit_fee)) {
            $dealProductRate->market_fee_percentage_rate = $request->standard_incremental_unit_fee;
        }
        $dealProductRate->deal_price = $request->deal_price;
        $dealProductRate->plateform_fee = $request->plateform_fee;
        $dealProductRate->standard_postage = $request->standard_postage;
        $dealProductRate->vat = $vat;
        $dealProductRate->exclusive_text_amount = $exclusive_text_amount;
        $dealProductRate->p_p_vat = $p_p_vat;
        $dealProductRate->vat_amount = $vat_amount;
        $dealProductRate->commission_amount = $commission_amount;
        $dealProductRate->vat_deduct_commission = $vat_deduct_commission;
        $dealProductRate->total_net_vat = $total_net_vat;
        $dealProductRate->contract_signed_at = $request->contract_signed_at;
        $dealProductRate->total_receivable = $total_receivable;
        $dealProductRate->start_date = $request->start_date;
        $dealProductRate->end_date = $request->end_date;
        $dealProductRate->is_primary = 0;
        $dealProductRate->is_active = 1;
        $dealProductRate->save();

        $deal = Deal::where('deal_number', $dealProduct->deal_number)->first();

        OrderItem::whereHas('order', function ($query) use ($deal, $dealProduct, $dealProductRate) {
            $query->where([['deal_id', $deal->deal_number], ['product_id', $dealProduct->product_id]])
                ->whereDate('order_date', '>=', $dealProductRate->start_date);
        })->where('deal_product_rate_id', null)->update(['deal_product_rate_id' => $dealProductRate->id]);

        return Redirect::route('deals.show', $dealProduct->deal_number)->with('success', 'Deal Product added successfully');
    }

    public function dealRateUpdate(Request $request)
    {
        $dealProductRate = DealsProductsRates::findOrFail($request->id);
        $vat = $request->deal_price * 20 / 120;
        $unitPriceCommition = $request->deal_price * $request->plateform_fee / 100;
        $vatPriceCommition = $unitPriceCommition * 20 / 100;
        $total_receivable = $request->deal_price + $request->standard_postage - $unitPriceCommition - $vatPriceCommition;
        $deal_price = $request->deal_price + $request->standard_postage;
        $p_p_vat = $request->standard_postage * 20 / 120;
        $vat_amount = $vat + $p_p_vat;
        $exclusive_text_amount = $request->deal_price - $vat;
        $commission_amount = $request->deal_price * $request->plateform_fee / 100;

        $vat_deduct_commission = $commission_amount * 20 / 100;
        $total_net_vat = $vat_amount - $vat_deduct_commission;
        $vatam = number_format((float)$vat, 2, '.', '');
        $total_receivable = number_format((float)$total_receivable, 2, '.', '');
        $deal_price = number_format((float)$deal_price, 2, '.', '');
        $p_p_vat = number_format((float)$p_p_vat, 2, '.', '');
        $vat_amount = number_format((float)$vat_amount, 2, '.', '');
        $exclusive_text_amount = number_format((float)$exclusive_text_amount, 2, '.', '');
        $commission_amount = number_format((float)$commission_amount, 2, '.', '');
        $vat_deduct_commission = number_format((float)$vat_deduct_commission, 2, '.', '');
        $total_net_vat = number_format((float)$total_net_vat, 2, '.', '');

        $dealProduct = DealsProducts::where('product_id', $request->product_id)->where('deal_number', $dealProductRate->deal_number)->first();
        $oldTotal = $dealProductRate->total_receivable;
        $dealProductRate->deal_product_id = $dealProduct->id;
        $dealProductRate->deal_number = $dealProduct->deal_number;
        $dealProductRate->deal_price = $request->deal_price;
        $dealProductRate->plateform_fee = $request->plateform_fee;
        $dealProductRate->standard_postage = $request->standard_postage;
        if ($request->deal_cap) {
            $dealProductRate->standard_incremental_unit_fee = $request->deal_cap;;
        }
        if ($request->highlands_postage) {
            $dealProductRate->deal_cap = $request->highlands_postage;
        }
        if ($request->market_fee_percentage_rate) {
            $dealProductRate->highlands_postage = $request->market_fee_percentage_rate;
        }
        if ($request->standard_incremental_unit_fee) {
            $dealProductRate->market_fee_percentage_rate = $request->standard_incremental_unit_fee;
        }
        $dealProductRate->vat = $vat;
        $dealProductRate->exclusive_text_amount = $exclusive_text_amount;
        $dealProductRate->p_p_vat = $p_p_vat;
        $dealProductRate->vat_amount = $vat_amount;
        $dealProductRate->commission_amount = $commission_amount;
        $dealProductRate->vat_deduct_commission = $vat_deduct_commission;
        $dealProductRate->total_net_vat = $total_net_vat;
        $dealProductRate->contract_signed_at = $request->contract_signed_at;
        $dealProductRate->total_receivable = $total_receivable;
        $dealProductRate->start_date = $request->start_date;
        $dealProductRate->end_date = $request->end_date;
        $dealProductRate->update();

        $orderItems = OrderItem::where('deal_product_rate_id', $dealProductRate->id)->get();
        $orders = Order::with('invoices')->where([['product_id', $dealProduct->product_id], ['deal_id', $dealProduct->deal_number], ['deal_invoice', '!=', null]])->get();
        $invoices = Invoice::where('invoiceable_id', $dealProduct->deal_id)->with('invoiceItems')->get();

        foreach ($orderItems as $orderItem) {
            if ($request->start_date >= $orderItem['order_date']) {
            } else {
                $dealProduct = DealsProducts::where([['product_id', $request->product_id], ['deal_number', $request->deal_id]])->first();
                $dealRate = DealsProductsRates::where([['deal_product_id', $dealProduct->id], ['is_primary', 1]])->first();
                $orderItem->update(['deal_product_rate_id' => $dealRate->id]);
            }
        }

        foreach ($invoices as $invoice) {
            $totalDiscrepancy = 0;
            $discrepancy = 0;
            $total = 0;
            $invoiceItems = InvoiceItem::where('invoice_id', $invoice->id)->get();
            $countItems = $invoiceItems->count();
            foreach ($invoiceItems as $item) {
                $total += $item->total;
            }
            if($oldTotal != $dealProductRate->total_receivable){
                $newTotal = $dealProductRate->total_receivable * $countItems;
                $discrepancy = $newTotal - $total;
                $totalDiscrepancy = $invoice->discrepancy + $discrepancy;
                $invoice->update(['discrepancy' => $totalDiscrepancy]);
            }
        }

        return Redirect::route('deals.show', $dealProductRate->deal_number)->with('success', 'Deal Product added successfully');
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

        $deal = Deal::find($request->get('deal_id'));

        if ($request['file']) {
            $files = $request['file'];
            $mimeType = strtolower($files[0]->getClientOriginalExtension());
            $newName = str_replace("-", "", str_replace(" ", "_", strtolower($request['title'])));
            $hash = Str::random(40);
            $newName = $newName . "_" . $hash . "." . $mimeType;
            $path = 'storage/' . $files[0]->storeAs('deals', $newName);
        }

        $deal->documents()->create([
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'user_id' => Auth::user() ? Auth::user()->id : '',
            'title' => $request->title,
            'file' => $path,
            'file_type' => $mimeType,
            'description' => $request->description,
        ]);

        $document = Documents::latest()->first();

        //        $currentURL = url()->current();
        //        $slice = Str::after($currentURL, '8000');
        //        $module = [
        //            'message' => '{' . $document->id . '}',
        //            'module' => $document,
        //            'activity' => 'Store',
        //            'type' => 'erp',
        //            'path' => $slice . '/' . $document->id,
        //        ];
        //
        //        $this->logable($module);


        return Redirect::route('deals.show', $deal->deal_number)->with('success', 'Supplier rate created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */

    public function show($deal_number)
    {
        $this->authorize('view', Deal::class);

        $products = Product::select('id', 'name', 'sku', 'image')->get();

        $orders = Order::with('orderItems')
            ->where('deal_id', $deal_number)
            ->with('product')
            ->orderBy('deal_id', 'desc');
        //
        //        $ordersPluck = Order::with('orderItems')
        //            ->where('deal_id', $deal_number)
        //            ->with('product')->pluck('id');


        //        dd($ordersPluck->toArray());

        //        $invoices = Invoice::whereIn('invoiceable_id', $ordersPluck->toArray())->where('invoiceable_type', 'App\Models\Order')->get();
        //        dd($invoices);

        $orderCount = $orders->count();

        $deal = Deal::where('deal_number', $deal_number)
            ->with('documents')
            ->with('dealProducts.product', 'dealProducts.dealProductsRates.orderItems', 'dealProductRates')->first();
        $dealRatesProduct = DealsProductsRates::with('dealProduct.product', 'orderItems')->where('deal_number', $deal_number)->orderBy('id', 'desc')->get();

        if (!$dealRatesProduct->isEmpty()) {

            $totalCap = 0;
            $totalVat = 0;
            $totalPpVat = 0;
            $totalpostage = 0;
            $totalCommission = 0;
            $totalReceivable = 0;
            $totalOrderItems = 0;

            foreach ($deal->dealProducts as $product) {
                foreach ($product->dealProductsRates as $rate) {
                    $quantity = $rate->orderItems()->sum('quantity');
                    $totalVat += $rate->vat * $quantity;
                    $totalCommission += $rate->commission_amount * $quantity;
                    $totalReceivable += $rate->total_receivable * $quantity;
                    $totalPpVat += $rate->p_p_vat * $quantity;
                    $totalCap += $rate->deal_cap;
                    $totalpostage += $rate->highlands_postage * $quantity;
                    $totalOrderItems += $quantity;
                }
            }

            $invoices = Invoice::with('statuss')
                ->where('deal_number', $deal->deal_number)
                ->with(['invoiceItems' => function ($query) {
                    $query->select('product_id', 'quantity', 'invoice_id')->distinct('product_id');
                }, 'invoiceItems.product' => function ($query) {
                    $query->withSUM('invoiceItems', 'quantity');
                }, 'payments'])->get();
            $invoiced = $invoices->count();
            $totalPaid = 0;

            foreach ($invoices as $invoice) {
                foreach ($invoice->invoiceItems as $item) {
                    $totalPaid += $item->total;
                }
            }

            $unInvoicedOrders = Order::with(['orderItems.dealProductRate', 'orderItems.product'])
                ->where([['deal_id', $deal_number], ['deal_invoice', null]])->get();
            $unInvoiced = $unInvoicedOrders->count();
            $balance = 0;

            foreach ($unInvoicedOrders as $unInvoicedOrder) {
                foreach ($unInvoicedOrder->orderItems as $items) {
                    if ($items->dealProductRate) {
                        $balance += $items->dealProductRate->total_receivable;
                    }
                }
            }

            $order_statuses = Lookup::where('type', 'order_status')->get();

            return Inertia::render('Deal/Show', [
                'rate' => $rate,
                'deals' => $deal,
                'balance' => $balance,
                'totalCap' => $totalCap,
                'quantity' => $quantity,
                'totalVat' => $totalVat,
                'invoices' => $invoices,
                'invoiced' => $invoiced,
                'totalPaid' => $totalPaid,
                'products' => $products,
                'unInvoiced' => $unInvoiced,
                'totalPpVat' => $totalPpVat,
                'orderCount' => $orderCount,
                'unInvoicedOrders' => $unInvoicedOrders,
                'totalpostage' => $totalpostage,
                'orderQuantity' => $totalOrderItems,
                'totalCommission' => $totalCommission,
                'totalReceivable' => $totalReceivable,
                'dealItemsRate' => $dealRatesProduct,
                'order_statuses' => $order_statuses,
                'orders' => $orders->paginate(20)->withQueryString()
            ]);
        } else {
            return Redirect::route('deals.index');
        }
    }

    public function ratesShow($id)
    {
        $this->authorize('view', Deal::class);
        $dealProductRate = DealsProductsRates::with('orderItems', 'documents')->where('id', $id)->first();

        $totalVat = 0;
        $totalCommission = 0;
        $totalExclusiveTextAmount = 0;
        $totalPpVat = 0;
        $totalOrderItems = 0;
        $totalCap = 0;
        $quantity = $dealProductRate->orderItems->sum('quantity');
        $totalVat += $dealProductRate->vat * $quantity;
        $totalCommission += $dealProductRate->commission_amount * $quantity;
        $totalExclusiveTextAmount += $dealProductRate->exclusive_text_amount * $quantity;
        $totalPpVat += $dealProductRate->p_p_vat * $quantity;
        $totalCap += $dealProductRate->deal_cap;
        // $totalOrderItems += $quantity;

        // // $message = 'Show';
        // // $this->logable($dealProductRate, $message);

        return Inertia::render('Deal/RatesShow', [
            'totalCap' => $totalCap,
            'totalVat' => $totalVat,
            'deals' => $dealProductRate,
            'totalPpVat' => $totalPpVat,
            'rate' => $dealProductRate,
            'orderQuantity' => $totalOrderItems,
            'totalCommission' => $totalCommission,
            'totalExclusiveTextAmount' => $totalExclusiveTextAmount,
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function viewFile($id)
    {
        $this->authorize('view', Deal::class);

        $dealsFileView = Documents::where('id', $id)->firstOrFail();

        //        $currentURL = url()->current();
        //        $slice = Str::after($currentURL, '8000');
        //
        //        $module = [
        //            'message' => '{' . $dealsFileView->id . '}',
        //            'module' => $dealsFileView,
        //            'activity' => 'Show',
        //            'type' => 'erp',
        //            'path' => $slice,
        //        ];
        //
        //        $this->logable($module);

        return response()->file(public_path($dealsFileView->file));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportFile($id)
    {
        $this->authorize('view', Deal::class);

        $dealsFileExport = Documents::where('id', $id)->firstOrFail();

        //        $currentURL = url()->current();
        //        $slice = Str::after($currentURL, '8000');
        //
        //        $module = [
        //            'message' => '{' . $dealsFileExport->id . '}',
        //            'module' => $dealsFileExport,
        //            'activity' => 'Create',
        //            'type' => 'erp',
        //            'path' => $slice,
        //        ];
        //
        //        $this->logable($module);

        return response()->download(public_path($dealsFileExport->file));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Deal::class);

        $productTitle = Product::Select('id', 'name')->get();
        $deal = Deal::with([
            'dealProducts.dealProductsRates',
            'dealProducts.product',
            'dealProductRates',
            'documents'
        ])->findOrFail($id);

        $products = Product::select('id', 'name', 'image', 'sku')->orderBy('name', 'asc')->orderBy('sku', 'asc')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $deal->id . '}',
            'module' => $deal,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        $channelTitle = SalesChannel::select('id', 'name')->get();

        return Inertia::render('Deal/Edit', [
            'deals' => $deal,
            'products' => $products,
            'channelTitles' => $channelTitle,
            'productTitles' => $productTitle
        ]);
    }

    public function editDocuments($id)
    {
        $this->authorize('update', Deal::class);

        $document = Documents::where('id', $id)->first();
        $dealNumber = Deal::where('id', $document->documentable_id)->first();


        //        $currentURL = url()->current();
        //        $slice = Str::after($currentURL, '8000');
        //
        //        $module = [
        //            'message' => '{' . $dealNumber->id . '}',
        //            'module' => $dealNumber,
        //            'activity' => 'Edit',
        //            'type' => 'erp',
        //            'path' => $slice,
        //        ];
        //
        //        $this->logable($module);

        return Inertia::render('Deal/FileCreate', [
            'document' => $document,
            'dealNumber' => $dealNumber
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
        $deal = Deal::findOrFail($id);
        $deal->deal_type = $request->deal_type;
        $deal->company_id = Auth::user() ? Auth::user()->company_id : '';
        $deal->channel_name = $request->channel_name;
        $deal->email = $request->email;
        $deal->address = $request->address;
        $deal->deal_number = $request->deal_number;
        $deal->deal_title = $request->deal_title;
        $deal->account_manager = $request->account_manager;
        $deal->category = $request->category;
        $deal->subcategory = $request->subcategory;
        $deal->start_date = $request->start_date;
        $deal->contract_signed_at = $request->contract_signed_at;
        $deal->gross_revenue = $request->gross_revenue;
        $deal->redeemed_units = $request->redeemed_units;
        $deal->refunded_units = $request->refunded_units;
        $deal->refund_rate = $request->refund_rate;
        $deal->auv = $request->auv;
        $deal->signed_by_supplier_name = $request->signed_by_supplier_name;
        $deal->signed_by_customer_name = $request->signed_by_customer_name;
        $deal->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $deal->id . '}',
            'module' => $deal,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        $deal->save();

        if ($request->documents) {
            foreach ($request->documents as $doc) {
                if (array_key_exists('id', $doc) && array_key_exists('documentable_id', $doc)) {
                    if ($doc['file'][0] == 's') {
                        if ($doc['file']) {
                            $path = $doc['file'];
                        }
                    } else {
                        if ($doc['files']) {
                            $files = $doc['files'];
                            $mimeType = strtolower($files[0]->getClientOriginalExtension());
                            $newName = str_replace("-", "", str_replace(" ", "_", strtolower($doc['title'])));
                            $hash = Str::random(40);
                            $newName = $newName . "_" . $hash . "." . $mimeType;
                            $path = 'storage/' . $files[0]->storeAs('deals', $newName);
                        }
                    }
                    $doc = Documents::updateOrCreate(
                        [
                            'id' => $doc['id'],
                            'documentable_id' => $doc['documentable_id'],
                            'documentable_type' => 'App\Models\Deal'
                        ],
                        [
                            'company_id' => Auth::user() ? Auth::user()->company_id : '',
                            'title' => $doc['title'],
                            'file' => $path,
                            'description' => $doc['description'],
                        ]
                    );
                } else {
                    if ($doc['files']) {
                        $files = $doc['files'];
                        $mimeType = strtolower($files[0]->getClientOriginalExtension());
                        $newName = str_replace("-", "", str_replace(" ", "_", strtolower($doc['title'])));
                        $hash = Str::random(40);
                        $newName = $newName . "_" . $hash . "." . $mimeType;
                        $path = 'storage/' . $files[0]->storeAs('deals', $newName);
                    }
                    $deal->documents()->create([
                        'company_id' => Auth::user() ? Auth::user()->company_id : '',
                        'user_id' => Auth::user() ? Auth::user()->user_id : '',
                        'title' => $doc['title'],
                        'file' => $path,
                        'file_type' => $mimeType,
                        'description' => $doc['description']
                    ]);

                    // $doc = Documents::orderBy('id', 'desc')->first();

                    // $message =  '{' . $doc->id  .'}';
                    // $message1 = 'Update' ;
                    // $this->logable($doc, $message, $message1);

                }
            }
        }
        if ($request->deal_products) {
            foreach ($request->deal_products as $key => $item) {
                if (array_key_exists('id', $item) && array_key_exists('deal_id', $item)) {
                    $dealProduct = DealsProducts::updateOrCreate(
                        [
                            'id' => $item['id'],
                            'deal_id' => $item['deal_id'],
                        ],
                        [
                            'deal_id' => $id,
                            'product_id' => $item['product_id'],
                            'deal_number' => $request->deal_number,
                            'product_title' => $item['product_title'],
                            'product_code' => $item['product_code'],
                            'link' => $item['link'],
                        ]
                    );
                } else {
                    $dealProduct = DealsProducts::updateOrCreate([
                        'deal_id' => $id,
                        'product_id' => $item['product_id'],
                        'deal_number' => $request->deal_number,
                        'product_title' => $item['product_title'],
                        'product_code' => $item['product_code'],
                        'link' => $item['link'],
                    ]);
                };
                foreach ($request->deal_product_rates as $dealItemsRat) {
                    if (isset($dealItemsRat['product_id'])) {
                        if ($dealItemsRat['product_id'] == $dealProduct['product_id']) {
                            if (array_key_exists('id', $dealItemsRat) && array_key_exists('product_id', $dealItemsRat)) {
                                $vat = $dealItemsRat['deal_price'] * 20 / 120;
                                $unitPriceCommition = $dealItemsRat['deal_price'] * $dealItemsRat['plateform_fee'] / 100;
                                $vatPriceCommition = $unitPriceCommition * 20 / 100;
                                $total_receivable = $dealItemsRat['deal_price'] + $dealItemsRat['standard_postage'] - $unitPriceCommition - $vatPriceCommition;
                                $deal_price = $dealItemsRat['deal_price'] + $dealItemsRat['standard_postage'];
                                $p_p_vat = $dealItemsRat['standard_postage'] * 20 / 120;
                                $vat_amount = $vat + $p_p_vat;
                                $exclusive_text_amount = $dealItemsRat['deal_price'] - $vat;
                                $commission_amount = $dealItemsRat['deal_price'] * $dealItemsRat['plateform_fee'] / 100;

                                $vat_deduct_commission = $commission_amount * 20 / 100;
                                $total_net_vat = $vat_amount - $vat_deduct_commission;
                                $vatam = number_format((float)$vat, 2, '.', '');
                                $total_receivable = number_format((float)$total_receivable, 2, '.', '');
                                $deal_price = number_format((float)$deal_price, 2, '.', '');
                                $p_p_vat = number_format((float)$p_p_vat, 2, '.', '');
                                $vat_amount = number_format((float)$vat_amount, 2, '.', '');
                                $exclusive_text_amount = number_format((float)$exclusive_text_amount, 2, '.', '');
                                $commission_amount = number_format((float)$commission_amount, 2, '.', '');
                                $vat_deduct_commission = number_format((float)$vat_deduct_commission, 2, '.', '');
                                $total_net_vat = number_format((float)$total_net_vat, 2, '.', '');

                                $dealProductData = DealsProducts::where([['deal_number', $request->deal_number], ['product_id', $dealItemsRat['product_id']]])->first();

                                DealsProductsRates::where([
                                    ['deal_number', $request->deal_number],
                                    ['deal_product_id', $dealProductData->id]
                                ])->update(['is_active' => 0]);

                                // DealsProductsRates::create([
                                //     'deal_product_id' => $dealProduct['id'],
                                //     'deal_number' => $request->deal_number,
                                //     'deal_cap' => $dealItemsRat['deal_cap'],
                                //     'deal_price' => $dealItemsRat['deal_price'],
                                //     'plateform_fee' => $dealItemsRat['plateform_fee'],
                                //     'standard_postage' => $dealItemsRat['standard_postage'],
                                //     'highlands_postage' => $dealItemsRat['highlands_postage'],
                                //     'market_fee_percentage_rate' => $dealItemsRat['market_fee_percentage_rate'],
                                //     'standard_incremental_unit_fee' => $dealItemsRat['standard_incremental_unit_fee'],
                                //     'vat' => $vatam,
                                //     'p_p_vat' => $p_p_vat,
                                //     'vat_amount' => $vat_amount,
                                //     'commission_amount' => $commission_amount,
                                //     'vat_deduct_commission' => $vat_deduct_commission,
                                //     'total_net_vat' => $total_net_vat,
                                //     'contract_signed_at' => $request->contract_signed_at,
                                //     'total_receivable' => $total_receivable,
                                //     'exclusive_text_amount' => $exclusive_text_amount,
                                //     'start_date' => $dealItemsRat['start_date'],
                                //     'end_date' => $dealItemsRat['end_date'],
                                //     'is_primary' => 0,
                                //     'is_active' => 1
                                // ]);
                                $dealProductRate = new DealsProductsRates();
                                $dealProductRate->deal_product_id = $dealProduct->id;
                                $dealProductRate->deal_number = $request->deal_number;
                                $dealProductRate->deal_price = $dealItemsRat['deal_price'];
                                $dealProductRate->plateform_fee = $dealItemsRat['plateform_fee'];
                                $dealProductRate->standard_postage = $dealItemsRat['standard_postage'];
                                if ($dealItemsRat['standard_incremental_unit_fee']) {
                                    $dealProductRate->standard_incremental_unit_fee = $dealItemsRat['standard_incremental_unit_fee'];
                                }
                                if (isset($dealItemsRat['deal_cap'])) {
                                    $dealProductRate->deal_cap = $dealItemsRat['deal_cap'];
                                }
                                if (isset($dealItemsRat['highlands_postage'])) {
                                    $dealProductRate->highlands_postage = $dealItemsRat['highlands_postage'];
                                }
                                if (isset($dealItemsRat['market_fee_percentage_rate'])) {
                                    $dealProductRate->market_fee_percentage_rate = $dealItemsRat['market_fee_percentage_rate'];
                                }
                                $dealProductRate->vat = $vat;
                                $dealProductRate->exclusive_text_amount = $exclusive_text_amount;
                                $dealProductRate->p_p_vat = $p_p_vat;
                                $dealProductRate->vat_amount = $vat_amount;
                                $dealProductRate->commission_amount = $commission_amount;
                                $dealProductRate->vat_deduct_commission = $vat_deduct_commission;
                                $dealProductRate->total_net_vat = $total_net_vat;
                                $dealProductRate->contract_signed_at = $request->contract_signed_at;
                                $dealProductRate->total_receivable = $total_receivable;
                                $dealProductRate->start_date = $dealItemsRat['start_date'];
                                $dealProductRate->end_date = $dealItemsRat['end_date'];
                                $dealProductRate->is_primary = 1;
                                $dealProductRate->is_active = 1;
                                $dealProductRate->save();
                            }
                        }
                    } else {
                        $dealProductRate = DealsProductsRates::where('id', $dealItemsRat['id'])->first();
                        $orderItems = OrderItem::where('deal_product_rate_id', $dealProductRate->id)->get();
                        foreach ($orderItems as $orderItem) {
                            $vat = $dealItemsRat['deal_price'] * 20 / 120;
                            $unitPriceCommition = $dealItemsRat['deal_price'] * $dealItemsRat['plateform_fee'] / 100;
                            $vatPriceCommition = $unitPriceCommition * 20 / 100;
                            $total_receivable = $dealItemsRat['deal_price'] + $dealItemsRat['standard_postage'] - $unitPriceCommition - $vatPriceCommition;
                            $deal_price = $dealItemsRat['deal_price'] + $dealItemsRat['standard_postage'];
                            $p_p_vat = $dealItemsRat['standard_postage'] * 20 / 120;
                            $vat_amount = $vat + $p_p_vat;
                            $exclusive_text_amount = $dealItemsRat['deal_price'] - $vat;
                            $commission_amount = $dealItemsRat['deal_price'] * $dealItemsRat['plateform_fee'] / 100;

                            $vat_deduct_commission = $commission_amount * 20 / 100;
                            $total_net_vat = $vat_amount - $vat_deduct_commission;
                            $vatam = number_format((float)$vat, 2, '.', '');
                            $total_receivable = number_format((float)$total_receivable, 2, '.', '');
                            $deal_price = number_format((float)$deal_price, 2, '.', '');
                            $p_p_vat = number_format((float)$p_p_vat, 2, '.', '');
                            $vat_amount = number_format((float)$vat_amount, 2, '.', '');
                            $exclusive_text_amount = number_format((float)$exclusive_text_amount, 2, '.', '');
                            $commission_amount = number_format((float)$commission_amount, 2, '.', '');
                            $vat_deduct_commission = number_format((float)$vat_deduct_commission, 2, '.', '');
                            $total_net_vat = number_format((float)$total_net_vat, 2, '.', '');
                            $oldTotal = $dealProductRate->total_receivable;
                            $dealProductRate->deal_number = $request->deal_number;
                            $dealProductRate->deal_price = $dealItemsRat['deal_price'];
                            $dealProductRate->plateform_fee = $dealItemsRat['plateform_fee'];
                            $dealProductRate->standard_postage = $dealItemsRat['standard_postage'];
                            if ($dealItemsRat['standard_incremental_unit_fee']) {
                                $dealProductRate->standard_incremental_unit_fee = $dealItemsRat['standard_incremental_unit_fee'];
                            }
                            if (isset($dealItemsRat['deal_cap'])) {
                                $dealProductRate->deal_cap = $dealItemsRat['deal_cap'];
                            }
                            if (isset($dealItemsRat['highlands_postage'])) {
                                $dealProductRate->highlands_postage = $dealItemsRat['highlands_postage'];
                            }
                            if (isset($dealItemsRat['market_fee_percentage_rate'])) {
                                $dealProductRate->market_fee_percentage_rate = $dealItemsRat['market_fee_percentage_rate'];
                            }
                            $dealProductRate->vat = $vatam;
                            $dealProductRate->p_p_vat = $p_p_vat;
                            $dealProductRate->vat_amount = $vat_amount;
                            $dealProductRate->commission_amount = $commission_amount;
                            $dealProductRate->vat_deduct_commission = $vat_deduct_commission;
                            $dealProductRate->total_net_vat = $total_net_vat;
                            $dealProductRate->contract_signed_at = $request->contract_signed_at;
                            $dealProductRate->total_receivable = $total_receivable;
                            $dealProductRate->exclusive_text_amount = $exclusive_text_amount;
                            $dealProductRate->start_date = $dealItemsRat['start_date'];
                            $dealProductRate->end_date = $dealItemsRat['end_date'];
                            $dealProductRate->update();
                            if ($dealItemsRat['start_date'] >= $orderItem->order_date) {
                            } else {
                                $dealRate = DealsProductsRates::where([['deal_number', $dealItemsRat['deal_number'], ['is_primary', 1]]])->first();
                                $orderItem->update(['deal_product_rate_id' => $dealRate->id]);
                            }
                            $invoices = Invoice::where('invoiceable_id', $dealProduct->deal_id)->with('invoiceItems')->get();
                            foreach ($invoices as $invoice) {
                                $totalDiscrepancy = 0;
                                $discrepancy = 0;
                                $total = 0;
                                $invoiceItems = InvoiceItem::where('invoice_id', $invoice->id)->get();
                                $countItems = $invoiceItems->count();
                                foreach ($invoiceItems as $item) {
                                    $total += $item->total;
                                }
                                if($oldTotal != $dealProductRate->total_receivable){
                                    $newTotal = $dealProductRate->total_receivable * $countItems;
                                    $discrepancy = $newTotal - $total;
                                    $totalDiscrepancy = $invoice->discrepancy + $discrepancy;
                                    $invoice->update(['discrepancy' => $totalDiscrepancy]);
                                }
                            }
                        }
                    }
                }
            }
        }

        return Redirect::route('deals.index');
    }

    public function dealItemUpdate(Request $request)
    {
        $dealproduct = DealsProducts::findOrFail($request->id);
        $dealproduct->product_id = $request->product_id;
        $dealproduct->product_title = $request->product_title;
        $dealproduct->product_code = $request->product_code;
        $dealproduct->link = $request->link;
        $dealproduct->save();

        return Redirect::back()->with('success', 'Deal Product added successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function documentUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:100'],
        ]);
        $document = Documents::find($request->get('id'));

        if ($request->file('file')) {
            $path = 'storage/' . $request->file('file')[0]->store('docoments');
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

        $deal = Deal::where('id', $document->documentable_id)->first();

        return Redirect::route('deals.show', $deal->deal_number)->with('success', 'Deal Document Updated Successfully');
    }

    public function invoiceCreate(Request $request)
    {
        $orders_ids = $request->orders;
        $deal = Deal::with('dealProducts.dealProductsRates')->where('id', $request->deal_id)->first();

        $invoice = new Invoice();
        $invoice->company_id = Auth::user() ? Auth::user()->company_id : '';
        $invoice->customer_id = SalesChannel::where('name', $deal->channel_name)->first()->id;
        $invoice->invoiceable_type = 'App\Modles\Deal';
        $invoice->invoiceable_id = $deal->id;
        $invoice->status = $request->order_status;
        $invoice->invoice_number = $request->invoice_number;
        $invoice->deal_number = $deal->deal_number;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->due_date = Carbon::now()->addDays(14);
        $invoice->save();

        $totalCommission = 0;
        $total = 0;
        foreach ($orders_ids as $orders_id) {
            $order = Order::where([['id', $orders_id], ['deal_invoice', null]])->first();
            // if ($order) {
            //     $order->deal_invoice = $invoice->invoice_number;
            //     $order->save();
            // }

            if ($order) {
                $deal = Deal::where('deal_number', $order->deal_id)->first();
                $dealProducts = DealsProducts::where([['deal_number', $deal->deal_number]])->get();

                $orderItems = OrderItem::where([['order_id', $order->id]])->with('dealProductRate')->first();
                $orderItemsRateId = $orderItems->deal_product_rate_id;
                $vat = DealsProductsRates::where('id', $orderItemsRateId)->first()->vat_amount;
                $totalCommission += $orderItems->dealProductRate->commission_amount;

                if ($order) {
                    $order->deal_invoice = $invoice->invoice_number;
                    $order->save();
                }

                $invoice_item = new InvoiceItem();
                $invoice_item->company_id = $order->company_id;
                $invoice_item->invoice_id = $invoice->id;
                $invoice_item->product_id = $order->product_id;
                $invoice_item->item_name = $order->product_name;
                $invoice_item->quantity = $orderItems->quantity;
                $invoice_item->unit_price = $orderItems->dealProductRate->deal_price;
                $invoice_item->total_price = $orderItems->dealProductRate->deal_price * $orderItems->quantity;
                $invoice_item->total = $orderItems->dealProductRate->total_receivable * $orderItems->quantity;
                $invoice_item->vat = $orderItems->dealProductRate->vat_amount;
                $invoice_item->save();
                $total += $invoice_item->total;
            }
        }
        $invoice->update(['total' => $total]);

        // return Redirect::route('deals.show', $deal->deal_number)->with('success', 'Invoice generated successfully');
        return Redirect::back();
    }

    public function invoiceView($id)
    {
        $invoice = Invoice::where('id', $id)->with('invoiceItems')->first();
        $orders = Order::with('orderItems.dealProductRate')->where('invoice_number', $invoice->invoice_number)->get();
        $commissionAmount = 0;
        $vatAmount = 0;
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $commissionAmount += $item->dealProductRate->commission_amount;
                $vatAmount += $item->dealProductRate->vat_amount;
            }
        }
        $company = Company::where('id', $invoice->company_id)->with('addresses')->first();
        $salesChannel = SalesChannel::where('id', $invoice->customer_id)->with('addresses')->first();
        $deal = Deal::with('dealProducts')->where('deal_number', $invoice->deal_number)->first();

        //        $currentURL = url()->current();
        //        $slice = Str::after($currentURL, '8000');
        //
        //        $module = [
        //            'message' => '{' . $deal->id . '}',
        //            'module' => $deal,
        //            'activity' => 'Show',
        //            'type' => 'erp',
        //            'path' => $slice,
        //        ];
        //
        //        $this->logable([$module]);

        return Inertia::render('Deal/Invoice/View', [
            'invoice' => $invoice,
            'company' => $company,
            'vatAmount' => $vatAmount,
            'salesChannel' => $salesChannel,
            'commissionAmount' => $commissionAmount,
        ]);
    }

    public function ordersInvoiceView($id)
    {
        $invoice = Invoice::where('invoice_number', $id)->with('invoiceItems')->first();
        $orders = Order::with('orderItems.dealProductRate')->where('deal_invoice', $invoice->invoice_number)->get();
        $commissionAmount = 0;
        $total = 0;
        $vatAmount = 0;
        $totalReceivable = 0;
        $netPrice = 0;
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $vatAmount += $item->dealProductRate->vat_amount;
                $totalReceivable += $item->dealProductRate->total_receivable;
                $commissionAmount += $item->dealProductRate->commission_amount;
            }
        }

        $invoices = Invoice::where('invoice_number', $id)->with('invoiceItems.product')
        ->with(['invoiceItems' => function ($query) {
            $query->select('product_id', 'quantity', 'total' , 'invoice_id')->distinct('product_id', 'invoice_id');
        }])->withCount('invoiceItems')->get();
        
        $netPrice += $commissionAmount - $vatAmount;
        $company = Company::where('id', $invoice->company_id)->with('addresses')->first();
        $salesChannel = SalesChannel::where('id', $invoice->customer_id)->with('addresses')->first();
        $deal = Deal::with('dealProducts.dealProductsRates')->where('deal_number', $invoice->deal_number)->first();

        return Inertia::render('Deal/invoice/View', [
            'deal' => $deal,
            'orders' => $orders,
            'company' => $company,
            'invoice' => $invoice,
            'invoices' => $invoices,
            'netPrice' => $netPrice,
            'vatAmount' => $vatAmount,
            'salesChannel' => $salesChannel,
            'totalReceivable' => $totalReceivable,
            'commissionAmount' => $commissionAmount
        ]);
    }

    public function dealProductDelete($id)
    {
        $dealProduct = DealsProducts::findOrFail($id);
        $dealProductRates = DealsProductsRates::where('deal_product_id', $id)->get();
        if ($dealProductRates) {
            foreach ($dealProductRates as $rate) {
                // Order::where('deal_id', $rate->deal_number)->update(['deal_id' => null]);
                OrderItem::where('deal_product_rate_id', $rate->id)->update([
                    'deal_product_rate_id' => null
                ]);
                $rate->delete();
            }
        }

        $dealProduct->delete();

        //        $module = [
        //            'message' => '{' . $dealProduct->id . '}',
        //            'module' => $dealProduct,
        //            'activity' => 'Delete',
        //            'type' => 'erp',
        //            'path' => null,
        //        ];
        //
        //        $this->logable($module);

        return Redirect::route('deals.index')->with('success', 'Deal Product deleted successfully');
    }

    public function dealProductRateDelete($id)
    {
        $dealProductRate = DealsProductsRates::findOrFail($id);
        // $dealProduct = DealsProducts::where('id', $dealProductRate->deal_product_id)->first();
        // $order = Order::where([['deal_id', $dealProductRate->deal_number], ['product_id', $dealProduct->product_id]])->first();
        // dd($order);
        OrderItem::where('deal_product_rate_id', $dealProductRate->id)->update([
            'deal_product_rate_id' => null
        ]);

        $dealProductRate->delete();

        //        $module = [
        //            'message' => '{' . $dealProductRate->id . '}',
        //            'module' => $dealProductRate,
        //            'activity' => 'Delete',
        //            'type' => 'erp',
        //            'path' => null,
        //        ];
        //
        //        $this->logable($module);

        return Redirect::back()->with('success', 'Deal Product deleted successfully');
    }

    public function invoiceDelete($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        InvoiceItem::where('invoice_id', $id)->delete();
        //
        //        $module = [
        //            'message' => '{' . $invoice->id . '}',
        //            'module' => $invoice,
        //            'activity' => 'Delete',
        //            'type' => 'erp',
        //            'path' => null,
        //        ];
        //
        //        $this->logable($module);

        Order::where('invoice_number', $invoice->invoice_number)->update([
            'invoice_number' => null
        ]);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', Deal::class);

        $deal = Deal::findOrFail($id);
        $dealProducts = DealsProducts::where('deal_id', $id)->get();

        //        $module = [
        //            'message' => '{' . $deal->id . '}',
        //            'module' => $deal,
        //            'activity' => 'Delete',
        //            'type' => 'erp',
        //            'path' => null,
        //        ];
        //
        //        $this->logable($module);

        if ($dealProducts) {
            foreach ($dealProducts as $product) {
                $dealRates = DealsProductsRates::where('deal_product_id', $product->id)->first();
                if ($dealRates) {
                    $orderItem = OrderItem::where('deal_product_rate_id', $dealRates->id)->first();
                    // Order::where([['id', $orderItem->id]])->update(['deal_id' => null]);
                    // $orderItem->update([
                    //     'deal_product_rate_id' => null
                    // ]);
                    $dealRates->delete();
                }
                $product->delete();
            }
        }
        $deal->delete();

        return Redirect::route('deals.index')->with('success', 'No rates added against this deal. Please add rate');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse.toFixed
     */
    public function delete($id)
    {
        $this->authorize('delete', Deal::class);

        $document = Documents::findOrFail($id);
        $document->delete();

        return Redirect::back();
    }
}
