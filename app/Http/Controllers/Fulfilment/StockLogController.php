<?php

namespace App\Http\Controllers\Fulfilment;

use App\Exports\Stocks\StockReportExport;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Product;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\ProductStock;
use App\Models\StockLog;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use App\Models\WarehouseStock;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Sort;
use App\Services\Traits\Logger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Traits\DefaultActiveLog;


class StockLogController extends Controller
{
    use Search;
    use Sort;
    use Filter;
    use Logger;
    use DefaultActiveLog;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAnyone', StockLog::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\StockLog',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $stockLogs = StockLog::query();
        $stockLogs = $stockLogs->where('company_id', Auth::user()->company_id);
        $stockLogs = $request->get('enable') ? $stockLogs->where('status', 1) : $stockLogs;
        $stockLogs = $request->get('disable') ? $stockLogs->orWhere('status', 0) : $stockLogs;
        $stockLogs = $this->search($stockLogs, [
            'product_id',
            'warehouse_id',
            'supplier_id',
            'order_item_id',
            'user_id',
            'quantity',
            'created_at',
        ]);
        if ($request->has('query')) {
            $stockLogs = $stockLogs->orWhereHas('supplier', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('query')) {
            $stockLogs = $stockLogs->orWhereHas('product', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        //        if ($request->has('query')) {
        //            $stockLogs = $stockLogs->orWhereHas('orderItem', function (Builder $query) {
        //                $this->search($query, ['name']);
        //            });
        //        }
        if ($request->has('query')) {
            $stockLogs = $stockLogs->orWhereHas('wareHouse', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('query')) {
            $stockLogs = $stockLogs->orWhereHas('user', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $stockLogs = $this->sort($stockLogs, $columns, $request->get('direction'));
        }
        $stockLogs = $stockLogs->with(['supplier', 'wareHouse', 'product', 'orderItem', 'user', 'company'])->orderBy(
            'updated_at',
            'DESC'
        )->paginate(10);

        if ($request->has('direction') && $request->get('supplier_id')) {
            $sortedDta = $stockLogs->getCollection()->sortBy(function ($stockLogs) {
                return $stockLogs->company->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $stockLogs->setCollection(collect($sort));
        }

        if ($request->has('direction') && $request->get('product_id')) {
            $sortedDta = $stockLogs->getCollection()->sortBy(function ($stockLogs) {
                return $stockLogs->product->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $stockLogs->setCollection(collect($sort));
        }

        if ($request->has('direction') && $request->get('warehouse_id')) {
            $sortedDta = $stockLogs->getCollection()->sortBy(function ($stockLogs) {
                return $stockLogs->wareHouse->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $stockLogs->setCollection(collect($sort));
        }

        //        if ($request->get('warehouse_id')) {
        //            $stockLogs = $stockLogs->where('warehouse_id', $request->get('warehouse_id'))->with(['supplier', 'wareHouse', 'product', 'user'])->paginate(10);
        //        } else {
        //            $stockLogs = $stockLogs->with(['supplier', 'wareHouse', 'product', 'orderItem', 'user'])->paginate(10);
        //        }

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';


        return Inertia::render('Fulfilment/StockLogs/Index', [
            'stockLogs' => $stockLogs->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach (['product_id',
                     'warehouse_id',
                     'supplier_id',
                     'order_item_id',
                     'user_id',
                     'quantity',
                     'created_at'] as $sort) {
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
        $this->authorize('createstock',StockLog::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\StockLog',
            'activity' => 'Create',
            'type' => 'fulfilment',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $products = Product::Select('name', 'id')->get();
        $suppliers = Company::where('type', 'supplier_company')->get();
        $warehouses = Company::Select('name', 'id')->where('type', 'warehouse')->get();

        return Inertia::render('Fulfilment/StockLogs/Create', [
            'products' => $products,
            'suppliers' => $suppliers,
            'warehouses' => $warehouses
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
        'product_id' => ['required'],
        'warehouse_id' => ['required'],
        'supplier_id' => ['required'],
        'quantity' => ['required'],
    ]);

        $stockLogs = new StockLog();
        $stockLogs->company_id = Auth::user()->company_id;
        $stockLogs->product_id = $request->product_id[0];
        $stockLogs->warehouse_id = $request->warehouse_id;
        $stockLogs->supplier_id = $request->supplier_id;
        $stockLogs->quantity = $request->quantity;
        $stockLogs->user_id = Auth::user()->id;
        $stockLogs->save();

//        $currentURL = url()->current();
//        $slice = Str::after($currentURL, '8000');
//        $module = [
//            'message' => '{' . $stockLogs->id  .'}',
//            'module' => $stockLogs,
//            'activity' => 'Store',
//            'type' => 'fulfilment',
//            'path' => $slice,
//        ];
//
//        $this->logable($module);

        $productStock = ProductStock::where('product_id', $request->product_id[0])->where(
            'company_id',
            Auth::user()->company_id
        )->first();
        if ($productStock) {
            $productStock->quantity = intVal($productStock->quantity) + intVal($request->quantity);
            $productStock->date = date("Y-m-d", strtotime(Carbon::today()));
            $productStock->save();

                    $currentURL = url()->current();
                    $slice = Str::after($currentURL, '8000');
                    $module = [
                        'message' => '{' . $productStock->id  .'}',
                        'module' => $productStock,
                        'activity' => 'Store',
                        'type' => 'fulfilment',
                        'path' => $slice.'/'.$productStock->id,
                    ];
                   $this->logable($module);

        } else {
            $productStock = new ProductStock();
            $productStock->company_id = Auth::user()->company_id;
            $productStock->product_id = $request->product_id[0];
            $productStock->quantity = intVal($request->quantity);
            $productStock->date = date("Y-m-d", strtotime(Carbon::today()));
            $productStock->save();

//            $currentURL = url()->current();
//                    $slice = Str::after($currentURL, '8000');
//                    $module = [
//                        'message' => '{' . $productStock->id  .'}',
//                        'module' => $productStock,
//                        'activity' => 'Store',
//                        'type' => 'fulfilment',
//                        'path' => $slice,
//                    ];
//                   $this->logable($module);

        }

        $warehouseStock = WarehouseStock::where('product_id', $request->product_id[0])->where('warehouse_id', $request->warehouse_id)
            ->where('company_id', Auth::user()->company_id)->first();
        if ($warehouseStock) {
            $warehouseStock->quantity = $warehouseStock->quantity + $request->quantity;
            $warehouseStock->save();

//            $currentURL = url()->current();
//            $slice = Str::after($currentURL, '8000');
//
//            $module = [
//            'message' => '{' . $warehouseStock->id  .'}',
//            'module' => $warehouseStock,
//            'activity' => 'Store',
//            'type' => 'fulfilment',
//            'path' => $slice,
//        ];
//        $this->logable($module);


        } else {
            $warehouseStock = new WarehouseStock();
            $warehouseStock->company_id = Auth::user()->company_id;
            $warehouseStock->product_id = $request->product_id[0];
            $warehouseStock->warehouse_id = $request->warehouse_id;
            $warehouseStock->quantity = $request->quantity;
            $warehouseStock->company_id = Auth::user()->company->id;
            $warehouseStock->save();
//
//            $module = [
//                'message' => '{' . $warehouseStock->id  .'}',
//                'module' => $warehouseStock,
//                'activity' => 'Store',
//                'type' => 'fulfilment',
//                'path' => $slice,
//            ];
//            $this->logable($module);

        }

        return redirect(route('stock-log.index'))->with('success', 'Product title created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('createstock',StockLog::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id, Request $request)
    {
        $this->authorize('updatestock',StockLog::class);

        $stockLogs = StockLog::findOrFail($id);
        $suppliers = Company::where('type', 'supplier_company')->get();
        $warehouses = Warehouse::Select('name', 'id')->where('company_id',Auth::user()->company_id)->get();
        $values = Product::where('id', $stockLogs->product_id)->get();
        $products = Product::Select('name', 'id')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $stockLogs->id  .'}',
            'module' => $stockLogs,
            'activity' => 'Edit',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Fulfilment/StockLogs/Create', [
            'products' => $products,
            'suppliers' => $suppliers,
            'warehouses' => $warehouses,
            'stockItems' => $stockLogs,
            'values' => $values,
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
        $stockLogs = StockLog::findOrFail($id);
        $validate = $this->validate($request, [
            'product_id' => ['required'],
            'warehouse_id' => ['required'],
            'supplier_id' => ['required'],
            'quantity' => ['required'],
        ]);

        $stockLogs->product_id = $request->value[0];
        $stockLogs->warehouse_id = $validate['warehouse_id'];
        $stockLogs->supplier_id = $validate['supplier_id'];
        $stockLogs->quantity = $validate['quantity'];

        $stockLogs->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $stockLogs->id  .'}',
            'module' => $stockLogs,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        $productStock = ProductStock::where('product_id', $request->value[0])->where('company_id',
            Auth::user()->company_id)->where('date',date("Y-m-d", strtotime(Carbon::today())))->first();
        if ($productStock) {
            $productStock->quantity = intVal($productStock->quantity) - $request['old_quantity'] +
                intVal($validate['quantity']);
            $productStock->save();

            $module = [
                'message' => '{' . $productStock->id  .'}',
                'module' => $productStock,
                'activity' => 'Update',
                'type' => 'fulfilment',
                'path' => $slice,
            ];
            $this->logable($module);

        } else {
            $productLastQuantity = ProductStock::where('product_id', $request->value[0])->orderBy('date',
                'desc')->where('date','<',date("Y-m-d", strtotime(Carbon::today())))->first();
            $productStock = new ProductStock();
            if($productLastQuantity) {
                $productStock->quantity = intVal($productLastQuantity->quantity) - $request['old_quantity'] +
                    intVal($validate['quantity']);
            }
            else {
                $productStock->quantity = intVal($validate['quantity']);
            }
            $productStock->company_id = Auth::user()->company_id;
            $productStock->product_id = $request->value[0];
            $productStock->date = date("Y-m-d", strtotime(Carbon::today()));
            $productStock->save();
        }

        $warehouseStock = WarehouseStock::where('product_id', $request->value[0])->where('warehouse_id', $validate['warehouse_id'])
            ->where('company_id', Auth::user()->company_id)->first();
        if ($warehouseStock) {
            $warehouseStock->quantity = $validate['quantity'];
            $warehouseStock->save();

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');

            $module = [
                'message' => '{' . $warehouseStock->id  .'}',
                'module' => $warehouseStock,
                'activity' => 'Update',
                'type' => 'fulfilment',
                'path' => $slice,
            ];

            $this->logable($module);


        } else {
            $warehouseStock = new WarehouseStock();
            $warehouseStock->company_id = Auth::user()->company_id;
            $warehouseStock->product_id = $request->value[0];
            $warehouseStock->warehouse_id = $validate['warehouse_id'];
            $warehouseStock->quantity = $validate['quantity'];
            $warehouseStock->company_id = Auth::user()->company->id;
            $warehouseStock->save();

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');

            $module = [
                'message' => '{' . $warehouseStock->id  .'}',
                'module' => $warehouseStock,
                'activity' => 'Update',
                'type' => 'fulfilment',
                'path' => $slice,
            ];

            $this->logable($module);
        }
        return redirect(route('stock-log.index'))->with('success', 'Product title created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('deletestock',StockLog::class);

        $stockLogs = StockLog::findOrFail($id);
        $stockLogs->delete();

        $module = [
            'message' => '{' . $stockLogs->id  .'}',
            'module' => $stockLogs,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return redirect(route('stock-log.index'))->with('success', 'Product title created successfully');
    }

    public function chart($stockLogs, $dateRange,$datesDifference)
    {
        $data = $stockLogs->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantity) as Quantity'))->groupBy('date')->get()->toArray();
        foreach($dateRange as $key =>$range) {
            if($data) {
                foreach ($data as $singledata) {
                    if ($range[0] === $singledata['created_at']) {
                        $dateRange[$key][1] = $singledata['orderCount'];
                    }
//                    $length = strrpos($range[0], " ");
//                    $newDate = explode("/", substr($range[0], $length));
//                    $chartData[] = [0 => intVal($newDate[2]), 1 => (intVal($newDate[1]) - 1), 2 => intVal($newDate[0]), 3 => $dateRange[$key][1]];
                }
            }
            else {
//                $length = strrpos($range[0], " ");
//                $newDate = explode("/", substr($range[0], $length));
//                $chartData[] = [0 => intVal($newDate[2]), 1 => (intVal($newDate[1]) - 1), 2 => intVal($newDate[0]), 3 => $dateRange[$key][1]];
            }
        }

//        return $chartData;
    }

    public function reportCreate(Request $request)
    {
        $this->authorize('create',StockLog::class);

        $products = Product::Select('name', 'id')->orderBy('name')->get();
        $warehouses = Warehouse::Select('name', 'id')->orderBy('name')->get();
        $suppliers = Supplier::Select('name', 'id')->orderBy('name')->get();
        $stockLogs = StockLog::query();
        $data = $request->all();

        if ($data) {
            $stockLogs = $this->filter($stockLogs, $data);
            $dateFrom = strtotime($request['date_from']);
            $dateTo = strtotime($request['date_to']);
        } else {
            $stockLogs = $stockLogs->whereBetween('created_at', [date("Y-m-d 00:00:00",
                strtotime(Carbon::today()->subWeek())), date("Y-m-d 23:59:59",
                strtotime(Carbon::today()))])->orderBy('created_at', 'desc');
            $dateFrom = strtotime(Carbon::today()->subWeek())+ 86400;
            $dateTo = strtotime(Carbon::today());
        }

        $datesDifference = ($dateTo-$dateFrom)/86400;
        for ($currentDate = $dateFrom; $currentDate <= $dateTo;
             $currentDate += (86400)) {
            $dateRange[] = [date('d/m/Y', $currentDate),0];
        }

        $params = $request->all();
        $dates = [
            'currentDate' => date("Y-m-d", strtotime(Carbon::today())),
            'lastWeekDate' => date("Y-m-d", strtotime(Carbon::today()->subWeek())),
            'lastMonthDate' => date("Y-m-d", strtotime(Carbon::today()->subMonth())),
        ];

        return Inertia::render('Reports/StockReport', [
            'products' => $products,
            'warehouses' => $warehouses,
            'suppliers' => $suppliers,
            'stockLogs' => $stockLogs->with(['supplier', 'wareHouse', 'product'])->paginate(10)->withQueryString(),
            'params' => $params,
            'dates' => $dates,
//            'chartData' => $this->chart($stockLogs, $dateRange,$datesDifference),
        ]);
    }

    public function filter(Builder $query, array $filters)
    {
        if ($filters) {
            $query->where(function ($query) use ($filters) {
                if (isset($filters['product_id']) && !isset($filters['warehouse_id']) && !isset($filters['supplier_id'])) {
                    if ($filters['product_id'] === 'all') {
                        $query->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    } else {
                        $query->where('product_id', $filters['product_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    }
                }
                if (!isset($filters['product_id']) && isset($filters['warehouse_id']) && !isset($filters['supplier_id'])) {
                    if ($filters['warehouse_id'] === 'all') {
                        $query->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    } else {
                        $query->where('warehouse_id', $filters['warehouse_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    }
                }
                if (!isset($filters['product_id']) && !isset($filters['warehouse_id']) && isset($filters['supplier_id'])) {
                    if ($filters['supplier_id'] === 'all') {
                        $query->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    } else {
                        $query->where('supplier_id', $filters['supplier_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    }
                }
                if (isset($filters['product_id']) && isset($filters['warehouse_id']) && !isset($filters['supplier_id'])) {
                    if ($filters['product_id'] === 'all' && $filters['warehouse_id'] === 'all') {
                        $query->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    } elseif ($filters['product_id'] === 'all' && $filters['warehouse_id'] !== 'all') {
                        $query->where('warehouse_id', $filters['warehouse_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    } elseif ($filters['product_id'] !== 'all' && $filters['warehouse_id'] === 'all') {
                        $query->where('product_id', $filters['product_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    } else {
                        $query->where('product_id', $filters['product_id'])->where('warehouse_id',
                            $filters['warehouse_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    }
                }
                if (isset($filters['product_id']) && !isset($filters['warehouse_id']) && isset($filters['supplier_id'])) {
                    if ($filters['product_id'] === 'all' && $filters['supplier_id'] === 'all') {
                        $query->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    } elseif ($filters['product_id'] === 'all' && $filters['supplier_id'] !== 'all') {
                        $query->where('supplier_id', $filters['supplier_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    } elseif ($filters['product_id'] !== 'all' && $filters['supplier_id'] === 'all') {
                        $query->where('product_id', $filters['product_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    } else {
                        $query->where('product_id', $filters['product_id'])->where('supplier_id',
                            $filters['supplier_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    }
                }
                if (!isset($filters['product_id']) && isset($filters['warehouse_id']) && isset($filters['supplier_id'])) {
                    if ($filters['warehouse_id'] === 'all' && $filters['supplier_id'] === 'all') {
                        $query->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    } elseif ($filters['warehouse_id'] === 'all' && $filters['supplier_id'] !== 'all') {
                        $query->where('supplier_id', $filters['supplier_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    } elseif ($filters['warehouse_id'] !== 'all' && $filters['supplier_id'] === 'all') {
                        $query->where('warehouse_id', $filters['warehouse_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    } else {
                        $query->where('warehouse_id', $filters['warehouse_id'])->where('supplier_id',
                            $filters['supplier_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    }
                }
                if (isset($filters['product_id']) && isset($filters['warehouse_id']) && isset($filters['supplier_id'])) {
                    if ($filters['product_id'] === 'all' && $filters['warehouse_id'] === 'all' && $filters['supplier_id'] === 'all') {
                        $query->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    } elseif ($filters['product_id'] !== 'all' && $filters['warehouse_id'] === 'all' && $filters['supplier_id'] === 'all') {
                        $query->where('product_id', $filters['product_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    } elseif ($filters['product_id'] === 'all' && $filters['warehouse_id'] !== 'all' && $filters['supplier_id'] === 'all') {
                        $query->where('warehouse_id', $filters['warehouse_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    } elseif ($filters['product_id'] === 'all' && $filters['warehouse_id'] === 'all' && $filters['supplier_id'] !== 'all') {
                        $query->where('supplier_id', $filters['supplier_id'])->whereBetween('created_at',
                            [date("Y-m-d 00:00:00", strtotime($filters['date_from'])),
                                date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                    } elseif ($filters['product_id'] !== 'all' && $filters['warehouse_id'] !== 'all' && $filters['supplier_id'] === 'all') {
                        $query->where('product_id', $filters['product_id'])->where('warehouse_id',
                            $filters['warehouse_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    } elseif ($filters['product_id'] !== 'all' && $filters['warehouse_id'] === 'all' && $filters['supplier_id'] !== 'all') {
                        $query->where('product_id', $filters['product_id'])->where('supplier_id',
                            $filters['supplier_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    } elseif ($filters['product_id'] === 'all' && $filters['warehouse_id'] !== 'all' && $filters['supplier_id'] !== 'all') {
                        $query->where('warehouse_id', $filters['warehouse_id'])->where('supplier_id',
                            $filters['supplier_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                            strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                            strtotime($filters['date_to']))]);
                    } else {
                        $query->where('product_id', $filters['product_id'])->where('warehouse_id',
                            $filters['warehouse_id'])->where('supplier_id', $filters['supplier_id'])
                            ->whereBetween('created_at', [date("Y-m-d 00:00:00",
                                strtotime($filters['date_from'])), date("Y-m-d 23:59:59",
                                strtotime($filters['date_to']))]);
                    }
                }
                if (!isset($filters['product_id']) && !isset($filters['warehouse_id']) && !isset($filters['supplier_id'])) {
                    $query->whereBetween('created_at', [date("Y-m-d 00:00:00", strtotime($filters['date_from'])), date("Y-m-d 23:59:59", strtotime($filters['date_to']))]);
                }
            });

            return $query;
        }
    }

    public function stockReportExport(Request $request)
    {
        $this->authorize('view',StockLog::class);

        $dateFrom = date("Ymd", strtotime($request['date_from']));
        $dateTo = date("Ymd", strtotime($request['date_to']));
        if ($request['product_id'] !== null && $request['warehouse_id'] == null && $request['supplier_id'] == null) {
            if ($request['product_id'] === 'all') {
                $fileName = 'stocks-report-product(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } else {
                $productName = Product::findOrFail($request['product_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            }
        }
        if ($request['product_id'] == null && $request['warehouse_id'] !== null && $request['supplier_id'] == null) {
            if ($request['warehouse_id'] === 'all') {
                $fileName = 'stocks-report-warehouse(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } else {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-warehouse(' . $warehouseName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            }
        }
        if ($request['product_id'] == null && $request['warehouse_id'] == null && $request['supplier_id'] !== null) {
            if ($request['supplier_id'] === 'all') {
                $fileName = 'stocks-report-supplier(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } else {
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-warehouse(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            }
        }
        if ($request['product_id'] !== null && $request['warehouse_id'] !== null && $request['supplier_id'] == null) {
            if ($request['product_id'] === 'all' && $request['warehouse_id'] === 'all') {
                $fileName = 'stocks-report-product(all)-warehouse(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['product_id'] === 'all' && $request['warehouse_id'] !== 'all') {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-product(all)-warehouse(' . $warehouseName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['product_id'] !== 'all' && $request['warehouse_id'] === 'all') {
                $productName = Product::findOrFail($request['product_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } else {
                $productName = Product::findOrFail($request['product_id'])->name;
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(' . $warehouseName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            }
        }
        if ($request['product_id'] !== null && $request['warehouse_id'] == null && $request['supplier_id'] !== null) {
            if ($request['product_id'] === 'all' && $request['supplier_id'] === 'all') {
                $fileName = 'stocks-report-product(all)-supplier(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['product_id'] === 'all' && $request['supplier_id'] !== 'all') {
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(all)-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['product_id'] !== 'all' && $request['supplier_id'] === 'all') {
                $productName = Product::findOrFail($request['product_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-supplier(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } else {
                $productName = Product::findOrFail($request['product_id'])->name;
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            }
        }
        if ($request['product_id'] == null && $request['warehouse_id'] !== null && $request['supplier_id'] !== null) {
            if ($request['warehouse_id'] === 'all' && $request['supplier_id'] === 'all') {
                $fileName = 'stocks-report-warehouse(all)-supplier(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['warehouse_id'] === 'all' && $request['supplier_id'] !== 'all') {
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-warehouse(all)-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['warehouse_id'] !== 'all' && $request['supplier_id'] === 'all') {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-warehouse(' . $warehouseName . ')-supplier(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } else {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-warehouse(' . $warehouseName . ')-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            }
        }
        if ($request['product_id'] !== null && $request['warehouse_id'] !== null && $request['supplier_id'] !== null) {
            if ($request['product_id'] === 'all' && $request['warehouse_id'] === 'all' && $request['supplier_id'] === 'all') {
                $fileName = 'stocks-report-product(all)-warehouse(all)-supplier(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['product_id'] !== 'all' && $request['warehouse_id'] === 'all' && $request['supplier_id'] === 'all') {
                $productName = Product::findOrFail($request['product_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(all)-supplier(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['product_id'] === 'all' && $request['warehouse_id'] !== 'all' && $request['supplier_id'] === 'all') {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-product(all)-warehouse(' . $warehouseName . ')-supplier(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['product_id'] === 'all' && $request['warehouse_id'] === 'all' && $request['supplier_id'] !== 'all') {
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(all)-warehouse(all)-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['product_id'] !== 'all' && $request['warehouse_id'] !== 'all' && $request['supplier_id'] === 'all') {
                $productName = Product::findOrFail($request['product_id'])->name;
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(' . $warehouseName . ')-supplier(all)-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['product_id'] !== 'all' && $request['warehouse_id'] === 'all' && $request['supplier_id'] !== 'all') {
                $productName = Product::findOrFail($request['product_id'])->name;
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(all)-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            } elseif ($request['product_id'] === 'all' && $request['warehouse_id'] !== 'all' && $request['supplier_id'] !== 'all') {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(all)-warehouse(' . $warehouseName . ')-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            } else {
                $productName = Product::findOrFail($request['product_id'])->name;
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(' . $warehouseName . ')-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.csv';
            }
        }
        if ($request['product_id'] == null && $request['warehouse_id'] == null && $request['supplier_id'] == null) {
            $fileName = 'stocks-report-' . $dateFrom . '-' . $dateTo . '.csv';
        }

        return Excel::download(new StockReportExport($request), $fileName);
    }

    public function stockReportExportPDF(Request $request)
    {
        $this->authorize('view',StockLog::class);

        $dateFrom = date("Ymd", strtotime($request['date_from']));
        $dateTo = date("Ymd", strtotime($request['date_to']));
        if ($request['product_id'] !== null && $request['warehouse_id'] == null && $request['supplier_id'] == null) {
            if ($request['product_id'] === 'all') {
                $fileName = 'stocks-report-product(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            } else {
                $productName = Product::findOrFail($request['product_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('product_id', $request['product_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            }
        }
        if ($request['product_id'] == null && $request['warehouse_id'] !== null && $request['supplier_id'] == null) {
            if ($request['warehouse_id'] === 'all') {
                $fileName = 'stocks-report-warehouse(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            } else {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-warehouse(' . $warehouseName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('warehouse_id', $request['warehouse_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            }
        }
        if ($request['product_id'] == null && $request['warehouse_id'] == null && $request['supplier_id'] !== null) {
            if ($request['supplier_id'] === 'all') {
                $fileName = 'stocks-report-supplier(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            } else {
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('supplier_id', $request['supplier_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            }
        }
        if ($request['product_id'] !== null && $request['warehouse_id'] !== null && $request['supplier_id'] == null) {
            if ($request['product_id'] === 'all' && $request['warehouse_id'] === 'all') {
                $fileName = 'stocks-report-product(all)-warehouse(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['product_id'] === 'all' && $request['warehouse_id'] !== 'all') {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-product(all)-warehouse(' . $warehouseName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('warehouse_id', $request['warehouse_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['product_id'] !== 'all' && $request['warehouse_id'] === 'all') {
                $productName = Product::findOrFail($request['product_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('product_id', $request['product_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            } else {
                $productName = Product::findOrFail($request['product_id'])->name;
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(' . $warehouseName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('product_id', $request['product_id'])->where('warehouse_id',
                    $request['warehouse_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            }
        }
        if ($request['product_id'] !== null && $request['warehouse_id'] == null && $request['supplier_id'] !== null) {
            if ($request['product_id'] === 'all' && $request['supplier_id'] === 'all') {
                $fileName = 'stocks-report-product(all)-supplier(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['product_id'] === 'all' && $request['supplier_id'] !== 'all') {
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(all)-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('supplier_id', $request['supplier_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['product_id'] !== 'all' && $request['supplier_id'] === 'all') {
                $productName = Product::findOrFail($request['product_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-supplier(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('product_id', $request['product_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            } else {
                $productName = Product::findOrFail($request['product_id'])->name;
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('product_id', $request['product_id'])->where('supplier_id',
                    $request['supplier_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            }
        }
        if ($request['product_id'] == null && $request['warehouse_id'] !== null && $request['supplier_id'] !== null) {
            if ($request['warehouse_id'] === 'all' && $request['supplier_id'] === 'all') {
                $fileName = 'stocks-report-warehouse(all)-supplier(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['warehouse_id'] === 'all' && $request['supplier_id'] !== 'all') {
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-warehouse(all)-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('supplier_id', $request['supplier_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['warehouse_id'] !== 'all' && $request['supplier_id'] === 'all') {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-warehouse(' . $warehouseName . ')-supplier(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('warehouse_id', $request['warehouse_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            } else {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-warehouse(' . $warehouseName . ')-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('warehouse_id', $request['warehouse_id'])->where('supplier_id',
                    $request['supplier_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            }
        }
        if ($request['product_id'] !== null && $request['warehouse_id'] !== null && $request['supplier_id'] !== null) {
            if ($request['product_id'] === 'all' && $request['warehouse_id'] === 'all' && $request['supplier_id'] === 'all') {
                $fileName = 'stocks-report-product(all)-warehouse(all)-supplier(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['product_id'] !== 'all' && $request['warehouse_id'] === 'all' && $request['supplier_id'] === 'all') {
                $productName = Product::findOrFail($request['product_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(all)-supplier(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('product_id', $request['product_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['product_id'] === 'all' && $request['warehouse_id'] !== 'all' && $request['supplier_id'] === 'all') {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-product(all)-warehouse(' . $warehouseName . ')-supplier(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('warehouse_id', $request['warehouse_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['product_id'] === 'all' && $request['warehouse_id'] === 'all' && $request['supplier_id'] !== 'all') {
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(all)-warehouse(all)-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('supplier_id', $request['supplier_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['product_id'] !== 'all' && $request['warehouse_id'] !== 'all' && $request['supplier_id'] === 'all') {
                $productName = Product::findOrFail($request['product_id'])->name;
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(' . $warehouseName . ')-supplier(all)-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('product_id', $request['product_id'])->where('warehouse_id',
                    $request['warehouse_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['product_id'] !== 'all' && $request['warehouse_id'] === 'all' && $request['supplier_id'] !== 'all') {
                $productName = Product::findOrFail($request['product_id'])->name;
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(all)-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('product_id', $request['product_id'])->where('supplier_id',
                    $request['supplier_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            } elseif ($request['product_id'] === 'all' && $request['warehouse_id'] !== 'all' && $request['supplier_id'] !== 'all') {
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(all)-warehouse(' . $warehouseName . ')-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('warehouse_id', $request['warehouse_id'])->where('supplier_id',
                    $request['supplier_id'])->whereBetween('created_at', [date("Y-m-d 00:00:00",
                    strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                    ->with('product', 'wareHouse', 'supplier')->get();
            } else {
                $productName = Product::findOrFail($request['product_id'])->name;
                $warehouseName = Warehouse::findOrFail($request['warehouse_id'])->name;
                $supplierName = Supplier::findOrFail($request['supplier_id'])->name;
                $fileName = 'stocks-report-product(' . $productName . ')-warehouse(' . $warehouseName . ')-supplier(' . $supplierName . ')-' . $dateFrom . '-' . $dateTo . '.pdf';
                $stockLogs = StockLog::where('product_id', $request['product_id'])->where('warehouse_id',
                    $request['warehouse_id'])->where('supplier_id', $request['supplier_id'])->whereBetween('created_at',
                    [date("Y-m-d 00:00:00", strtotime($request['date_from'])), date("Y-m-d 23:59:59",
                        strtotime($request['date_to']))])->with('product', 'wareHouse', 'supplier')->get();
            }
        }
        if ($request['product_id'] == null && $request['warehouse_id'] == null && $request['supplier_id'] == null) {
            $fileName = 'stocks-report-' . $dateFrom . '-' . $dateTo . '.pdf';
            $stockLogs = StockLog::whereBetween('created_at', [date("Y-m-d 00:00:00",
                strtotime($request['date_from'])), date("Y-m-d 23:59:59", strtotime($request['date_to']))])
                ->with('product', 'wareHouse', 'supplier')->get();
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape');
        $sum = $stockLogs->sum('quantity');
        return $pdf->loadView('reports.stock', ['stockLogs' => $stockLogs, 'sum' => $sum])->download($fileName, Excel::DOMPDF);
    }
}
