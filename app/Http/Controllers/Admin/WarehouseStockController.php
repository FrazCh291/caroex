<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Models\WarehouseStock;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Traits\DefaultActiveLog;

class WarehouseStockController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',WarehouseStock::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\WarehouseStock',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $warehouseStocks = WarehouseStock::query();
        $warehouseStocks = $warehouseStocks->where('company_id', Auth::user()->company_id);
        $warehouseStocks = $request->get('enable') ? $warehouseStocks->where('status', 1) : $warehouseStocks;
        $warehouseStocks = $request->get('disable') ? $warehouseStocks->orWhere('status', 1) : $warehouseStocks;
        $warehouseStocks = $this->search($warehouseStocks, [
            'product_id',
            'warehouse_id',
            'quantity',
        ]);

        if ($request->has('query')) {
            $warehouseStocks = $warehouseStocks->orWhereHas('product', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('query')) {
            $warehouseStocks = $warehouseStocks->orWhereHas('wareHouse', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $warehouseStocks = $this->sort($warehouseStocks, $columns, $request->get('direction'));
        }

        if ($request->has('direction') && $request->get('product_id')) {
            $sortedDta = $warehouseStocks->getCollection()->sortBy(function ($warehouseStocks) {
                return $warehouseStocks->product->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $warehouseStocks->setCollection(collect($sort));
        }

        if ($request->has('direction') && $request->get('warehouse_id')) {
            $sortedDta = $warehouseStocks->getCollection()->sortBy(function ($warehouseStocks) {
                return $warehouseStocks->wareHouse->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $warehouseStocks->setCollection(collect($sort));
        }

        $warehouseStocks = $warehouseStocks->with(['product', 'wareHouse'])->orderBy('id', 'desc')->paginate(10);

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('WarehouseStocks/Index', [
            'warehouseStocks' => $warehouseStocks->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach (['product_id',
                     'warehouse_id',
                     'company_id',
                     'quantity'] as $sort) {
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
//        $products = Product::select('name', 'id')->get();
//        $warehouses = Warehouse::select('name', 'id')->get();
//
//        return Inertia::render('WarehouseStocks/Create', [
//            'products' => $products,
//            'warehouses' => $warehouses,
//        ]);
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
//            'warehouse_id' => ['required'],
//            'quantity' => ['required', 'int'],
//        ]);
//
//        $warehouseStocks = new WarehouseStock();
//        $warehouseStocks->product_id = $validate['product_id'];
//        $warehouseStocks->warehouse_id = $validate['warehouse_id'];
//        $warehouseStocks->quantity = $validate['quantity'];
//        $warehouseStocks->save();

//        $warehouseStockstems = new StockLog();
//        $warehouseStockstems->product_id = $validate['product_id'];
//        $warehouseStockstems->warehouse_id = $validate['warehouse_id'];
//        $warehouseStockstems->supplier_id = isset($validate['supplier_id']) ? $validate['supplier_id'] : 1;
//        $warehouseStockstems->quantity = $validate['quantity'];
//        $warehouseStockstems->user_id = Auth::user()->id;
//        $warehouseStockstems->save();
        return redirect(route('stocks.index'))->with('success', 'Product title created successfully');
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
//        $warehouseStocks = Stock::findOrFail($id);
//        $warehouses = Warehouse::Select('name', 'id')->get();
//        $products = Product::Select('name', 'id')->get();
//
//        return Inertia::render('WarehouseStocks/Create', [
//            'products' => $products,
//            'warehouses' => $warehouses,
//            'stocks' => $warehouseStocks,
//        ]);
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
//        $warehouseStocks = Stock::findOrFail($id);
//        $validate = $this->validate($request, [
//            'product_id' => ['required'],
//            'warehouse_id' => ['required'],
//            'quantity' => ['required', 'int'],
//        ]);
//
//        $warehouseStocks->product_id = $validate['product_id'];
//        $warehouseStocks->warehouse_id = $validate['warehouse_id'];
//        $warehouseStocks->quantity = $validate['quantity'];
//        $warehouseStocks->save();
//
//        return redirect(route('stocks.index'))->with('success', 'Product title created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $warehouseStocks = Stock::findOrFail($id);
//        $warehouseStocks->delete();
//
//        return redirect(route('stocks.index'))->with('success', 'Product title created successfully');
    }
}
