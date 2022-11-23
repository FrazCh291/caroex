<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Lookup;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductTitle;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Logger;
use App\Services\Traits\Filter;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLogsDetails;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\Products\ProductExport;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Traits\DefaultActiveLog;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ProductController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;

    private $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Product',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,

        ];
        $this->defaultFun($module);


        $products = Product::query();
        if ($request->get('type') == 'type_spare_part') {
            $products->where('product_type', 'spare_part');

            $sparePart = true;
        } else {
            $products->where('product_type', 'product');
            $sparePart = false;
        }

        $products = $products->where('company_id', Auth::user()->company_id);
        $products = $request->get('enable') ? $products->where('enable', 1) : $products;
        $products = $request->get('disable') ? $products->orWhere('enable', 0) : $products;
        $products = $this->search($products, [
            'name',
            'shipping_method',
            'color',
            'sku',
            'image',
            'price',
            'stock',
            'description',
        ]);

        if ($request->has('query')) {
            $products = $products->orWhereHas('warehouseStocks', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('query')) {
            $products = $products->orWhereHas('prodcutStock', function (Builder $query) {
                $this->search($query, ['quantity']);
            });
        }
        if ($request->has('query')) {
            $products = $products->orWhereHas('reviews', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('query')) {
            $products = $products->orWhereHas('reviews', function (Builder $query) {
                $this->search($query, ['rating']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $products = $this->sort($products, $columns, $request->get('direction'));
        }

        $products = $products->with(['reviews', 'warehouseStocks.wareHouse', 'prodcutStock', 'order', 'productType'])
            ->orderBy('name', 'asc')->paginate(10);
        if ($request->has('direction') && $request->get('quantity')) {
            $sortedDta = $products->getCollection()->sortBy(function ($product) {
                return $product->prodcutStock->quantity;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $products->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('rating')) {
            $sortedDta = $products->getCollection()->sortBy(function ($product) {
                foreach ($product->reviews as $review)
                    return $review->rating;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $products->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('sales_report')) {
            $sortedDta = $products->getCollection()->sortBy(function ($product) {
                foreach ($product->reviews as $review)
                    return $review->rating;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $products->setCollection(collect($sort));
        }
        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Products/Index', [
            'products' => $products->withQueryString(),
            'sparePart' => $sparePart,
            'params' => $params,
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
            'shipping_method',
            'sku',
            'color',
            'image',
            'price',
            'stock',
            'description'
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
     * @return \Inertia\Response
     */
    public function create()
    {

        $this->authorize('create', Product::class);


        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Product',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $productTypes = Lookup::where('type', 'product_type')->get();
        $this->defaultFun($module);

        return Inertia::render('Products/Create', [
            'productTypes' => $productTypes
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
            'name' => ['required'],
            'sku' => ['required'],
            'weight_unit' => ['required'],
            'product_type' => ['required'],
            'price' => ['required', 'numeric'],
            'shipping_method' => ['required'],
        ]);
        $path = null;
        if ($request->file('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '.' . $extension;
            $path = 'storage/' . $request->file('image')->storeAs('Products', $fileNameToStore);
        }

        $product = new Product();
        $product->company_id = Auth::user() ? Auth::user()->company_id : '';
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->weight_unit = $request->weight_unit;
        $product->product_type = $request->product_type;
        $product->image = $path;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->shipping_method = $request->shipping_method;
        $product->description = $request->description;
        $product->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $product->id . '}',
            'module' => $product,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice . '/' . $product->id,
        ];
        $this->logable($module);

        return Redirect::route('product-details.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show($id, Request $request)
    {
        $this->authorize('view', Product::class);
        //        $products = Product::with(['order', 'prodcutStock'])->where('id', $id)->first();
        //
        //        $totalStock = ProductStock::where('product_id', $id)->pluck('quantity');
        //        $stockDate = ProductStock::where('product_id', $id)->select('created_at')->first();
        //        $data = $products->order()->where('order_date', '>=', Carbon::now()->subMonth(3))->select([

        $product = Product::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $product->id . '}',
            'module' => $product,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->logable($module);

        $data = $product->order()->where('order_date', '>=', Carbon::now()->subMonth())->select([

            'order_date',
            DB::raw('SUM(quantity) as quantity')
        ])->groupBy('order_date')->get()->toArray();

        $dateFrom = strtotime(Carbon::today()->subMonth()) + 86400;
        $dateTo = strtotime(Carbon::today());

        for (
            $currentDate = $dateFrom;
            $currentDate <= $dateTo;
            $currentDate += (86400)
        ) {
            $dateRange[] = [date('d/m/Y', $currentDate), 0];
        }

        if ($data) {
            $totalStocks = ProductStock::where('product_id', $id)->where('date', '<=', Carbon::now())->orderBy(
                'date',
                'desc'
            )->first()->quantity;
            if ($totalStocks > 0) {
                foreach ($dateRange as $key => $range) {
                    foreach ($data as $singleData) {
                        if ($range[0] === $singleData['order_date']) {
                            $dateRange[$key][1] = $singleData['quantity'];
                        }
                    }
                    $length = strrpos($range[0], " ");
                    $newDate = explode("/", substr($range[0], $length));
                    $chartData[] = [
                        0 => intVal($newDate[2]), 1 => (intVal($newDate[1]) - 1),
                        2 => intVal($newDate[0]), 3 => intVal($dateRange[$key][1])
                    ];
                }
                $saleQuantity = 0;
                foreach ($data as $singleData) {
                    $saleQuantity = $saleQuantity + intVal($singleData['quantity']);
                }
                $quantityPerMonth = $totalStocks / $saleQuantity;
                $stockEndDate = Carbon::today()->addMonth($quantityPerMonth);
                $length = strrpos(date('d/m/Y', strtotime($stockEndDate)), " ");
                $newDate = explode("/", substr(date('d/m/Y', strtotime($stockEndDate)), $length));
                $chartData[] = [
                    0 => intVal($newDate[2]), 1 => (intVal($newDate[1]) - 1),
                    2 => intVal($newDate[0]), 3 => intVal(0)
                ];
            } else {
                foreach ($dateRange as $key => $range) {
                    foreach ($data as $singleData) {
                        if ($range[0] === $singleData['order_date']) {
                            $dateRange[$key][1] = $singleData['quantity'];
                        }
                    }
                    $length = strrpos($range[0], " ");
                    $newDate = explode("/", substr($range[0], $length));
                    $chartData[] = [
                        0 => intVal($newDate[2]), 1 => (intVal($newDate[1]) - 1),
                        2 => intVal($newDate[0]), 3 => intVal($dateRange[$key][1])
                    ];
                }
            }
        } else {
            foreach ($dateRange as $key => $range) {
                $length = strrpos($range[0], " ");
                $newDate = explode("/", substr($range[0], $length));
                $chartData[] = [
                    0 => intVal($newDate[2]), 1 => (intVal($newDate[1]) - 1),
                    2 => intVal($newDate[0]), 3 => intVal($dateRange[$key][1])
                ];
            }
        }

        return Inertia::render('Products/Show', [
            'chartData' => $chartData
        ]);

        //        $stockDate = ProductStock::where('product_id', $id)->select('created_at')->first();
        //        $data = $products->order()->where('order_date', '>=', Carbon::now()->subMonth(3))->select([
        //            'order_date',
        //            DB::raw('SUM(quantity) as quantity')
        //        ])->groupBy('order_date')->get()->toArray();

        //        if (!$data) {
        //            $chart = $this->chart->areaChart()
        //                ->setTitle('Sales Report')
        //                ->addArea('orders', [0])
        //                ->toJson();
        //
        //            return Inertia::render('Products/Show', [
        //                'products' => $products,
        //                'chart' => $chart,
        //                'totalStock' => $totalStock,
        //                'closingStock' => 0,
        //                'closingStockDate' => 0,
        //                'date' => '0',
        //                'sum' => 0,
        //                'stockDate' => 0,
        //            ]);
        //        } else {
        //            $index = $data[count($data) - 1];
        //            $closingStockDate = $index['order_date'];
        //            $orderDate = array_column($data, 'order_date');
        //            $orderQuantity = array_column($data, 'quantity');
        //            $sum = array_sum($orderQuantity);
        //            $remainStock = $totalStock[0] / $sum;
        //            $currentDateTime = Carbon::now();
        //            $newDateTime = $currentDateTime->addMonth($remainStock);
        //            $dateFormat = $newDateTime->format('d/m/Y');
        //            $date = $dateFormat;
        //            $orderDateLength = count($orderDate);
        //            $orderQuantityLength = count($orderQuantity);
        //
        //            $data = array(
        //                $orderDateLength + 1 => $date,
        //            );
        //
        //            $data1 = array(
        //                $orderQuantityLength + 1 => 0
        //            );
        //
        //            $orderDate = array_merge($orderDate, $data);
        //            $orderQuantity = array_merge($orderQuantity, $data1);
        //
        //            $chart = $this->chart->areaChart()
        //                ->setTitle('Sales Report')
        //                ->addArea('Sales', $orderQuantity)
        //                ->setXAxis($orderDate)
        //                ->toJson();

        //            return Inertia::render('Products/Show', [
        //                'products' => $products,
        //                'chart' => $chart,
        //                'totalStock' => $totalStock,
        //                'closingStock' => $totalStock[0] - $sum,
        //                'closingStockDate' => $closingStockDate,
        //                'date' => $date,
        //                'sum' => $sum,
        //                'stockDate' => $stockDate
        //            ]);
        //        }
    }

    /**
     * Show the form for editing the specified resource.
     *)
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Product::class);

        $product = Product::findOrFail($id);

        $productTypes = Lookup::where('type', 'product_type')->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $product->id . '}',
            'module' => $product,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->logable($module);

        return Inertia::render('Products/Create', [
            'product' => $product,
            'productTypes' => $productTypes
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
            'name' => ['required'],
            'sku' => ['required'],
            'weight_unit' => ['required'],
            'product_type' => ['required'],
            'image' => ['required'],
            'price' => ['required', 'numeric'],
            'shipping_method' => ['required'],
        ]);
        $product = Product::find($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $product->id . '}',
            'module' => $product,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->logable($module);
        $logData = $this->logable($module);
        $details = $product;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        if ($request->file('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '.' . $extension;
            $path = 'storage/' . $request->file('image')->storeAs('Products', $fileNameToStore);
            $product->image = $path;
        }
            $product->company_id = Auth::user() ? Auth::user()->company_id : '';
            $product->name = $request->name;
            $product->product_type = $request->product_type;
            $product->sku = $request->sku;
            $product->weight_unit = $request->weight_unit;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->shipping_method = $request->shipping_method;
            $product->update();

        return Redirect::route('product-details.index')->with('success', 'Product created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', Product::class);

        $Product = Product::findOrFail($id);
        $Product->delete();

        $module = [
            'message' => '{' . $Product->id . '}',
            'module' => $Product,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];
        $this->logable($module);

        return Redirect::route('product-details.index')->with('success', 'Product deleted successfully');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function productExport(Request $request)
    {
        return Excel::download(new ProductExport(), 'products.csv');
    }
}
