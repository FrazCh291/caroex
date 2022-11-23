<?php

namespace App\Http\Controllers\SalesChannel;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Xstreamgym;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Http\Controllers\Controller;

class XstreamgymController extends Controller
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
        $this->authorize('viewAny',Xstreamgym::class);

        $xstreamgyms = Xstreamgym::query();
        $xstreamgyms = $xstreamgyms->where('company_id', Auth::user()->company_id);
        $xstreamgyms = $request->get('enable') ? $xstreamgyms->where('enable', 1) : $xstreamgyms;
        $xstreamgyms = $request->get('disable') ? $xstreamgyms->orWhere('enable', 0) : $xstreamgyms;
        $xstreamgyms = $this->search($xstreamgyms, [
            "import_id",
            "order_number",
            "order_status",
            "order_date",
            "customer_note",
            "billing_first_name",
            "billing_last_name",
            "billing_company",
            "billing_address_1_2",
            "billing_city",
            "billing_state_code",
            "billing_postcode",
            "billing_country_code",
            "billing_email",
            "billing_phone",
            "shipping_first_name",
            "shipping_last_name",
            "shipping_address_1_2",
            "shipping_city",
            "shipping_state_code",
            "shipping_postcode",
            "shipping_country_code",
            "payment_method_title",
            "cart_discount_amount",
            "order_subtotal_amount",
            "shipping_method_title",
            "order_shipping_amount",
            "order_refund_amount",
            "order_total_amount",
            "order_total_tax_amount",
            "sku",
            "item",
            "item_name",
            "quantity",
            "item_cost",
            "coupon_code",
            "discount_amount",
            "discount_amount_tax"
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $xstreamgyms = $this->sort($xstreamgyms, $columns, $request->get('direction'));
        }

        $xstreamgyms = $xstreamgyms->orderBy('id', 'desc')->paginate(10);

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Xstreamgym/Index', [
            'xstreamgyms' => $xstreamgyms->withQueryString(),
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
        foreach (["import_id",
                     "order_number",
                     "order_status",
                     "order_date",
                     "customer_note",
                     "billing_first_name",
                     "billing_last_name",
                     "billing_company",
                     "billing_address_1_2",
                     "billing_city",
                     "billing_state_code",
                     "billing_postcode",
                     "billing_country_code",
                     "billing_email",
                     "billing_phone",
                     "shipping_first_name",
                     "shipping_last_name",
                     "shipping_address_1_2",
                     "shipping_city",
                     "shipping_state_code",
                     "shipping_postcode",
                     "shipping_country_code",
                     "payment_method_title",
                     "cart_discount_amount",
                     "order_subtotal_amount",
                     "shipping_method_title",
                     "order_shipping_amount",
                     "order_refund_amount",
                     "order_total_amount",
                     "order_total_tax_amount",
                     "sku",
                     "item",
                     "item_name",
                     "quantity",
                     "item_cost",
                     "coupon_code",
                     "discount_amount",
                     "discount_amount_tax"] as $sort) {
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
