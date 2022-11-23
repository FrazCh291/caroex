<?php

namespace App\Http\Controllers\SalesChannel;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Gogroopie;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Http\Controllers\Controller;

class GogroopieController extends Controller
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
        $this->authorize('viewAny',Gogroopie::class);

        $gogroopies = Gogroopie::query();
        $gogroopies = $gogroopies->where('company_id', Auth::user()->company_id);
        $gogroopies = $request->get('enable') ? $gogroopies->where('enable', 1) : $gogroopies;
        $gogroopies = $request->get('disable') ? $gogroopies->orWhere('enable', 0) : $gogroopies;
        $gogroopies = $this->search($gogroopies, [
            'deal_id',
            'import_id',
            'voucher_code',
            'full_name',
            'email',
            'house',
            'street',
            'city',
            'country',
            'phone',
            'redeem_date',
            'price_option',
            'deal_option',
            'product',
            'sku'
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $gogroopies = $this->sort($gogroopies, $columns, $request->get('direction'));
        }

        $gogroopies = $gogroopies->orderBy('id', 'desc')->paginate(10);
        $params = $request->all();
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        return Inertia::render('Gogroopie/Index', [
            'gogroopies' => $gogroopies->withQueryString(),
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
        foreach (['deal_id',
                     'import_id',
                     'voucher_code',
                     'full_name',
                     'email',
                     'house',
                     'street',
                     'city',
                     'country',
                     'phone',
                     'redeem_date',
                     'price_option',
                     'deal_option',
                     'product',
                     'sku'] as $sort) {
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
