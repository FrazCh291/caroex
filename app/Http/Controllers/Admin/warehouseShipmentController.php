<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;
use App\Models\Shipment;
use App\Models\StockLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductStock;
use App\Models\ShipmentItem;
use App\Services\Traits\Sort;
use App\Models\WarehouseStock;
use App\Models\PurchaseOrder;
use App\Services\Traits\Logger;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Traits\DefaultActiveLog;

use function GuzzleHttp\Promise\all;

class warehouseShipmentController extends Controller
{
    use Sort;
    use Search;
    use Filter;
    use Logger;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAnyOne', Shipment::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Shipment',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $warehouseShipment = Shipment::query();
        $warehouseShipment->where('uk_eta', '!=', null)->get();

        $warehouseShipment = $this->search($warehouseShipment, [
            'container_number',
            'uk_eta',
            'actual_arrival_date',
            'departure_port',
            'shipping_line',
            'booking_number',
            'container_seal_number',
            'container_number',
            'bill_of_lading_number',
            'load_date',
            'vessel_etd',
        ]);


        if ($request->has('query')) {
            $warehouseShipment = $warehouseShipment->orWhereHas('shipmentItems.product', function (Builder $query) {
                $this->search($query, ['name', 'sku']);
            });
        }
        if ($request->has('query')) {
            $warehouseShipment = $warehouseShipment->orWhereHas('shipmentItems', function (Builder $query) {
                $this->search($query, ['quantity_delivered']);
            });
        }
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $warehouseShipment = $this->sort($warehouseShipment, $columns, $request->get('direction'));
        }

        if ($request->has('direction') && $request->get('warehouse_id')) {
            $sortedDta = $warehouseShipment->getCollection()->sortBy(function ($warehouseShipment) {
                return $warehouseShipment->warehouse->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $warehouseShipment->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('supplier_id')) {
            $sortedDta = $warehouseShipment->getCollection()->sortBy(function ($warehouseShipment) {
                return $warehouseShipment->supplier->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $warehouseShipment->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('purchase_order_id')) {
            $sortedDta = $warehouseShipment->getCollection()->sortBy(function ($warehouseShipment) {
                return $warehouseShipment->purchaseOrder->purchase_filling_ref;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $warehouseShipment->setCollection(collect($sort));
        }
        $warehouseShipment = $warehouseShipment->with(['supplier', 'supplierFreightForwarder', 'purchaserFreightForwarder', 'warehouse', 'shipmentItems.product'])->orderBy('id', 'desc')->paginate(10);
        $params = $request->all();
        return inertia::render('warehouseShipment/Index', [
            'warehouseShipment' => $warehouseShipment,
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
                     'container_number',
                     'uk_eta',
                     'actual_arrival_date',
                     'departure_port',
                     'shipping_line',
                     'booking_number',
                     'container_seal_number',
                     'container_number',
                     'bill_of_lading_number',
                     'load_date',
                     'vessel_etd',
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
        $this->authorize('createAny', Shipment::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Shipment',
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
        $this->validate($request, [
            'actual_arrival_date' => ['required'],
            'off_load_hours' => ['required'],
        ]);

        $warehouseShipment = Shipment::where('id', $request->shipment_id)->update([
            'actual_arrival_date' => $request->actual_arrival_date,
            'off_load_hours' => $request->off_load_hours,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $warehouseShipment->id . '}',
            'module' => $warehouseShipment,
            'activity' => 'Store',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('viewShow', Shipment::class);

        $warehouseShipment = Shipment::with('supplier', 'purchaserFreightForwarder', 'supplierFreightForwarder', 'warehouse')->findOrfail($id);
        $shipmentItemsData = ShipmentItem::with('product')->where('shipment_id', $id)->get();
        $purchaseOrders = PurchaseOrder::where('id', $warehouseShipment['purchase_order_id'])->get();
        $warehouseShipmentedit = Shipment::findOrfail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $warehouseShipment->id . '}',
            'module' => $warehouseShipment,
            'activity' => 'Show',
            'type' => 'fulfilment',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('warehouseShipment/Show', [
            'warehouseShipmentedit' => $warehouseShipmentedit,
            'purchaseOrders' => $purchaseOrders,
            'shipmentItemsData' => $shipmentItemsData,
            'warehouseShipment' => $warehouseShipment
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
        $this->authorize('updateAny', Shipment::class);
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
        $this->authorize('updateAny', Shipment::class);
        $this->validate($request, [
            'actual_arrival_date' => ['required'],
            'off_load_hours' => ['required'],
        ]);

        $shipmentOld = Shipment::where('id', $id)->first();
        $shipment = Shipment::where('id', $id)->update([
            'actual_arrival_date' => $request->actual_arrival_date,
            'off_load_hours' => $request->off_load_hours,
        ]);
        $shipment = Shipment::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $shipment->id . '}',
            'module' => $shipment,
            'activity' => 'Update',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $logData = $this->logable($module);
        $details = $shipmentOld;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->is_old = 1;
        $LogDetail->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $shipment;
        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        foreach ($request->quantityDelivered as $shipmentItem) {
            if ($shipmentItem['quantity']) {
                $shipment_Item = ShipmentItem::where([['shipment_id', $id], ['product_id', $shipmentItem['product_id']]])->first();
                if ($shipment_Item) {
                    $productStock = ProductStock::where([['date', date("Y-m-d", strtotime($request->actual_arrival_date))], ['product_id', $shipment_Item['product_id']], ['company_id', Auth::user()->company_id]])->first();
                    if ($productStock) {
                        $productStock->quantity = $productStock->quantity - $shipment_Item->quantity_delivered;
                        $productStock->quantity = $productStock->quantity + $shipmentItem['quantity'];
                        $productStock->date = date("Y-m-d", strtotime($request->actual_arrival_date));
                        $productStock->update();

                        $warehouseStock = WarehouseStock::where([['product_id', $shipment_Item['product_id']], ['warehouse_id', $shipment->warehouse_id], ['company_id', Auth::user()->company_id]])->first();
                        if ($warehouseStock) {
                            $warehouseStock->quantity = $warehouseStock->quantity - $shipment_Item->quantity_delivered;
                            $warehouseStock->quantity = $warehouseStock->quantity + $shipmentItem['quantity'];
                            $warehouseStock->update();
                        } else {
                            $warehouseStock = new WarehouseStock;
                            $warehouseStock->company_id = Auth::user() ? Auth::user()->company_id : '';
                            $warehouseStock->product_id = $shipmentItem['product_id'];
                            $warehouseStock->warehouse_id = $shipment->warehouse_id;
                            $warehouseStock->quantity = $shipmentItem['quantity'];
                            $warehouseStock->save();
                        }
                    } else {
                        $product_Stock = ProductStock::where([['product_id', $shipment_Item['product_id']], ['company_id', Auth::user() ? Auth::user()->company_id : '']])->latest('date')->first();
                        if ($product_Stock) {
                            $productStock = new ProductStock();
                            $productStock->company_id = Auth::user() ? Auth::user()->company_id : '';
                            $productStock->product_id = $shipmentItem['product_id'];
                            $productStock->quantity = $product_Stock->quantity + $shipmentItem['quantity'];
                            $productStock->date = date("Y-m-d", strtotime($request->actual_arrival_date));
                            $productStock->save();
                        } else {
                            $productStock = new ProductStock();
                            $productStock->company_id = Auth::user() ? Auth::user()->company_id : '';
                            $productStock->product_id = $shipmentItem['product_id'];
                            $productStock->quantity = $shipmentItem['quantity'];
                            $productStock->date = date("Y-m-d", strtotime($request->actual_arrival_date));
                            $productStock->save();
                        }
                        $warehouseStock = WarehouseStock::where([['product_id', $shipment_Item['product_id']], ['warehouse_id', $shipment->warehouse_id], ['company_id', Auth::user()->company_id]])->first();
                        if ($warehouseStock) {
                            $warehouseStock->quantity = $warehouseStock->quantity + $shipmentItem['quantity'];
                            $warehouseStock->update();
                        } else {
                            $warehouseStock = new WarehouseStock;
                            $warehouseStock->company_id = Auth::user() ? Auth::user()->company_id : '';
                            $warehouseStock->product_id = $shipmentItem['product_id'];
                            $warehouseStock->warehouse_id = $shipment->warehouse_id;
                            $warehouseStock->quantity = $shipmentItem['quantity'];
                            $warehouseStock->save();
                        }
                    }
                }
                $stockLog = StockLog::where([['company_id', Auth::user()->company_id], ['shipment_item_id', $shipment_Item['id']]])->first();
                if ($stockLog) {
                    $stockLog->quantity = $shipmentItem['quantity'];
                    $stockLog->update();
                } else {
                    $stockLog = new StockLog();
                    $stockLog->user_id = Auth::user() ? Auth::user()->id : '';
                    $stockLog->company_id = Auth::user() ? Auth::user()->company_id : '';
                    $stockLog->product_id = $shipmentItem['product_id'];
                    $stockLog->shipment_item_id = $shipment_Item->id;
                    $stockLog->warehouse_id = $shipment->warehouse_id;
                    $stockLog->supplier_id = $shipment->supplier_id;
                    $stockLog->quantity = $shipmentItem['quantity'];
                    $stockLog->save();
                }
            }


            $shipmentItemOld = ShipmentItem::where('shipment_id', $id)->first();

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');

            $module = [
                'message' => '{' . $shipmentItemOld->id . '}',
                'module' => $shipmentItemOld,
                'activity' => 'Update',
                'type' => 'erp',
                'path' => $slice,
            ];

            $logData = $this->logable($module);
            $details = $shipmentItemOld;
            $final_data = json_encode($details);
            $LogDetail = new ActivityLogsDetails();
            $LogDetail->activity_log_id = $logData->id;
            $LogDetail->company_id = Auth::user()->company_id;
            $LogDetail->details = $final_data;
            $LogDetail->is_old = 1;
            $LogDetail->save();

            ShipmentItem::where('shipment_id', $id)->where('product_id', $shipmentItem['product_id'])->update([
                'quantity_delivered' => $shipmentItem['quantity']
            ]);
            $shipmentItemNew = ShipmentItem::where('shipment_id', $id)->first();

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');

            $details = $shipmentItemNew;
            $final_data = json_encode($details);

            $LogDetail = new ActivityLogsDetails();
            $LogDetail->company_id = Auth::user()->company_id;
            $LogDetail->activity_log_id = $logData->id;
            $LogDetail->is_old = 0;
            $LogDetail->details = $final_data;
            $LogDetail->save();
        }
        return Redirect::route('warehouse-shipments.show', $id)->with('success', 'Shipment created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('deleteAny', Shipment::class);

        $warehouseShipment = Shipment::findOrfail($id);
        $warehouseShipment->delete();

        $module = [
            'message' => '{' . $warehouseShipment->id . '}',
            'module' => $warehouseShipment,
            'activity' => 'Delete',
            'type' => 'fulfilment',
            'path' => null,
        ];

        $this->logable($module);

        return redirect()->back();
    }
}
