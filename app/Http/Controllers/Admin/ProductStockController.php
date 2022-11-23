<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Services\Traits\Search;
use App\Services\Traits\Sort;
use App\Services\Traits\Logger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use App\Exports\Stocks\StockReportExport;
use App\Services\Traits\DefaultActiveLog;

class ProductStockController extends Controller
{
    use Search;
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
        $this->authorize('viewAny', ProductStock::class);

        $this->authorize('viewAny', WarehouseStock::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\ProductStock',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);


        $productStock = ProductStock::query();
//        $productStock = $productStock->where('company_id', Auth::user()->company_id);
        $productStock = $request->get('enable') ? $productStock->where('status', 1) : $productStock;
        $productStock = $request->get('disable') ? $productStock->orWhere('status', 1) : $productStock;
        $productStock = $this->search($productStock, [
            'product_id',
            'quantity',
        ]);
        if ($request->has('query')) {
            $productStock = $productStock->orWhereHas('product', function (Builder $query) {
                $this->search($query, ['name', 'sku']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $productStock = $this->sort($productStock, $columns, $request->get('direction'));
            
        }

        $productStock = $productStock->with('product')->orderBy('id', 'desc')->paginate(10);
        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        if ($request->has('direction') && $request->get('name')) {
            $sortedDta = $productStock->getCollection()->sortBy(function ($productStock) {
                return $productStock->product->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $productStock->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('sku')) {
            $sortedDta = $productStock->getCollection()->sortBy(function ($productStock) {
                return $productStock->product->sku;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $productStock->setCollection(collect($sort));
        }
        return Inertia::render('ProductStocks/Index', [
            'productStocks' => $productStock->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request)
    {
        $sorts = [];
        foreach (['product_id',
                     'quantity',
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        $validate = $this->validate($request, [
//            'product_id' => ['required'],
//            'quantity' => ['required', 'int'],
//        ]);
//
//        $productStocks = new ProductStockController();
//        $productStocks->product_id = $validate['product_id'];
//        $productStocks->quantity = $validate['quantity'];
//        $productStocks->save();
//        return redirect(route('stocks.index'))->with('success', 'Product title created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
        $productStocksChart = ProductStock::query();

        if ($data) {
            $productStocksChart = $this->filter($productStocksChart, $data);
            $dateFrom = strtotime($data['date_from']);
            $dateTo = strtotime($data['date_to']);
        } else {
            $productStocksChart = $productStocksChart->whereBetween('date', [date("Y-m-d",
                strtotime(Carbon::today()->subWeek()) + 86400), date("Y-m-d",
                strtotime(Carbon::today()))]);
            $dateFrom = strtotime(Carbon::today()->subWeek()) + 86400;
            $dateTo = strtotime(Carbon::today());
        }

        for ($currentDate = $dateFrom; $currentDate <= $dateTo;
             $currentDate += (86400)) {
            $dateRange[] = [date('Y-m-d', $currentDate), 0];
        }

        $productStocksChart = $productStocksChart->select([
            'date',
            DB::raw('SUM(quantity) as product_stock_quantity')
        ])->groupBy('date')->get()->toArray();

        foreach ($dateRange as $key => $range) {
            if ($productStocksChart) {
                foreach ($productStocksChart as $singledata) {
                    if ($range[0] === $singledata['date']) {
                        $dateRange[$key][1] = intVal($singledata['product_stock_quantity']);
                    }
                }
                $length = strrpos($range[0], " ");
                $newDate = explode("-", substr($range[0], $length));
                $chartData[] = [0 => intVal($newDate[0]), 1 => (intVal($newDate[1]) - 1), 2 => intVal($newDate[2]),
                    3 => $dateRange[$key][1]];
            } else {
                $length = strrpos($range[0], " ");
                $newDate = explode("-", substr($range[0], $length));
                $chartData[] = [0 => intVal($newDate[0]), 1 => (intVal($newDate[1]) - 1), 2 => intVal($newDate[2]),
                    3 => $dateRange[$key][1]];
            }
        }

        return $chartData;
    }

    public function reportCreate(Request $request)
    {
        $products = Product::Select('name', 'sku', 'id')->orderBy('name')->get();
        $productStocks = ProductStock::query();
        $data = $request->all();

        // $message = 'report Create';
        // $this->logable($productStocks, $message);

        if ($data) {
            $productStocks = $this->filter($productStocks, $data);
            // $message = 'report Create';
            // $this->logable($productStocks, $message);
        } else {
            $productStocks = $productStocks->whereBetween('date', [date("Y-m-d",
                strtotime(Carbon::today()->subWeek()) + 86400), date("Y-m-d",
                strtotime(Carbon::today()))]);
            // $message = 'report Create';
            // $this->logable($productStocks, $message);
        }

        $params = $request->all();
        $dates = [
            'currentDate' => date("Y-m-d", strtotime(Carbon::today())),
            'lastWeekDate' => date("Y-m-d", strtotime(Carbon::today()->subWeek()) + 86400),
            'lastMonthDate' => date("Y-m-d", strtotime(Carbon::today()->subMonth()) + 86400),
            'lastQuarterDate' => date("Y-m-d", strtotime(Carbon::today()->subMonths(3)) + 86400),
            'lastYearDate' => date("Y-m-d", strtotime(Carbon::today()->subMonths(12)) + 86400),
        ];

        return Inertia::render('Reports/StockReport', [
            'products' => $products,
            'productStocks' => $productStocks->with('product')->orderBy('date', 'desc')
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
                if ($filters['product_id'] === 'all') {
                    $query->whereBetween('date', [date("Y-m-d", strtotime($filters['date_from'])),
                        date("Y-m-d", strtotime($filters['date_to']))]);
                } else {
                    $query->where('product_id', $filters['product_id'])->whereBetween('date', [date("Y-m-d",
                        strtotime($filters['date_from'])), date("Y-m-d", strtotime($filters['date_to']))]);
                }
            });

            return $query;
        }
    }

    public function stockReportExport(Request $request)
    {
        $dateFrom = date("Ymd", strtotime($request['date_from']));
        $dateTo = date("Ymd", strtotime($request['date_to']));

        if ($request['product_id'] !== 'all') {
            $productName = Product::findOrFail($request['product_id'])->name;
            $fileName = 'stocks-report-product(' . $productName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
        } else {
            $fileName = 'stocks-report-product(all)-' . $dateFrom . '-' . $dateTo . '.csv';
        }

        return Excel::download(new StockReportExport($request), 'custom.xlsx');
    }

    public function stockReportExportPDF(Request $request)
    {
        $dateFrom = date("Ymd", strtotime($request['date_from']));
        $dateTo = date("Ymd", strtotime($request['date_to']));

        if ($request['product_id'] !== 'all') {
            $productName = Product::findOrFail($request['product_id'])->name;
            $fileName = 'stocks-report-product(' . $productName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
            $productStocks = ProductStock::where('product_id', $request['product_id'])->whereBetween('date',
                [date("Y-m-d", strtotime($request['date_from'])), date("Y-m-d",
                    strtotime($request['date_to']))])->with('product')->get();
        } else {
            $fileName = 'stocks-report-product(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
            $productStocks = ProductStock::whereBetween('date',
                [date("Y-m-d", strtotime($request['date_from'])), date("Y-m-d",
                    strtotime($request['date_to']))])->with('product')->get();
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape');
        $sum = $productStocks->sum('quantity');
        return $pdf->loadView('reports.stock', ['productStocks' => $productStocks, 'sum' => $sum])
            ->download($fileName, Excel::DOMPDF);
    }
}
