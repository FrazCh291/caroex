<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Services\Traits\Sort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StockController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $products = Product::query();
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
    //    dd($request->all());
        if ($request->has('query')) {
            $products = $products->orWhereHas('warehouseStocks', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('query')) {
            $products = $products->orWhereHas('supplier', function (Builder $query) {
                $this->search($query, ['supplier_id']);
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
        
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $products = $this->sort($products, $columns, $request->get('direction'));
        }

        $products = $products->with(['reviews', 'warehouseStocks.wareHouse', 'prodcutStock'])->orderBy('id', 'desc')->paginate(10);

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Stocks/Dashboard', [
            'products' => $products->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request)
    {
        $sorts = [];
        foreach (['name',
                     'shipping_method',
                     'sku',
                     'color',
                     'image',
                     'price',
                     'stock',
                     'quantity',
                     'description'] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }

        return $sorts;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
