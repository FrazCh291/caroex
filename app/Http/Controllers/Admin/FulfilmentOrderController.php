<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Traits\DefaultActiveLog;


class FulfilmentOrderController extends Controller
{
    use Search;
    use Sort;
    use Filter;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAnyorder', Order::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Order',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $order = Order::query();

        if ($request->get('shipped')) {
            $order = $request->get('shipped') ? $order->where('order_status', 'shipped') : $order;
        }
        if ($request->get('pending')) {
            $order = $request->get('pending') ? $order->orWhere('order_status', 'pending') : $order;
        }
        if ($request->get('redispatch')) {
            $order = $request->get('redispatch') ? $order->orWhere('order_status', 'redispatch') : $order;
        }
        if ($request->get('processing')) {
            $order = $request->get('processing') ? $order->orWhere('order_status', 'processing') : $order;
        }
        if ($request->get('cancelled')) {
            $order = $request->get('cancelled') ? $order->orWhere('order_status', 'cancelled') : $order;
        }
        if ($request->get('completed')) {
            $order = $request->get('completed') ? $order->orWhere('order_status', 'completed') : $order;
        }
        if ($request->get('collection')) {
            $order = $request->get('collection') ? $order->orWhere('order_status', 'collection') : $order;
        }
        if ($request->get('replacement')) {
            $order = $request->get('replacement') ? $order->orWhere('order_status', 'replacement') : $order;
        }
        $order = $order->where('company_id', Auth::user()->company_id);
        $order = $this->search($order, [
            'id',
            'order_status',
            'order_date',
        ]);

        if ($request->has('query')) {
            $order = $order->orWhereHas('customer', function (Builder  $query) {
                $this->search($query, [
                    'name',
                    'address1_2',
                    'shipping_address_1',
                    'shipping_address_2',
                    'phone',
                    'email'
                ]);
            });
        }

        if ($request->has('query')) {
            $order = $order->orWhereHas('product', function (Builder $query) {
                $this->search($query, [
                    'name',
                ]);
            });
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $order = $this->sort($order, $columns, $request->get('direction'));
        }


        $order = $order->with('customer')->orderBy('order_date', 'desc')->paginate(10)->withQueryString();
        $order1 = Order::distinct('order_status')->pluck('order_status')->toArray();
        if ($request->has('direction') && $request->get('customer_id')) {
            $sortedDta = $order->getCollection()->sortBy(function ($order) {
                return $order->customer->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $order->setCollection(collect($sort));
        }

        if ($request->has('direction') && $request->get('address')) {
            $sortedDta = $order->getCollection()->sortBy(function ($order) {
                return $order->customer->address1_2;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $order->setCollection(collect($sort));
        }

        if ($request->has('direction') && $request->get('product_id')) {
            $sortedDta = $order->getCollection()->sortBy(function ($order) {
                return $order->product->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $order->setCollection(collect($sort));
        }
        $params = $request->all();

        return Inertia::render('FullfilmentOrder/Index', ['orders' => $order, 'order1'=>$order1, 'params' => $params]);
    }


    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
                     'customer_id',
                     'address1_2',
                     'product_id',
                     'order_date',
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
        $this->authorize('createorder', Order::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Order',
            'activity' => 'Create',
            'type' => 'fulfilment',
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('vieworder', Order::class);

        $showOrder = Order::with('customer')->findOrfail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Order',
            'activity' => 'Show',
            'type' => 'fulfilment',
            'path' => $slice
        ];
        $this->defaultFun($module);

        return Inertia::render('FullfilmentOrder/Show', ['order' => $showOrder]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('updateorder', Order::class);
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
        $this->authorize('deleteorder', Order::class);
    }
}
