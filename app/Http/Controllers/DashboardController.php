<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Shipment;
use Illuminate\Support\Str;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Logger;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Traits\DefaultActiveLog;
use App\Exports\Stocks\StockReportExport;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use Sort;
    use Logger;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Dashboard',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $payrolls = Payroll::query();
        if ($request->requestDuration === 'lastYear') {
            $payroll = Payroll::orderBy('from', 'desc')->first();
            if ($payroll) {
                $lastTwelveMonth = Carbon::parse($payroll->from)->subMonth(11);
                $payrolls = $payrolls->whereBetween('from', [date('Y-m-d', strtotime($lastTwelveMonth)), $payroll->from])->get();

            }
        } else {
            $payroll = Payroll::orderBy('from', 'desc')->first();
            if ($payroll) {
                $lastSixMonth = Carbon::parse($payroll->from)->subMonth(5);
                $payrolls = $payrolls->whereBetween('from', [date('Y-m-d', strtotime($lastSixMonth)), $payroll->from])->get();
            }

        }
        $payRollChartDates = [];
        $totalSalary = [];
        foreach ($payrolls as $payroll) {
            $currDate = $payroll->from;
            $payRollChartDates[] = date("M , Y", strtotime($currDate));
            $totalSalary[] = $payroll->total_paid ?? 0.00;
        }
        if (array_key_exists('requestDuration', $request->all())) {
            return response()->json(['payRollChartDates' => $payRollChartDates, 'totalSalary' => $totalSalary], 200);
        }
        // shipment and stocks
        $shipments = Shipment::with('shipmentItems.product')->where('actual_arrival_date', null)->get();
        $products = Product::with('prodcutStock')->get();
        $productsTotalQuantity = 0;
        foreach($products as $product) {
            if($product->prodcutStock !== null) {
                $productsTotalQuantity = $productsTotalQuantity + $product->prodcutStock->quantity;
            }
        }

        $productStocks = ProductStock::query();
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $productStocks = $this->sort($productStocks, $columns, $request->get('direction'));
        }
        if ($request->date) {
            $productStocks = ProductStock::with('product')->where('date', $request->date)->get();
        }
        else {
            $productStocks = $productStocks->with('product')->where('quantity', '!=', 0)
                ->orderBy('quantity', 'desc')->get();
        }
        $totalQuantity = $productStocks->sum('quantity');
        $params = $request->all();
        if ($request->has('direction') && $request->get('product_id')) {
            $sortedDta = $productStocks->sortBy(function ($productStocks) {
                return $productStocks->product->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);

            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $productStocks = (collect($sort));
        }
        if ($request->has('direction') && $request->get('sku')) {
            $sortedDta = $productStocks->sortBy(function ($productStocks) {
                return $productStocks->product->sku;
            }, 3, $request->get('direction') == 'desc' ? true : false);

            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $productStocks = (collect($sort));
        }

        $colors = [
            'X2 White' => '#030303',
            'X2 Black' => '#5B8DEE',
            'X2 Red' => '#660FF1',
            'E-bykka Black' => '#6F42C1',
            'E-bykka Red' => '#E93E8C',
            'Q4 flex Black' => '#FF5B5C',
            'Q4 flex White' => '#FD7E15',
            'A6 Basic' => '#FEAB41',
            'X Trainer Black' => '#39DA8A',
            'X Trainer White' => '#21C89A',
            'Fascial Gun' => '#00D0DD',
            'A6 Multi' => '#495563',
            'Racer White' => '#A8ACB5',
            'Racer Red' => '#4EDCE6',
            'Racer Black' => '#63D9B6',
            'XF Black' => '#FDC57B',
            'XF White' => '#FDA55B',
            'X1 Black' => '#FF8D8D',
            'X7 Black' => '#EF78AE',
            'X1 White' => '#9C7BD4',
            'Q3 flex' => '#9559F7',
            'Breeze B3' => '#8EAFF6',
            'E-Glide Light' => '#ABC5F6',
            'Zah Z1 Garden Tool' => '#B186F9',
            'X1 Red' => '#B59FE0',
            'X4 Black' => '#F49CC4',
            'T3 Red' => '#FFABAE',
            'T3 Gold' => '#FEBC88',
            'Road Racer Conti Bike Cycle Red' => '#FED59F',
            'Road Racer Conti Bike Cycle Black' => '#9AECC4',
            'Equinox Pro Black' => '#8FE3CB',
            'Equinox Pro White' => '#7EE7ED',
            'Equinox Pro Red' => '#D1D5D8',
            'Equinox Pro Black/Blue' => '#CEDDFA',
            'Equinox Pro Black/Gold' => '#D1B8FC',
            'Equinox Pro Black/Red' => '#D6C5EF',
            'Equinox Pro White/Red' => '#F9C5DC',
            'Mercedes Black' => '#FFCECF',
            'Mercedes WHT' => '#FFD7B9',
            'Mercedes Red' => '#FFE6C7',
            'Audi Yellow' => '#C4F4DC',
            'Audi Red' => '#BCEFE0',
            'Audi White' => '#B4F1F4',
            'Jeep Black' => '#EFF0F2',
            'Jeep Red' => '#5B8DEE',
            'Jeep White' => '#660FF1',
            'Wheel Abbs D004 Large' => '#6F42C1',
            'Wheel Abbs Small' => '#6F42C1',
            'Wheel Abbs LRG' => '#E93E8C',
            'Neck massage' => '#FF5B5C',
            'Drone Camera' => '#FD7E15',
            'Abs Crunch' => '#FEAB41',
            'Garden Tool' => '#39DA8A',
            'Vibration Plate Black' => '#21C89A',
            'Vibration Plate Red' => '#00D0DD',
            'Vibration Plate Blue' => '#495563',
            'Vibration Plate Pink' => '#A8ACB5',
            'Exploding Kittens' => '#4EDCE6',
            'Test' => '#63D9B6',
            'HD1 Black' => '#FDC57B',
            'E1 Black' => '#FDA55B',
            'Organix Sanitiser' => '#FF8D8D',
            'VP1 Black' => '#EF78AE',
            'RV1 Black' => '#9C7BD4',
        ];

        //dd($productStocks);
        if (array_key_exists('requestType', $request->all())) {
            return response()->json([$productStocks, $params, $totalQuantity], 200);
        }
            // area chart
            $currentMonthStartDate = Carbon::parse(Carbon::today()->year."-".Carbon::today()->month."-01");
            $dateRange[] = '';
            for (
                $currentDate = strtotime($currentMonthStartDate);
                $currentDate <= strtotime(Carbon::today());
                $currentDate += (86400)
            ) {
                $dateRange[] = date('d/m', $currentDate);
            }
            $dateRange[] = '';
            $ordersChart = Order::query();
            $ordersChart = $ordersChart->whereBetween('order_date', [date("Y-m-d", strtotime($currentMonthStartDate)), date("Y-m-d", strtotime(Carbon::today()))]);
            $ordersChart = $ordersChart->select([
                'order_date',
                DB::raw('COUNT(order_date) as ordercount')
            ])->groupBy('order_date')->get()->toArray();
            $chartData[] = '';
            foreach ($dateRange as $key => $range) {
                $status = false;
                if ($ordersChart) {
                    foreach ($ordersChart as $singledata) {
                        if ($range === date('d/m', strtotime($singledata['order_date'])) && $key !== 0 && $key !== sizeof($dateRange)-1) {
                            $chartData[] = $singledata['ordercount'];
                            $status = true;
                        }
                    }    
                }
                if($status === false  && $key !== 0 && $key !== sizeof($dateRange)-1) {
                    $chartData[] = 0;
                }
            } 
        $chartData[] = '';   
// end
        return Inertia::render('Dashboard', [
            'productStocks' => $productStocks,
            'productsTotalQuantity' => $productsTotalQuantity,
            'shipments' => $shipments,
            'colors' => $colors,
            'products' =>$products,
            'params' => $params,
            'totalQuantity' => $totalQuantity,
            'currentDate' => date("Y-m-d", strtotime(Carbon::now())),
            'payRollChartDates' => $payRollChartDates,
            'totalSalary' => $totalSalary,
            'dateRange' => $dateRange,
            'chartData' => $chartData,
        ]);

    }

    public function sortables(Request $request)
    {
        $sorts = [];
        foreach (['product_id',
                     'sku',
                     'quantity'
                 ] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }
        return $sorts;
    }
   // area chart
    public function orderSummaryChart()
    {
            $lastMonthStartDate = Carbon::parse(Carbon::today()->year."-".(Carbon::today()->month-1)."-01");
            $lastMonthEndDate = Carbon::parse(Carbon::today()->year."-".Carbon::today()->month."-01")->subDay();
            $dateRange[] = '';
            for (
                $currentDate = strtotime($lastMonthStartDate);
                $currentDate <= strtotime($lastMonthEndDate);
                $currentDate += (86400)
            ) {
                $dateRange[] = date('d/m', $currentDate);
            }
            $dateRange[] = '';
            $ordersChart = Order::query();
            $ordersChart = $ordersChart->whereBetween('order_date', [date("Y-m-d", strtotime($lastMonthStartDate)), date("Y-m-d", strtotime($lastMonthEndDate))]);
            $ordersChart = $ordersChart->select([
                'order_date',
                DB::raw('COUNT(order_date) as ordercount')
            ])->groupBy('order_date')->get()->toArray();
            $chartData[] = '';
            foreach ($dateRange as $key => $range) {
                $status = false;
                if ($ordersChart) {
                    foreach ($ordersChart as $singledata) {
                        if ($range === date('d/m', strtotime($singledata['order_date'])) && $key !== 0 && $key !== sizeof($dateRange)-1) {
                            $chartData[] = $singledata['ordercount'];
                            $status = true;
                        }
                    }    
                }
                if($status === false  && $key !== 0 && $key !== sizeof($dateRange)-1) {
                    $chartData[] = 0;
                }
            } 
            $chartData[] = ''; 
            return response()->json([
                'dateRange' => $dateRange,
                'chartData' => $chartData
            ]);
    }
        // end
    public function stockCsvDownload($date)
    {
        $date = date("Ymd", strtotime($date));
        $fileName = 'stocks-report' . $date . '.csv';

        return Excel::download(new StockReportExport($date), $fileName);
    }

    public function datePicker(Request $request)
    {
        $productStock = ProductStock::with('product')->where('date', $request['params']['date'])->get();
        $totalQuantity = $productStock->sum('quantity');

        return response()->json([$productStock, $totalQuantity], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('craete');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('store');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        dd($request->all());
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
