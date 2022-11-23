<?php

namespace App\Http\Controllers\SalesChannel;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Groupon;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;

use App\Http\Controllers\Controller;

class GrouponController extends Controller
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
        $this->authorize('viewAny',Groupon::class);

        $groupons = Groupon::query();
        $groupons = $groupons->where('company_id', Auth::user()->company_id);
        $groupons = $request->get('enable') ? $groupons->where('enable', 1) : $groupons;
        $groupons = $request->get('disable') ? $groupons->orWhere('enable', 0) : $groupons;
        $groupons = $this->search($groupons, [
            'import_id',
            'fulfillment_line_item_id',
            'groupon_number',
            'order_date',
            'merchant_sku_item',
            'quantity_requested',
            'shipment_method_requested',
            'shipment_address_name',
            'shipment_address_street',
            'shipment_address_city',
            'shipment_address_postal_code',
            'shipment_address_country',
            'gift',
            'gift_message',
            'quantity_shipped',
            'shipment_carrier',
            'shipment_method',
            'shipment_tracking_number',
            'ship_date',
            'groupon_sku',
            'custom_field_value',
            'permalink',
            'item_name',
            'vendor_id',
            'salesforce_deal_option_id',
            'groupon_cost',
            'billing_address_name',
            'billing_address_street',
            'billing_address_city',
            'billing_address_stat',
            'billing_address_postal_code',
            'billing_address_country',
            'purchase_order_number',
            'product_weight',
            'product_weight_unit',
            'product_length',
            'product_height',
            'product_dimension_unit',
            'customer_phone',
            'incoterms',
            'hts_code',
            'pl_name',
            'pl_warehouse_location',
            'kitting_details',
            'sell_price',
            'deal_opportunity_id',
            'fulfillment_method',
            'country_of_origin',
            'merchant_permalink',
            'feature_start_date',
            'feature_end_date',
            'bom_sku'
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $groupons = $this->sort($groupons, $columns, $request->get('direction'));
        }

        $groupons = $groupons->orderBy('id', 'desc')->paginate(10);

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Groupon/Index', [
            'groupons' => $groupons->withQueryString(),
            'params' => $params
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function sortables(Request $request)
    {
        $sorts = [];
        foreach (['import_id',
                     'fulfillment_line_item_id',
                     'groupon_number',
                     'order_date',
                     'merchant_sku_item',
                     'quantity_requested',
                     'shipment_method_requested',
                     'shipment_address_name',
                     'shipment_address_street',
                     'shipment_address_city"',
                     'shipment_address_postal_code',
                     'shipment_address_country',
                     'gift',
                     'gift_message',
                     'quantity_shipped',
                     'shipment_carrier',
                     'shipment_method',
                     'shipment_tracking_number',
                     'ship_date',
                     'groupon_sku',
                     'custom_field_value',
                     'permalink',
                     'item_name',
                     'vendor_id',
                     'salesforce_deal_option_id',
                     'groupon_cost',
                     'billing_address_name',
                     'billing_address_street',
                     'billing_address_city',
                     'billing_address_stat',
                     'billing_address_postal_code',
                     'billing_address_country',
                     'purchase_order_number',
                     'product_weight',
                     'product_weight_unit',
                     'product_length',
                     'product_height',
                     'product_dimension_unit',
                     'customer_phone',
                     'incoterms',
                     'hts_code',
                     'pl_name',
                     'pl_warehouse_location',
                     'kitting_details',
                     'sell_price',
                     'deal_opportunity_id',
                     'fulfillment_method',
                     'country_of_origin',
                     'merchant_permalink',
                     'feature_start_date',
                     'feature_end_date',
                     'bom_sku'] as $sort) {
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
