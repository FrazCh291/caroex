<?php

namespace App\Http\Controllers\SalesChannel;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Amazon;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Http\Controllers\Controller;

class AmazonController extends Controller
{
    use Sort;
    use Filter;
    use Search;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Amazon::class);

        $amazons = Amazon::query();
        $amazons = $amazons->where('company_id', Auth::user()->company_id);
        $amazons = $request->get('enable') ? $amazons->where('enable', 1) : $amazons;
        $amazons = $request->get('disable') ? $amazons->where('enable', 0) : $amazons;
        $amazons = $this->search($amazons, [
            'product_id',
            'import_id',
            'company_id',
            'order_id',
            'customer_name',
            'phone',
            'email',
            'postal_address_1',
            'postal_address_2',
            'postal_address_3',
            'postal_address_4',
            'ship_city',
            'ship_country',
            'ship_state',
            'post_code',
            'item_name',
            'asin',
            'order_item_id',
            'sku',
            'quantity',
            'order_date',
            'dispatch_date',
            'reason_for_late_dispatch',
            'freight_company',
            'tracking_number',
            'notes'
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $amazons = $this->sort($amazons, $columns, $request->get('direction'));
        }

        $amazons = $amazons->orderBy('id', 'desc')->paginate(10);

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Amazon/Index', [
            'amazons' => $amazons->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request)
    {
        $sorts = [];
        foreach (['product_id',
                     'import_id',
                     'company_id',
                     'order_id',
                     'customer_name',
                     'phone',
                     'email',
                     'postal_address_1',
                     'postal_address_2',
                     'postal_address_3',
                     'postal_address_4',
                     'ship_city',
                     'ship_country',
                     'ship_state',
                     'post_code',
                     'item_name',
                     'asin',
                     'order_item_id',
                     'sku',
                     'quantity',
                     'order_date',
                     'dispatch_date',
                     'reason_for_late_dispatch',
                     'freight_company',
                     'tracking_number',
                     'notes',] as $sort) {
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
}
