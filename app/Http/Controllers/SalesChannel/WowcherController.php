<?php

namespace App\Http\Controllers\SalesChannel;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Wowcher;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Http\Controllers\Controller;

class WowcherController extends Controller
{
    use Sort;
    use Filter;
    use Search;

    public function __construct()
    {
//        $this->authorizeResource(Wowcher::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {

        $this->authorize('viewAny',Wowcher::class);

        $wowchers = Wowcher::query();
        $wowchers = $wowchers->where('company_id', Auth::user()->company_id);
        $wowchers = $request->get('enable') ? $wowchers->where('enable', 1) : $wowchers;
        $wowchers = $request->get('disable') ? $wowchers->orWhere('enable', 0) : $wowchers;
        $wowchers = $this->search($wowchers, [
            'import_id',
            'deal_id',
            'redeemed_at',
            'wowcher_code',
            'deal_title',
            'customer_name',
            'house_number',
            'address_line_1',
            'address_line_2',
            'city',
            'country',
            'postcode',
            'email',
            'phone',
            'birthday',
            'marketing_permission',
            'product_name',
            'product_options',
            'sku',
            'despatch_method',
            'import_id'
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $wowchers = $this->sort($wowchers, $columns, $request->get('direction'));
        }

        $wowchers = $wowchers->orderBy('id', 'desc')->paginate(10);

        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Wowcher/Index', [
            'wowchers' => $wowchers->withQueryString(),
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
                     'deal_id',
                     'redeemed_at',
                     'wowcher_code',
                     'deal_title',
                     'customer_name',
                     'house_number',
                     'address_line_1',
                     'address_line_2',
                     'city',
                     'country',
                     'postcode',
                     'email',
                     'phone',
                     'birthday',
                     'marketing_permission',
                     'product_name',
                     'product_options',
                     'sku',
                     'despatch_method',
                     'import_id'] as $sort) {
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
