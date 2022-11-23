<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Lookup;
use App\Models\Address;
use App\Models\Company;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\Documents;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use App\Models\ShipmentItem;
use Illuminate\Http\Request;
use App\Models\ProductStock;
use App\Services\Traits\Sort;
use App\Models\PurchaseOrder;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Database\Eloquent\Builder;

class ShipmentController extends Controller
{
    use Sort;
    use Search;
    use Filter;
    use Logger;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Shipment::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Shipment',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $shipments = Shipment::query();

        $shipments = $this->search($shipments, [
            'id',
            'supplier_id',
            'container_number',
            'uk_eta',
            'departure_port',
            'shipping_line',
            'booking_number',
            'updated_at',
            'bill_of_lading_number',
            'container_seal_number',
            'load_date',
            'vessel_etd',
        ]);

        $query = $request['query'];

        if ($request->has('query')) {
            $request['query'] = explode(" x", $request['query'])[0];
            $shipments = $shipments->orWhereHas('shipmentItems.product', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }
        if ($request->has('query')) {
            $shipments = $shipments->orWhereHas('purchaseorder', function (Builder $query) {
                $this->search($query, ['purchase_filling_ref']);
            });
        }

        $request['query'] = $query;

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $shipments = $this->sort($shipments, $columns, $request->get('direction'));
        }

        $shipments = $shipments->with(['supplier', 'supplierFreightForwarder', 'purchaserFreightForwarder', 'warehouse', 'shipmentItems.product', 'purchaseOrder'])
            ->where('company_id', Auth::user()->company_id)->paginate(200);

        if ($request->has('direction') && $request->get('name')) {
            $sortedDta = $shipments->getCollection()->sortBy(function ($shipment) {
                return $shipment->shipmentItems[0]->product->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $shipments->setCollection(collect($sort));
        }
        if ($request->has('direction') && $request->get('purchase_filling_ref')) {
            $sortedDta = $shipments->getCollection()->sortBy(function ($shipment) {
                return $shipment->purchaseorder->purchase_filling_ref;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $shipments->setCollection(collect($sort));
        }

        $params = $request->all();
        return inertia::render('Shipments/Index', [
            'shipments' => $shipments->withQueryString(),
            'params' => $params
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach ([
            'id',
            'container_number',
            'uk_eta',
            'actual_arrival_date',
            'updated_at'

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
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', Shipment::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Shipment',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $suppliers = Company::where('parent_id', Auth::user()->company_id)->where('type', 'supplier_company')->orderBy('name')->get();
        $freightReceivers = Company::where('parent_id', Auth::user()->company_id)->where('type', 'freight_receiver_company')->orderBy('name')->get();
        $freightSenders = Company::where('parent_id', Auth::user()->company_id)->where('type', 'freight_sender_company')->orderBy('name')->get();
        $warehouses = Company::where('parent_id', Auth::user()->company_id)->where('type', 'warehouse')->orderBy('name')->get();

        $shipment_statuses = Lookup::where('type', 'shipment_status')->orderBy('value')->get();
        $shipment_agent = Lookup::where('type', 'shipment_agent')->orderBy('value')->get();
        $purchaseOrders = PurchaseOrder::select('purchase_order_number', 'id')->orderBy('purchase_order_number')->get();
        $products = Product::all();

        return inertia::render('Shipments/Create', [
            'suppliers' => $suppliers,
            'freightReceivers' => $freightReceivers,
            'freightSenders' => $freightSenders,
            'warehouses' => $warehouses,
            'shipment_statuses' => $shipment_statuses,
            'purchaseOrders' => $purchaseOrders,
            'products' => $products,
            'shipment_agent' => $shipment_agent,
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'supplier_id' => ['required'],
            'purchaser_freight_forwarder_id' => ['required'],
            'supplier_freight_forwarder_id' => ['required'],
            'warehouse_id' => ['required'],
            'shipment_agent' => ['required'],
            'purchase_order_id' => ['required'],
            'departure_port' => ['required'],
            'shipping_line' => ['required'],
            'container_number' => ['required'],
            'booking_number' => ['required'],
            'bill_of_lading_number' => ['required'],
            'container_seal_number' => ['required'],
            'vessel_etd' => ['required'],
            //            'uk_eta' => ['required'],
            'expected_container_delivery_date' => ['required'],
            'load_date' => ['required'],
            'shipment_date' => ['required'],
            'actual_arrival_date' => ['required'],
        ]);
        $id = DB::table('shipments')->max('id') + 1;
        $shipment = new Shipment();
        $shipment->id = $id;
        $shipment->company_id = Auth::user() ? Auth::user()->company_id : '';
        $shipment->supplier_id = $validate['supplier_id'];
        $shipment->purchaser_freight_forwarder_id = $validate['purchaser_freight_forwarder_id'];
        $shipment->supplier_freight_forwarder_id = $validate['supplier_freight_forwarder_id'];
        $shipment->shipment_agent = $request['shipment_agent'];
        $shipment->warehouse_id = $validate['warehouse_id'];
        $shipment->purchase_order_id = $validate['purchase_order_id'];
        $shipment->departure_port = $validate['departure_port'];
        $shipment->shipping_line = $validate['shipping_line'];
        $shipment->container_number = $validate['container_number'];
        $shipment->booking_number = $validate['booking_number'];
        $shipment->bill_of_lading_number = $validate['bill_of_lading_number'];
        $shipment->container_seal_number = $validate['container_seal_number'];
        $shipment->vessel_etd = $validate['vessel_etd'];
        $shipment->uk_eta = $request->uk_eta;
        $shipment->expected_container_delivery_date = $validate['expected_container_delivery_date'];
        $shipment->load_date = $validate['load_date'];
        $shipment->shipment_date = $validate['shipment_date'];
        $shipment->actual_arrival_date = $validate['actual_arrival_date'];
        $shipment->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $shipment->id  . '}',
            'module' => $shipment,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice . '/' . $shipment->id,
        ];

        $this->logable($module);

        foreach ($request->shipmentItems as $item) {

            $id = DB::table('shipment_items')->max('id') + 1;
            $shipmentItem = new ShipmentItem();
            $shipmentItem->id = $id;
            $shipmentItem->company_id = Auth::user() ? Auth::user()->company_id : '';
            $shipmentItem->shipment_id = $shipment->id;
            $shipmentItem->product_id = $item['product_id'];
            $shipmentItem->unit_price = $item['unit_price'];
            $shipmentItem->quantity_ordered = $item['quantity_ordered'];
            $shipmentItem->total_price = $item['total_price'];
            $shipmentItem->save();

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');

            $module = [
                'message' => '{' . $shipmentItem->id  . '}',
                'module' => $shipmentItem,
                'activity' => 'Store',
                'type' => 'erp',
                'path' => $slice . '/' . $shipment->id,
            ];

            $this->logable($module);
        }

        foreach ($request->shipmentDocs as $shipmentDoc) {
            if ($shipmentDoc['files']) {
                $files = $shipmentDoc['files'];
                $fileName = $files[0]->getClientOriginalName();
                $mimeType = $files[0]->getClientOriginalExtension();
                $path = 'storage/' . $files[0]->storeAs('docoments', $fileName);
            }
            $shipmentDoc = $shipment->documents()->create([
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'title' => $shipmentDoc['title'],
                'file' => $path,
                'file_type' => $mimeType,
                'description' => $shipmentDoc['description'],
            ]);

            $currentURL = url()->current();
            $slice = Str::after($currentURL, '8000');

            $module = [
                'message' => '{' . $shipmentDoc->id  . '}',
                'module' => $shipmentDoc,
                'activity' => 'Store',
                'type' => 'erp',
                'path' => $slice . '/' . $shipment->id,
            ];

            $this->logable($module);
        }

        return Redirect::route('shipments.show', $shipment->id)->with('success', 'Shipment created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $this->authorize('view', Shipment::class);
        $products = Product::all();
        $warehouses = Company::where('type','warehouse')->get();
        $shipment = Shipment::with(
            'supplierFreightForwarder',
            'purchaserFreightForwarder',
            'supplier',
            'shipmentItems.product',
            'warehouse',
            'purchaseorder',
            'mainCompany'
        )->findOrFail($id);
       
        $suppliers = Company::where('parent_id', Auth::user()->company_id)->get();
        $address = Address::where('addressable_id', $shipment->company_id)->first();
        $freightForwarders = Company::where('parent_id', Auth::user()->company_id)->get();
        $shipmentitems = ShipmentItem::where('shipment_id', $id)->orderBy('id', 'desc')->paginate(10);
        $documents = Documents::where([['documentable_id', $id], ['documentable_type', 'App\Models\Shipment']])->get();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $shipment->id  . '}',
            'module' => $shipment,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Shipments/Show', [
            'address' => $address,
            'shipment' => $shipment,
            'products' => $products,
            'suppliers' => $suppliers,
            'documents' => $documents,
            'warehouses' => $warehouses,
            'shipmentitems' => $shipmentitems,
            'freightForwarders' => $freightForwarders,
        ]);
    }

    public function viewFile($id)
    {
        $shipmentsFileView = Shipment::where('id', $id)->firstOrFail();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $shipmentsFileView->id  . '}',
            'module' => $shipmentsFileView,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return response()->file(public_path($shipmentsFileView->file));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit($shipmentId)
    {
        $this->authorize('update', Shipment::class);

        $shipment = Shipment::with('documents', 'shipmentItems', 'warehouse')->findOrFail($shipmentId);
        $shipmentItem = ShipmentItem::where('shipment_id', $shipmentId)->with('product')->get();
        $documents = Documents::where([['documentable_type', '=', 'App\Models\Shipment'], ['documentable_id', '=', $shipmentId]])->get();
        $suppliers = Company::where('parent_id', Auth::user()->company_id)->where('type', 'supplier_company')->orderBy('name')->get();
        $warehouses = Company::where('id', $shipment->warehouse_id)->where('type', 'warehouse')->select(['name','id'])->get();
        $freightSenders = Company::where('parent_id', Auth::user()->company_id)->where('type', 'freight_sender_company')->orderBy('name')->get();
        $freightReceivers = Company::where('parent_id', Auth::user()->company_id)->where('type', 'freight_receiver_company')->orderBy('name')->get();
        $shipment_statuses = Lookup::where('type', 'shipment_status')->orderBy('value')->get();
        $purchaseOrders = PurchaseOrder::select('purchase_order_number', 'id')->orderBy('purchase_order_number')->get();
        $shipment_agent = Lookup::where('type', 'shipment_agent')->orderBy('value')->get();
        $products = Product::all();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $shipment->id  . '}',
            'module' => $shipment,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);
       
        return Inertia::render('Shipments/Create', [
            'shipment' => $shipment,
            'suppliers' => $suppliers,
            'warehouses' => $warehouses,
            'freightReceivers' => $freightReceivers,
            'freightSenders' => $freightSenders,
            'shipment_statuses' => $shipment_statuses,
            'purchaseOrders' => $purchaseOrders,
            'shipmentItem' => $shipmentItem,
            'documents' => $documents,
            'products' => $products,
            'shipment_agent' => $shipment_agent,
        ]);
    }
    /**
     * @param $id
     * @return \Inertia\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'supplier_id' => ['required'],
            'purchaser_freight_forwarder_id' => ['required'],
            'supplier_freight_forwarder_id' => ['required'],
            'warehouse_id' => ['required'],
            'purchase_order_id' => ['required'],
            'shipment_agent' => ['required'],
            'departure_port' => ['required'],
            'shipping_line' => ['required'],
            'container_number' => ['required'],
            'booking_number' => ['required'],
            'bill_of_lading_number' => ['required'],
            'container_seal_number' => ['required'],
            'vessel_etd' => ['required'],
            //            'uk_eta' => ['required'],
            'expected_container_delivery_date' => ['required'],
            'load_date' => ['required'],
            'shipment_date' => ['required'],
            'actual_arrival_date' => ['required'],
        ]);
        $shipmentOld = Shipment::where('id', $id)->first();
        $shipment = Shipment::findOrFail($id);
        $shipment->company_id = Auth::user() ? Auth::user()->company_id : '';
        $shipment->supplier_id = $request->supplier_id;
        $shipment->purchaser_freight_forwarder_id = $request->purchaser_freight_forwarder_id;
        $shipment->supplier_freight_forwarder_id = $request->supplier_freight_forwarder_id;
        $shipment->warehouse_id = $request->warehouse_id;
        $shipment->purchase_order_id = $request->purchase_order_id;
        $shipment->shipment_agent = $request->shipment_agent;
        $shipment->departure_port = $request->departure_port;
        $shipment->shipping_line = $request->shipping_line;
        $shipment->container_number = $request->container_number;
        $shipment->booking_number = $request->booking_number;
        $shipment->bill_of_lading_number = $request->bill_of_lading_number;
        $shipment->container_seal_number = $request->container_seal_number;
        $shipment->vessel_etd = $request->vessel_etd;
        $shipment->uk_eta = $request->uk_eta;
        $shipment->expected_container_delivery_date = $request->expected_container_delivery_date;
        $shipment->load_date = $request->load_date;
        $shipment->shipment_date = $request->shipment_date;
        $shipment->actual_arrival_date = $request->actual_arrival_date;

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $shipment->id  . '}',
            'module' => $shipment,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice . '/' . 'edit',
        ];
        $logData =  $this->logable($module);

        $details = $shipmentOld;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->is_old = 1;
        $LogDetail->save();

        $shipment->update();
        $shipmentNew = Shipment::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

       $details = $shipmentNew;
       $final_data = json_encode($details);

       $LogDetail = new ActivityLogsDetails();
       $LogDetail->company_id = Auth::user()->company_id;
       $LogDetail->activity_log_id = $logData->id;
       $LogDetail->is_old = 0;
       $LogDetail->details = $final_data;
       $LogDetail->save();

        if ($request->shipmentDocs) {
            foreach ($request->shipmentDocs as $shipmentDoc) {
                if (array_key_exists('id', $shipmentDoc) && array_key_exists('documentable_id', $shipmentDoc)) {
                    if ($shipmentDoc['file'][0] == 's') {
                        if ($shipmentDoc['file']) {
                            $path = $shipmentDoc['file'];
                        }
                    } else {
                        if ($shipmentDoc['files']) {
                            $path = 'storage/' . $shipmentDoc['files'][0]->store('docoments');
                            $files = $shipmentDoc['files'];
                            $mimeType = $files[0]->getClientOriginalExtension();
                        }
                    }
                    $shipmentDoc = Documents::updateOrCreate(
                        [
                            'id' => $shipmentDoc['id'],
                            'documentable_id' => $shipmentDoc['documentable_id'],
                            'documentable_type' => 'App\Models\Shipment'
                        ],
                        [
                            'company_id' => Auth::user() ? Auth::user()->company_id : '',
                            'title' => $shipmentDoc['title'],
                            'file' => $path,
                            'description' => $shipmentDoc['description'],
                        ]
                    );
                } else {
                    if ($shipmentDoc['files']) {
                        $path = 'storage/' . $shipmentDoc['files'][0]->store('docoments');
                        $files = $shipmentDoc['files'];
                        $mimeType = $files[0]->getClientOriginalExtension();
                    }
                    $shipment->documents()->create([
                        'company_id' => Auth::user() ? Auth::user()->company_id : '',
                        'title' => $shipmentDoc['title'],
                        'file' => $path,
                        'file_type' => $mimeType,
                        'description' => $shipmentDoc['description'],
                    ]);
                    $shipmentDoc = Documents::orderBy('id', 'desc')->first();
                }
                $shipmentDocOld = Documents::where('id', $id)->first();

                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');

                $module = [
                    'message' => '{' . $shipmentDoc->id  . '}',
                    'module' => $shipmentDoc,
                    'activity' => 'Update',
                    'type' => 'erp',
                    'path' => $slice,
                ];
                $logData =  $this->logable($module);

                $details = $shipmentDocOld;

                $final_data = json_encode($details);
                $LogDetail = new ActivityLogsDetails();
                $LogDetail->activity_log_id = $logData->id;
                $LogDetail->company_id = Auth::user()->company_id;
                $LogDetail->details = $final_data;
                $LogDetail->is_old = 1;
                $LogDetail->save();

                $shipmentDocNew = Documents::where('id', $id)->first();

                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');

               $details = $shipmentDocNew;
               $final_data = json_encode($details);

               $LogDetail = new ActivityLogsDetails();
               $LogDetail->company_id = Auth::user()->company_id;
               $LogDetail->activity_log_id = $logData->id;
               $LogDetail->is_old = 0;
               $LogDetail->details = $final_data;
               $LogDetail->save();
            }
        }

        if ($request->shipmentItems) {
            foreach ($request->shipmentItems as $item) {
                if (array_key_exists('id', $item) && array_key_exists('shipment_id', $item)) {
                    $shipmentItem = ShipmentItem::updateOrCreate(
                        [
                            'id' => $item['id'],
                            'shipment_id' => $item['shipment_id'],
                        ],
                        [
                            'company_id' => Auth::user()->company_id,
                            'shipment_id' => $id,
                            'product_id' => $item['product_id'],
                            'unit_price' => $item['unit_price'],
                            'quantity_ordered' => $item['quantity_ordered'],
                            'total_price' => $item['total_price'],
                        ]
                    );
                } else {
                    $id2 = DB::table('shipment_items')->max('id') + 1;
                    $shipmentItem = ShipmentItem::updateOrCreate([
                        'id' => $id2?$id2:1,
                        'company_id' => Auth::user()->company_id,
                        'shipment_id' => $id,
                        'product_id' => $item['product_id'],
                        'unit_price' => $item['unit_price'],
                        'quantity_ordered' => $item['quantity_ordered'],
                        'total_price' => $item['total_price'],
                    ]);
                }
                $shipmentItemOld = ShipmentItem::where('id', $item['id'])->first();
                $currentURL = url()->current();
                $slice = Str::after($currentURL, '8000');

                $module = [
                    'message' => '{' . $shipmentItem->id  . '}',
                    'module' => $shipmentItem,
                    'activity' => 'Update',
                    'type' => 'erp',
                    'path' => $slice . '/' . 'edit',
                ];

                $logData =  $this->logable($module);
                $details = $shipmentItemOld;
                $final_data = json_encode($details);
                $LogDetail = new ActivityLogsDetails();
                $LogDetail->activity_log_id = $logData->id;
                $LogDetail->company_id = Auth::user()->company_id;
                $LogDetail->details = $final_data;
                $LogDetail->is_old = 1;
                $LogDetail->save();

                $shipmentItemNew = ShipmentItem::where('id', $item['id'])->first();

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
            };

        }

        return Redirect::route('shipments.index')->with('success', 'Shipment created successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function shipmentExportFile($id)
    {
        $dealsFileExport = Documents::where('id', $id)->firstOrFail();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $dealsFileExport->id  .'}',
            'module' => $dealsFileExport,
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return response()->download(public_path($dealsFileExport->file));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Shipment::class);

        $shipments = Shipment::findOrFail($id);
        $shipmentitems = ShipmentItem::where('shipment_id', $shipments->id);
        $shipmentitems->delete();
        $shipments->delete();

        $module = [
            'message' => '{' . $shipments->id  . '}',
            'module' => $shipments,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('shipments.index')->with('success', 'Receted successfully');
    }

    public function itemDelete($id)
    {
        $shipmentItem = ShipmentItem::findOrFail($id);
        $shipmentItem->delete();

        $module = [
            'message' => '{' . $shipmentItem->id  . '}',
            'module' => $shipmentItem,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::back()->with('success', 'ShipmentDoc deleted successfully');
    }

    public function docDelete($id)
    {
        $document = Documents::findOrFail($id);
        $document->delete();


        $module = [
            'message' => '{' . $document->id  . '}',
            'module' => $document,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::back()->with('success', 'Shipment Item deleted successfully');
    }
}
