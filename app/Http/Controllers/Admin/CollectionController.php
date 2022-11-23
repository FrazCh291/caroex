<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Cases;
use App\Models\Lookup;
use App\Models\Returns;
use App\Models\ReturnItem;
use App\Models\DeliveryItem;
use App\Models\ReturnsMedia;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class CollectionController extends Controller
{
    use Sort;
    use Search;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Returns::class);

        $collections = Returns::query();
        $collections = $this->search($collections, [
            'request_type',
            'return_status'
        ]);
        $params = $request->all();

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $collections = $this->sort($collections, $columns, $request->get('direction'));
        }

        if ($request->has('query')) {
            $collections = $collections->orWhereHas('customer', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        $collections = $collections->with(['customer', 'case.order', 'lookup'])->orderBy('id', 'desc')->paginate(10);
        return Inertia::render('Collections/Index', [
            'collections' => $collections->withQueryString(),
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
        foreach (['name',
                     'request_type',
                     'return_status',] as $sort) {
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
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $this->authorize('view', Returns::class);

        $collection = Returns::with('customer', 'case.lookup', 'case.order', 'case.order.orderItems', 'media')->findOrFail($id);
        $return_status = Lookup::where('type', 'return_status')->get();
        $returnItem = ReturnItem::with('product')->where('company_id', Auth::user()->company_id)->get();

        return Inertia::render('Collections/Show', [
            'collection' => $collection,
            'returnItem' => $returnItem,
            'return_status' => $return_status,
        ]);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $collection = Returns::findOrFail($id);
        $collection->refunded_at = $request->refunded_at;
        $collection->tracking_number = $request->tracking_number;
        $collection->return_status = $request->return_status;
        $collection->return_at = $request->return_at;
        $collection->received_at = $request->received_at;
        $collection->update();

        if ($request->return_status === 'Authorizes Return') {
            foreach ($request->case['order']['order_items'] as $items) {
                $deliveryItem = DeliveryItem:: firstOrCreate(
                    [
                        'company_id' => Auth::user()->company_id,
                        'order_id' => $request->case['order']['id'],
                        'order_item_id' => $items['id'],
                        'delivery_method' => 'Tuffnells'
                    ],
                    [
                        'company_id' => Auth::user()->company_id,
                        'order_id' => $request->case['order']['id'],
                        'order_item_id' => $items['id'],
                        'delivery_method' => 'Tuffnells',
                        'status' => 'collection',
                    ],
                );
                $deliveryItem->save();
            }
        }

        $returnMedia = ReturnsMedia::findOrFail($request->get("media")[0]["id"]);
        $returnMedia->company_id = Auth::user()->company_id;
        $returnMedia->return_id = $id;
        if ($request->hasFile('parcel_side_1')) {
            $path = 'storage/' . $request->file('parcel_side_1')->store('returnsmedia');
            $returnMedia->parcel_side_1 = $path;
        }
        if ($request->hasFile('parcel_side_2')) {
            $path = 'storage/' . $request->file('parcel_side_2')->store('returnsmedia');
            $returnMedia->parcel_side_2 = $path;
        }
        if ($request->hasFile('exchange_form')) {
            $path = 'storage/' . $request->file('exchange_form')->store('returnsmedia');
            $returnMedia->exchange_form = $path;
        }
        if ($request->hasFile('p1_image')) {
            $path = 'storage/' . $request->file('p1_image')->store('returnsmedia');
            $returnMedia->p1_image = $path;
        }
        if ($request->hasFile('p2_image')) {
            $path = 'storage/' . $request->file('p2_image')->store('returnsmedia');
            $returnMedia->p2_image = $path;
        }
        if ($request->hasFile('p3_image')) {
            $path = 'storage/' . $request->file('p3_image')->store('returnsmedia');
            $returnMedia->p3_image = $path;
        }
        if ($request->hasFile('p4_image')) {
            $path = 'storage/' . $request->file('p4_image')->store('returnsmedia');
            $returnMedia->p4_image = $path;
        }
        if ($request->hasFile('p5_image')) {
            $path = 'storage/' . $request->file('p5_image')->store('returnsmedia');
            $returnMedia->p5_image = $path;
        }
        $returnMedia->update();

        return Redirect::route('collections.index')->with('success', 'Collection Updates successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', Returns::class);

        $collection = Returns::findOrFail($id);
        $cases = Cases::findOrFail($collection->case_id);
        $cases->delete();
        $collection->delete();

        return Redirect::route('collections.index')->with('success', 'Collection deleted successfully');
    }
}
