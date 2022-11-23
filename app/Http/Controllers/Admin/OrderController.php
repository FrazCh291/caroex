<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Order;
use App\Models\Lookup;
use App\Models\Product;
use App\Models\Feedback;
use App\Models\OrderItem;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use App\Models\SalesChannel;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\DeliveryItem;
use App\Services\Traits\Sort;
use App\Models\DealsProducts;
use App\Services\Traits\Logger;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use Illuminate\Support\Facades\DB;
use App\Models\DealsProductsRates;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use App\Exports\Orders\OrderReportExport;
use App\Services\Traits\DefaultActiveLog;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class OrderController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;

    private $chart;

    // public function __construct(LarapexChart $chart)
    // {
    //     $this->chart = $chart;
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Order::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Order',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $orders = Order::query();

        if ($request->get('shipped')) {
            $orders = $request->get('shipped') ? $orders->where('order_status', 'shipped') : $orders;
        }
        if ($request->get('pending')) {
            $orders = $request->get('pending') ? $orders->orWhere('order_status', 'pending') : $orders;
        }
        if ($request->get('redispatch')) {
            $orders = $request->get('redispatch') ? $orders->orWhere('order_status', 'redispatch') : $orders;
        }
        if ($request->get('processing')) {
            $orders = $request->get('processing') ? $orders->orWhere('order_status', 'processing') : $orders;
        }
        if ($request->get('cancelled')) {
            $orders = $request->get('cancelled') ? $orders->orWhere('order_status', 'cancelled') : $orders;
        }
        if ($request->get('completed')) {
            $orders = $request->get('completed') ? $orders->orWhere('order_status', 'completed') : $orders;
        }
        if ($request->get('collection')) {
            $orders = $request->get('collection') ? $orders->orWhere('order_status', 'collection') : $orders;
        }
        if ($request->get('replacement')) {
            $orders = $request->get('replacement') ? $orders->orWhere('order_status', 'replacement') : $orders;
        }
        $orders = $orders->where('company_id', Auth::user()->company_id);

        $orders = $this->search($orders, [
            'channel_id',
            'import_id',
            'vendor_id',
            'saleforce_deal_option_id',
            'deal_id',
            'order_number',
            'order_date',
            'shipping_customer_name',
            'shipping_email',
            'shipping_country',
            'product_option',
            'product_name',
            'sku',
            'birthday',
            'marketing_permalink',
            'dispatch_method',
            'order_status',
            'customer_note',
            'billing_customer_name',
            'billing_company',
            'house_number',
            'billing_address_1_2',
            'billing_city',
            'billing_postcode',
            'billing_country',
            'marketing_permission',
            'payment_method_type',
            'cart_discount_amount',
            'order_subtotal_amount',
            'order_shipping_amount',
            'order_refund_amount',
            'order_total_amount',
            'order_total_tax_amount',
            'item',
            'quantity',
            'item_code',
            'discount_amount',
            'discount_amount_tax',
            'merchant_sku_item',
            'gift',
            'coupon_code',
            'billing_address_1',
            'billing_address_2',
            'shipping_address_1',
            'shipping_address_2',
            'shipping_address_town',
            'shipping_address_postcode',
            'shipping_address_phone',
            'quantity_request',
            'shipment_carrier',
            'shipment_tracking_number',
            'ship_date',
            'groupon_sku',
            'permalink',
            'product_weight',
            'product_weight_unit',
            'product_length',
            'product_height',
            'product_dimension_unit',
            'incoterms',
            'hts_code',
            'pl_name',
            'pl_warehouse_location',
            'kettting_details',
            'deal_opportunity_id',
            'shipping_strategy',
            'fulfillment_method',
            'country_of_origin',
            'merchant_permalink',
            'feature_start_date',
            'feature_end_date',
            'bom_sku'
        ]);

        if ($request->has('query')) {
            $orders = $orders->orWhereHas('channel', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $orders = $this->sort($orders, $columns, $request->get('direction'));
        }

        $gogroopiechannel = SalesChannel::where('slug', 'gogroopie')->first();
        $grouponchannel = SalesChannel::where('slug', 'groupon')->first();
        $wowcherchannel = SalesChannel::where('slug', 'wowcher')->first();
        $xstreamgymchannel = SalesChannel::where('slug', 'xstreamgym')->first();
        $amazonchannel = SalesChannel::where('slug', 'amazon')->first();
        $ejoggachannel = SalesChannel::where('slug', 'ejogga')->first();
        $boomtekkchannel = SalesChannel::where('slug', 'boomtekk')->first();

        $orders = $orders->orderBy('order_date', 'desc')->paginate(10);

        $order1 = Order::distinct('order_status')->pluck('order_status')->toArray();
     
    
        $gogroopies = Order::where('channel_id', $gogroopiechannel->id)->orderBy('order_date', 'desc')->paginate(10);
        $groupons = Order::where('channel_id', $grouponchannel->id)->orderBy('order_date', 'desc')->paginate(10);
        $wowchers = Order::where('channel_id', $wowcherchannel->id)->orderBy('order_date', 'desc')->paginate(10);
        $xstreamgyms = Order::where('channel_id', $xstreamgymchannel->id)->orderBy('order_date', 'desc')->paginate(10);
        // $amazons = Order::where('channel_id', $amazonchannel->id)->orderBy('order_date', 'desc')->paginate(10);
        $ejoggas = Order::where('channel_id', $ejoggachannel->id)->orderBy('order_date', 'desc')->paginate(10);
        $boomtekks = Order::where('channel_id', $boomtekkchannel->id)->orderBy('order_date', 'desc')->paginate(10);

        $params = $request->all();

        return Inertia::render('Orders/Index', [
            'orders' => $orders->withQueryString(),
            'order1'=>$order1,
            'gogroopies' => $gogroopies,
            'groupons' => $groupons,
            'wowchers' => $wowchers,
            'xstreamgyms' => $xstreamgyms,
            // 'amazons' => $amazons,
            'ejoggas' => $ejoggas,
            'boomtekks' => $boomtekks,
            'params' => $params,
        ]);
    }

    public function sortables(Request $request)
    {
        $sorts = [];
        foreach ([
            'import_id',
            'vendor_id',
            'saleforce_deal_option_id',
            'deal_id',
            'order_number',
            'order_date',
            'shipping_customer_name',
            'shipping_email',
            'shipping_country',
            'product_option',
            'product_name',
            'billing_address_1',
            'billing_address_2',
            'shipping_address_1',
            'shipping_address_2',
            'shipping_address_town',
            'shipping_address_postcode',
            'shipping_address_phone',
            'sku',
            'birthday',
            'marketing_permalink',
            'dispatch_method',
            'order_status',
            'customer_note',
            'billing_customer_name',
            'billing_company',
            'house_number',
            'billing_address_1_2',
            'billing_city',
            'billing_postcode',
            'billing_country',
            'marketing_permission',
            'payment_method_type',
            'cart_discount_amount',
            'order_subtotal_amount',
            'order_shipping_amount',
            'order_refund_amount',
            'order_total_amount',
            'order_total_tax_amount',
            'item',
            'quantity',
            'item_code',
            'discount_amount',
            'discount_amount_tax',
            'merchant_sku_item',
            'gift',
            'coupon_code',
            'quantity_request',
            'shipment_carrier',
            'shipment_tracking_number',
            'ship_date',
            'groupon_sku',
            'permalink',
            'product_weight',
            'product_weight_unit',
            'product_length',
            'product_height',
            'product_dimension_unit',
            'incoterms',
            'hts_code',
            'pl_name',
            'pl_warehouse_location',
            'kettting_details',
            'deal_opportunity_id',
            'shipping_strategy',
            'fulfillment_method',
            'country_of_origin',
            'merchant_permalink',
            'feature_start_date',
            'feature_end_date',
            'bom_sku',
            'order_status'
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
        $this->authorize('create', Order::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Order',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        $productStock = ProductStock::where('id', $product->id)->first();
        $productStock->decrement('quantity', $request->quantity);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $productStock->id  . '}',
            'module' => $productStock,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice . '/' . $productStock->id,
        ];

        $this->logable($module);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function showOrder($cid , $id)
    {
        $this->authorize('view', Order::class);

        $order = Order::with('orderItems')->where('id', $id)->first();
        if($cid){
            $customer_id = $cid;
        }else{
            $customer_id = null;
        }
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $id  . '}',
            'module' => $order,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        $order_statuses = Lookup::where('type', 'order_status')->get();

        return Inertia::render('Orders/Show', [
            'order' => $order,
            'customer_id' => $customer_id,
            'order_statuses' => $order_statuses,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function show($id)
    {
        $this->authorize('view', Order::class);

        $order = Order::with('orderItems')->where('id', $id)->first();
        
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $id  . '}',
            'module' => $order,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        $order_statuses = Lookup::where('type', 'order_status')->get();

        return Inertia::render('Orders/Show', [
            'order' => $order,
            'order_statuses' => $order_statuses,
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
        $this->authorize('update', Order::class);

        $order_statuses = Lookup::where('type', 'order_status')->get();
        $order = Order::with('orderItems.dealProductRate')->where('id', $id)->first();



        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $order->id . '}',
            'module' => $order,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);
        $products = Product::orderBy('name', 'asc')->get();

        if ($order->deal_id != null) {
            $dealProducts = DealsProducts::where([['deal_number', $order->deal_id], ['product_id', $order->product_id]])->first();
            $dealProductRate = DealsProductsRates::where('deal_product_id', $dealProducts->id)->get();

            return Inertia::render('Orders/Edit', [
                'order' => $order,
                'dealRates' => $dealProductRate,
                'products' => $products,
                'order_statuses' => $order_statuses
            ]);
        }

        else{
            return Inertia::render('Orders/Edit', [
                'order' => $order,
                'products' => $products,
                'order_statuses' => $order_statuses
            ]);
        }
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
        OrderItem::where('id', $id)->update(['updated_by' => Auth::user()->id, 'product_id' => $request->product_id]);
        $orderItem = OrderItem::where('order_id', $id)->first();
        $orderOld = Order::where('id', $id)->first();
        $order = Order::where('id', $orderItem->order_id)->where('product_id', null)
        ->update(['updated_by' => Auth::user()->id, 'product_id' => $request->product_id]);
        $product = Product::findOrFail($request->product_id);
        $order = Order::with('orderItems.dealProductRate')->where('id', $id)->first();
    
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' .  $order->id  .'}',
            'module' =>  $order,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details =  $orderOld;

		$final_data = json_encode($details);

         $LogDetail = new ActivityLogsDetails();
         $LogDetail->activity_log_id = $logData->id;
         $LogDetail->company_id = Auth::user()->company_id;
         $LogDetail->details = $final_data;
         $LogDetail->is_old = 1;
         $LogDetail->save();

        $tuffnellitem = new DeliveryItem();
        $tuffnellitem->order_id = $request->order_id;
        $tuffnellitem->company_id = Auth::user()->company_id;
        $tuffnellitem->order_item_id = $request->id;
        $tuffnellitem->status = $request->order_status;
        $tuffnellitem->delivery_method = $product ? $product->shipping_method : '';
        $tuffnellitem->save();
      
        $orderNew = Order::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

       $details = $orderNew;
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
     */
    public function orderUpdate(Request $request, $id)
    {
        $this->authorize('update', Order::class);

        unset($request['channel']);
        unset($request['product']);
        unset($request['order_items']);
        unset($request['_method']);

      $order =  Order::where('id', $id)->update([
            'updated_by' => Auth::user()->id,
            'shipping_customer_name' => $request->shipping_customer_name ? $request->shipping_customer_name : '',
            'shipping_address_1' => $request->shipping_address_1 ? $request->shipping_address_1 : '',
            'shipping_address_2' => $request->shipping_address_2 ? $request->shipping_address_2 : '',
            'shipping_address_town' => $request->shipping_address_town ? $request->shipping_address_town : '',
            'shipping_address_city' => $request->shipping_address_city ? $request->shipping_address_city : '',
            'shipping_address_postcode' => $request->shipping_address_postcode ? $request->shipping_address_postcode : '',
            'shipping_country' => $request->shipping_country ? $request->shipping_country : '',
            'description' => $request->description ? $request->description : '',
            'billing_customer_name' => $request->billing_customer_name ? $request->billing_customer_name : '',
            'billing_address_1' => $request->billing_address_1 ? $request->billing_address_1 : '',
            'house_number' => $request->house_number ? $request->house_number : '',
            'billing_address_2' => $request->billing_address_2 ? $request->billing_address_2 : '',
            'billing_city' => $request->billing_city ? $request->billing_city : '',
            'billing_postcode' => $request->billing_postcode ? $request->billing_postcode : '',
            'billing_country' => $request->billing_country ? $request->billing_country : '',
            'shipping_address_phone' => $request->shipping_address_phone ? $request->shipping_address_phone : '',
            'shipping_email' => $request->shipping_email ? $request->shipping_email : '',
            'order_status' => $request->order_status ? $request->order_status : '',
        ]);
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statusUpdate(Request $request, $id)
    {
        $this->authorize('update', Order::class);

        $order = Order::where('id', $id)->update(['updated_by' => Auth::user()->id, 'order_status' => $request->order_status, 'description' => $request->description, 'shipment_tracking_number' => $request->shipment_tracking_number]);
        OrderItem::where('order_id', $id)->update(['updated_by' => Auth::user()->id]);
        $order = Order::where('id', $id)->first();
        if ($order->shipment_tracking_number) {
            $feedback = new Feedback();
            $feedback->customer_id = $order->customer_id;
            $feedback->order_id = $order->id;
            $feedback->status = 'pending';
            $feedback->save();
        }
        if ($order->order_status == 'processing') {
            foreach ($order->orderItems as $item) {
                DeliveryItem::updateOrCreate(['order_id' => $order->id, 'order_item_id' => $item->id], [
                    'order_id' => $order->id,
                    'order_item_id' => $item->id,
                    'delivery_method' => 'Tuffnells',
                    'status' => $order->order_status,
                ]);
            }
        }
        if ($order->order_status == 'replacement') {
            foreach ($order->orderItems as $item) {
                DeliveryItem::updateOrCreate(['order_id' => $order->id, 'order_item_id' => $item->id], [
                    'order_id' => $order->id,
                    'order_item_id' => $item->id,
                    'delivery_method' => 'Tuffnells',
                    'status' => $order->order_status,
                ]);
            }
        }
        if ($order->order_status == 'redispatch') {
            foreach ($order->orderItems as $item) {
                DeliveryItem::updateOrCreate(['order_id' => $order->id, 'order_item_id' => $item->id], [
                    'order_id' => $order->id,
                    'order_item_id' => $item->id,
                    'delivery_method' => 'Tuffnells',
                    'status' => $order->order_status,
                ]);
            }
        }
        if ($order->order_status == 'collection') {
            foreach ($order->orderItems as $item) {
                DeliveryItem::updateOrCreate(['order_id' => $order->id, 'order_item_id' => $item->id], [
                    'order_id' => $order->id,
                    'order_item_id' => $item->id,
                    'delivery_method' => 'Tuffnells',
                    'status' => $order->order_status,
                ]);
            }
        }

        return Redirect::route('orders.show', $id);
    }

    public function productUpdate(Request $request, $id)
    {
        $this->authorize('update', Order::class);

        $data = $request->product_id;

        $newQty = $request->quantity;

        $orderItemQty = OrderItem::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $orderItemQty->id  . '}',
            'module' => $orderItemQty,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);
        //
        //        if ($newQty <= $orderItemQty->quantity) {
        //            $newQrt = $orderItemQty->quantity - $newQty;
        //            $orderItemQty->update(['product_id' => $request->product_id, 'quantity' => $newQty]);
        //
        //            $product = Product::where('id', $data)->select('quantity')->first();
        //            $productQty = $product->quantity + $newQrt;
        //            Product::updateOrCreate(['id' => $data], [
        //                'quantity' => $productQty,
        //            ]);
        //
        //        } else {
        //            $newQrt = $newQty - $orderItemQty->quantity;
        //
        //            $orderItemQty->update(['product_id' => $request->product_id, 'quantity' => $newQty]);
        //
        //            $product = Product::where('id', $data)->select('quantity')->first();
        //
        //            $productQty = $product->quantity - $newQrt;
        //
        //            Product::updateOrCreate(['id' => $data], [
        //                'quantity' => $productQty,
        //            ]);
        //
        //        }

        if ($newQty <= $orderItemQty->quantity) {
            $orderItemQty->update(['product_id' => $request->product_id, 'quantity' => $newQty, 'deal_product_rate_id' => $request->deal_product_rate_id]);
        } else {
            $orderItemQty->update([
                'product_id' => $request->product_id,
                'quantity' => $newQty,
                'deal_product_rate_id' => $request->deal_product_rate_id
            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function chart($data)
    {
        $ordersChart = Order::query();
        if ($data) {
            $ordersChart = $this->filter($ordersChart, $data);
            $dateFrom = strtotime($data['date_from']);
            $dateTo = strtotime($data['date_to']);
        } else {
            $ordersChart = $ordersChart->whereBetween('order_date', [Carbon::today()->subWeek(), Carbon::today()])
                ->orderBy('order_date', 'desc');
            $dateFrom = strtotime(Carbon::today()->subWeek()) + 86400;
            $dateTo = strtotime(Carbon::today());
        }

        for (
            $currentDate = $dateFrom;
            $currentDate <= $dateTo;
            $currentDate += (86400)
        ) {
            $dateRange[] = [date('d/m/Y', $currentDate), 0];
        }

        $ordersChart = $ordersChart->select([
            'order_date',
            DB::raw('COUNT(order_date) as ordercount')
        ])->groupBy('order_date')->get()->toArray();

        $ordersSum = 0;
        foreach ($ordersChart as $singledata) {
            $ordersSum = $ordersSum + $singledata['ordercount'];
        }

        foreach ($dateRange as $key => $range) {
            if ($ordersChart) {
                foreach ($ordersChart as $singledata) {
                    if ($range[0] === date('d/m/Y', strtotime($singledata['order_date']))) {
                        $dateRange[$key][1] = $singledata['ordercount'];
                    }
                    //                    if ($range[0] === $singledata['order_date']) {
                    //                        $dateRange[$key][1] = $singledata['ordercount'];
                    //                    }
                }
                $length = strrpos($range[0], " ");
                $newDate = explode("/", substr($range[0], $length));
                $chartData[] = [
                    0 => intVal($newDate[2]), 1 => (intVal($newDate[1]) - 1),
                    2 => intVal($newDate[0]), 3 => $dateRange[$key][1]
                ];
            } else {
                $length = strrpos($range[0], " ");
                $newDate = explode("/", substr($range[0], $length));
                $chartData[] = [
                    0 => intVal($newDate[2]), 1 => (intVal($newDate[1]) - 1),
                    2 => intVal($newDate[0]), 3 => $dateRange[$key][1]
                ];
            }
        }

        return $chartData;
    }

    public function reportCreate(Request $request)
    {
        $this->authorize('create', Order::class);

        $salesChannels = SalesChannel::Select('name', 'id')->orderBy('name')->get();
        $orders = Order::query();
        $data = $request->all();

        if ($data) {
            $orders = $this->filter($orders, $data);
        } else {
            $orders = $orders->whereBetween('order_date', [date(
                "Y-m-d",
                strtotime(Carbon::today()->subWeek()) + 86400
            ), Carbon::today()])->orderBy(
                'order_date',
                'desc'
            );
        }

        $params = $request->all();
        $dates = [
            'currentDate' => date("Y-m-d", strtotime(Carbon::today())),
            'lastWeekDate' => date("Y-m-d", strtotime(Carbon::today()->subWeek()) + 86400),
            'lastMonthDate' => date("Y-m-d", strtotime(Carbon::today()->subMonth()) + 86400),
            'lastQuarterDate' => date("Y-m-d", strtotime(Carbon::today()->subMonths(3)) + 86400),
            'lastYearDate' => date("Y-m-d", strtotime(Carbon::today()->subMonths(12)) + 86400),
        ];

        return Inertia::render('Reports/OrderReport', [
            'salesChannels' => $salesChannels,
            'orders' => $orders->with(['customer', 'channel'])->orderBy('order_date', 'desc')
                ->paginate(10)->withQueryString(),
            'params' => $params,
            'dates' => $dates,
            'chartData' => $this->chart($data),
        ]);
    }

    public function filter(Builder $query, array $filters)
    {
        if ($filters) {
            $query->where(function ($query) use ($filters) {
                if ($filters['channel_id'] === 'all') {
                    $query->whereBetween('order_date', [
                        date("Y-m-d", strtotime($filters['date_from'])),
                        date("Y-m-d", strtotime($filters['date_to']))
                    ]);
                } else {
                    $query->where('channel_id', $filters['channel_id'])->whereBetween('order_date', [date(
                        "Y-m-d",
                        strtotime($filters['date_from'])
                    ), date("Y-m-d", strtotime($filters['date_to']))]);
                }
            });

            return $query;
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function orderReportExport(Request $request)
    {
        $this->authorize('view', Order::class);

        $dateFrom = date("Ymd", strtotime($request['date_from']));
        $dateTo = date("Ymd", strtotime($request['date_to']));

        if ($request['channel_id'] !== 'all') {
            $channelName = SalesChannel::findOrFail($request['channel_id'])->name;
            $fileName = 'orders-report-channel(' . $channelName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
        } else {
            $fileName = 'orders-report-channel(all)-' . $dateFrom . '-' . $dateTo . '.csv';
        }

        return Excel::download(new OrderReportExport($request), $fileName);
    }

    public function orderReportExportPDF(Request $request)
    {
        $this->authorize('view', Order::class);

        $dateFrom = date("Ymd", strtotime($request['date_from']));
        $dateTo = date("Ymd", strtotime($request['date_to']));

        if ($request['channel_id'] !== 'all') {
            $channelName = SalesChannel::findOrFail($request['channel_id'])->name;
            $fileName = 'orders-report-channel(' . $channelName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
            $orders = Order::whereBetween('order_date', [
                Carbon::parse($request['date_from']),
                Carbon::parse($request['date_to'])
            ])->where('channel_id', $request['channel_id'])->with(
                'customer',
                'channel'
            )->get();
        } else {
            $fileName = 'orders-report-channel(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
            $orders = Order::whereBetween('order_date', [
                Carbon::parse($request['date_from']),
                Carbon::parse($request['date_to'])
            ])->with('customer', 'channel')->get();
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape');
        $sum = $orders->sum('order_total_amount');

        return $pdf->loadView('reports.order', ['orders' => $orders, 'sum' => $sum])->download($fileName, Excel::DomPDF);
    }
}
