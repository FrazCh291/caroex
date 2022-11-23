<?php

namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Excel;
use DateTime;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\Warehouse;
use App\Models\OrderItem;
use App\Models\Documents;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DeliveryItem;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use App\Services\Traits\Search;
use App\Models\CaseSparePartItems;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Storage;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

// use Maatwebsite\Excel\Facades\Excel;

class DeliveryController extends Controller
{

    private $name = 'irfan';
    use Sort;
    use Search;
    use Filter;
    use Logger;
    use DefaultActiveLog;

    /**
     * @return \Inertia\Response
     */


    public function index(Request $request)
    {
        $this->authorize('viewAny', DeliveryItem::class);

//        dd($request->all());
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Delivery',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);
        $deliveries = [];
        $tuffnellCount = DeliveryItem::whereIn('status', ['Processing', 'processing', 'replacement', 'redispatch', 'collection'])->count();
        $tuffnellPendingCount = DeliveryItem::where('status', 'pending')->count();
        $tuffnelDeliveryItems = null;
        $deliveries['tuffnell_pending_orders'] = null;
        $deliveries['tuffnell_cancelled_orders'] = null;
        $deliveries['parcelforce_pending_orders'] = null;
        $deliveries['sent'] = null;
        $deliveries['ready'] = null;
        $pickingLists = null;
        $inspections = null;


        if ($request->get('type') == 'pickinglist') {
            $pickingLists = Delivery::paginate(10);
            $openTab = 6;
        } else if ($request->get('type') == 'inspection') {
            $inspections = Delivery::with('deliveryItems')->paginate(10);
            $openTab = 5;
        } else if ($request->get('type') == 'pending_delivery') {
            $deliveries['tuffnell_pending_orders'] = DeliveryItem::with('order')->where('delivery_method', 'Tuffnells')->where('status', 'pending')->orderby('id', 'desc')->paginate(10);
            $openTab = 2;
        } else if ($request->get('type') == 'cancelled_delivery') {
            $deliveries['tuffnell_cancelled_orders'] = DeliveryItem::with('order')->where('delivery_method', 'Tuffnells')->where('status', 'cancelled')->orderby('id', 'desc')->paginate(10);
            $openTab = 4;
//            $deliveries['parcelforce_pending_orders'] = DeliveryItem::with('order')->where('delivery_method', 'Parcelforce')->where('status', 'processing')->orderBy('id', 'desc')->take(100)->paginate(10);
//            $deliveries['sent'] = Delivery::where('status', 'sent')->orderby('id', 'desc')->paginate(10);
        } else if ($request->get('type') == 'ready_delivery') {
            $deliveries['ready'] = Delivery::where('status', 'ready')->orderby('id', 'desc')->paginate(10);
            $openTab = 1;
        } else {
            if ($tuffnellCount == 0) {
                $deliveries['ready'] = Delivery::where('status', 'ready')->orderby('id', 'desc')->paginate(10);
                $openTab = 1;
            } else {
                $tuffnelDeliveryItems = DeliveryItem::with('order', 'collection', 'orderItem')
                    ->where('delivery_method', 'Tuffnells')
                    ->where('company_id', Auth::user()->company_id)
                    ->whereIn('status', ['Processing', 'processing', 'replacement', 'redispatch', 'collection'])->orderBy('id', 'desc')->paginate(10);
                $openTab = 3;
            }
        }
        return Inertia::render('Delivery/Index', [
            'tuffnelDeliveryItems' => $tuffnelDeliveryItems,
//            'parcelforceDeliveryItems' => $parcelforceDeliveryItems,
            'tuffnellPendingCount' => $tuffnellPendingCount,
            'deliveries' => $deliveries,
            'tabopen' => $openTab,
            'tuffnellCount' => $tuffnellCount,
//            'sparePartCount' => $sparePartCount,
            'pickingLists' => $pickingLists,
            'inspections' => $inspections
        ]);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tuffnellTxt()
    {
        $this->authorize('create', DeliveryItem::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Deliveries',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        ini_set('max_execution_time', 2000);

        $date = Carbon::now();
        $createDate = new DateTime($date);
        $strip = $createDate->format('Y-m-d');
        $replaceColon = str_replace(":", "-", $date->toDateTimeString());
        $replaceSpace = str_replace("-", "", $replaceColon);
        $replaceslashes = str_replace("-", "/", $strip);

        $date = Str::of($replaceSpace)->substr(0, 8);
        $txt = "";

        $items = DeliveryItem::has('order.product')
            ->with('order.orderItems', 'orderItem')
            ->where('delivery_method', 'Tuffnells')
            ->whereIn('status', ['processing', 'replacement', 'redispatch', 'collection'])->get()->toArray();

        $account = Setting::where('slug', 'account_number')->first();

        $accountNumber = $account->value;

        $accountBranch = Setting::where('slug', 'account_branch_code')->first();

        $accountBranchNumber = $accountBranch->value;

        $service = Setting::where('slug', 'p1')->first();

        $serviceType = $service->value;

        $sur = Setting::where('slug', 'surcharge')->first();

        $surcharge = $sur->value;
        $sum = 0;

        foreach ($items as $data) {

            $sum += $data['order_item']['product']['weight_unit'];
//            $product = Product::Where('id', $data['order_item']['product_id'])->first();
//            $orderQty = Order::Where('product_id', $data['order_item']['product']['id'])->first();
//            $deliveryItem = DeliveryItem::Where('id', $data['order']['id'])->first();


            $length1 = Str::length($data['order']['shipping_address_1']);
            $length2 = Str::length($data['order']['shipping_address_2']);

            if ($length1 >= 27 || $length2 >= 27) {
                $description = $data['order']['shipping_address_1'] . " " . $data['order']['shipping_address_2'] . " " . $data['order']['shipping_address_town'] . " " . $data['order']['shipping_address_county'] . " " . $data['order']['shipping_address_postcode'];
            } else {
                $description = '';
            }
//             Blank space for deliveries and ‘C’ for collection returns
            if ($data['status'] == 'collection') {
                $txt .= str_pad('C', '1');
            } elseif ($data['order_item']['return_status'] == 'collection') {
                $txt .= str_pad('C', '1');
            } else {
                $txt .= str_pad(' ', '1');
            }

            // 2 9 Account No. with TPE (eg. 00123456) - GET FROM SETTINGS - DEFAULT IS 01491555 MANDATORY
            $txt .= str_pad($accountNumber, 8)

                //10 20 Your consignment No. (Max 9 chars) (left adjusted) * MANDATORY
                . str_pad($data['order']['id'] ? $data['order']['id'] : '', 8, "0", STR_PAD_LEFT)
                . str_pad('', 3)

                // 21 50  Delivery address - company name (left adjusted) MANDATORY
                . str_pad($data['order']['shipping_customer_name'] ? Str::upper($data['order']['shipping_customer_name']) : '', 30)

                // 51 80 Delivery address - line 1 (left adjusted) MANDATORY

                . str_pad($data['order']['shipping_address_1'] ? str_replace('’', '', Str::upper(Str::limit($data['order']['shipping_address_1'], 27))) : '', 30)

                //81 110   Delivery address - line 2 (left adjusted)
                . str_pad($data['order']['shipping_address_2'] ? str_replace('’', '', Str::upper(Str::limit($data['order']['shipping_address_2'], 27))) : '', 30)

                // 111 140  Delivery address - town (left adjusted) MANDATORY
                . str_pad($data['order']['shipping_address_town'] ? Str::upper($data['order']['shipping_address_town']) : 'NA', 30)

                // 141 170  Delivery address - county (left adjusted) MANDATORY
                . str_pad($data['order']['shipping_address_county'] ? Str::upper($data['order']['shipping_address_county']) : 'NA', 30)

                //171 172  Service Type - GET FROM SETTINGS - DEFAULT IS P1 MANDATORY
                // . str_pad($serviceType ? Str::upper($serviceType) : '', 2)

                . str_pad(str::startsWith(str::upper($data['order']['shipping_address_postcode']), ['BT', 'IM', 'ZE', 'PO', 'BN', 'DD', 'KW', 'LS', 'RM', 'ZE']) ? 'OF' : (str_pad($serviceType ? Str::upper($serviceType) : '', 2)), 2)

                . str_pad($surcharge ? Str::upper($surcharge) : '', 2)

                //175 181  Weight to nearest kilo (right adjusted with leading zeros) MANDATORY
                . str_pad($data['order_item']['product']['weight_unit'] ? Str::upper($data['order_item']['product']['weight_unit']) : '', 7, "0", STR_PAD_LEFT)

                //182 184   Type of Packages (field 1) (left adjusted)  MANDATORY
                . str_pad('CAR', 3)

                //185 187   Type of Packages (field 2) (left adjusted)
                . str_pad('', 3)

                //188 192   No of packages (field 1) (right adjusted with leading zeros) MANDATORY
                . str_pad(1, 5, "0", STR_PAD_LEFT)

                // 193 197 No of packages (field 2) (right adjusted with leading zeros)
                . str_pad('', 5)

                //198 205   Delivery address - post code ** MANDATORY
                . str_pad($data['order']['shipping_address_postcode'] ? Str::upper($data['order']['shipping_address_postcode']) : '', 8)

                // 206 235  Delivery address - contact name (left adjusted) ***0
                . str_pad($data['order']['shipping_customer_name'] ? Str::upper($data['order']['shipping_customer_name']) : '', 30)

                //236 249   Delivery address - phone number (left adjusted) ***
                . str_pad($data['order']['shipping_address_phone'] ? str_replace([' ', '+'], '', Str::upper(Str::limit('0' . $data['order']['shipping_address_phone'], 14))) : '', 14)

                // 250 255  Date of despatch YYMMDD (if blank defaults to current)
//                . str_pad($data['order']['order_date'] ? Str::upper($data['order']['order_date']) : '', 6)
//                . str_pad($data['order']['order_date'] ? Str::upper($data['order']['order_date']) : '', 6)
                . str_pad('', 6)
                //256 261   RESERVED FOR TPE USE
                . str_pad('', 6)

                //262 264   Account 'branch' number (e.g. "001")
                . str_pad($accountBranchNumber ? Str::upper($accountBranchNumber) : '', 3)

                // 262 264  Special instructions text (left adjusted)
                . str_pad($description ? Str::upper($description) : '', 200)

                // 465 465 Flag A
                . str_pad('', 1)

                //465 465  Flag B
                . str_pad('', 1)

                // 467 467 Flag C
                . str_pad('', 1)

                // 467 467 Flag D
                . str_pad('', 1);
//

//             469 488  Our Reference (left adjusted)
            if ($data['status'] == 'replacement') {
                $txt .= str_pad($data['order']['channel']['name'] ? 'REP-' . Str::upper($data['order']['channel']['name']) : '', 20);
            } elseif ($data['order_item']['return_status'] == 'replacement') {
                $txt .= str_pad($data['order']['channel']['name'] ? 'REP-' . Str::upper($data['order']['channel']['name']) : '', 20);
            } elseif ($data['status'] == 'redispatch') {
                $txt .= str_pad($data['order']['channel']['name'] ? 'RED-' . Str::upper($data['order']['channel']['name']) : '', 20);
            } elseif ($data['order_item']['return_status'] == 'redispatch') {
                $txt .= str_pad($data['order']['channel']['name'] ? 'RED-' . Str::upper($data['order']['channel']['name']) : '', 20);
            } else {
                $txt .= str_pad($data['order']['channel']['name'] ? Str::upper($data['order']['channel']['name']) : '', 20);
            };
            //489 508   Your Reference (left adjusted) PRODUCT SHORT NAME
            $txt .= str_pad($data['order_item']['product']['name'] ? Str::upper($data['order_item']['product']['name'] . " ID-" . $data['order_item_id']) : '', 20)

                // 509 538  Trader Code (left adjusted) - WOWCHER OR GOGROPIE CODE
                . str_pad($data['order']['order_number'] ? Str::upper($data['order']['order_number']) : '', 30)

                // 539 568 Goods Value (left adjusted) - PRICE WITH POUND SIGN - E.G. $200
                . str_pad($data['order']['order_total_amount'] ? Str::upper($data['order']['order_total_amount']) : '', 30)

                // 569 768  Goods Description (left adjusted) - PRODUCT TITLE
                // . str_pad($data['order']['product']['name'] ? Str::upper($data['order']['product']['name']) : '', 200)

                //  569 768 <Line Feed – ASCII Char.10>
                // 770 770  <Carriage Return – ASCII Char.13>
                . "\n";
            if ($data['order']['order_status'] == 'processing' || 'Processing') {
                Order::where('id', $data['order_id'])->update(['order_status' => 'shipped']);
            }
            preg_match_all("/P1(\s){2}0+/", $txt, $nextday);
//                preg_match_all("/OF(\s){2}0+/",$txt , $ofshore);
            // dd($ofshore);
            // dd($nextday[0][0]);
            if (str::startsWith(str::upper($data['order']['shipping_address_postcode']), ['BT', 'IM', 'ZE', 'PO', 'BN', 'DD', 'KW', 'LS', 'RM', 'ZE'])) {
                $deliveryItem = DeliveryItem::where('order_item_id', $data['order_item']['id'])->first();
                $deliveryItem->delivery_type = 'OF';
                $deliveryItem->update();
                // [
                //     'company_id' => Auth::user() ? Auth::user()->company_id : '',
                //     'status'=> 'processing' || 'replacement'  || 'redispatch' || 'collection' || 'shipped',
                // ],[
                //         'company_id' => Auth::user() ? Auth::user()->company_id : '',
                //         'delivery_type' => $nextday[0][0],
                //     ]
                // );
            } else {
                $deliveryItem = DeliveryItem::where('order_item_id', $data['order_item']['id'])->first();
                $deliveryItem->delivery_type = 'P1';
                $deliveryItem->update();
                // DeliveryItem::updateOrCreate(
                //     [
                //         'company_id' => Auth::user() ? Auth::user()->company_id : '',
                //         'status'=> 'processing' || 'replacement'  || 'redispatch' || 'collection' || 'shipped',
                //     ],[
                //         'company_id' => Auth::user() ? Auth::user()->company_id : '',
                //         'delivery_type' => $nextday[0][0],
                //     ]
                // );
            }
        }
        $txtname = 'ISTARS_DELIVERIES_' . $date . '.TXT';

        $headers = ['Content-type' => 'text/plain', 'test' => 'YoYo', 'Content-Disposition' => sprintf('attachment; filename="%s"', $txtname), 'X-BooYAH' => 'WorkyWorky'];

        Storage::disk('local')->put('tuffnell/ISTARS_DELIVERIES_' . $date . '.TXT', $txt, 200, $headers);

        Delivery::updateOrCreate(
            [
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'status' => 'pending',
            ],
            [
                'filename' => 'storage/tuffnell/' . 'ISTARS_DELIVERIES_' . $date . '.TXT',
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'status' => 'ready',
                'weight' => $sum,
                'No_items' => count($items),
                'date' => $replaceslashes
            ]
        );

        $settings = Setting::where('type', 'email')->get();
        $deliveryItem = DeliveryItem::where('status', 'processing')->orWhere('status', 'replacement')->orWhere('status', 'redispatch')->orWhere('status', 'collection')->update(['status' => 'shipped']);

//        $currentURL = url()->current();
        //      $slice = Str::after($currentURL, '8000');

        //    $module = [
//            'message' => '{' . $deliveryItem->id  .'}',
        //      'module' => $deliveryItem,
        //    'activity' => 'Update',
        //  'type' => 'erp',
        // 'path' => $slice,
        //       ];

        //      $this->logable($module);

        return redirect()->route('deliveries.index');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export($id)
    {
        $this->authorize('view', DeliveryItem::class);

        $attachment = Delivery::where('id', $id)->firstOrFail();
        $file_path = public_path($attachment->filename);
        return response()->download($file_path);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $attachment->id . '}',
            'module' => $attachment,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice . '/' . $attachment->id,
        ];
        $this->logable($module);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $deliveryItem = DeliveryItem::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $id . '}',
            'module' => $deliveryItem,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];
        $logData = $this->logable($module);
        $details = $deliveryItem;

        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        $deliveryItemNew = $deliveryItem->update(['status' => $request->status]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $deliveryItemNew;
        $final_data = json_encode($details);

        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();

        return redirect()->route('deliveries.index');
    }

    public function show(Request $request, $id)
    {
        $documents = Documents::with('user')->where('documentable_id', $id)->get();
        $deliveries = Delivery::with(['deliveryItems.orderItem', 'deliveryItems' => function ($query) {
            $query->where('status', '!=', 'pending')->where('status', '!=', 'cancelled');
        }])->where('id', $id)->orderBy('id', 'asc')->paginate(10);
        $tuffnelId = $id;
        $params = $request->all();

        return Inertia::render('Delivery/IndexTuffnells', [
            'deliveries' => $deliveries,
            'documents' => $documents,
            'tuffnelId' => $tuffnelId,
            'params' => $params,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $deliveries->id . '}',
            'module' => $deliveries,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);


    }

    public function createManifests($id)
    {
        $deliveryID = $id;
        return Inertia::render('Delivery/Create', [
            'deliveryID' => $deliveryID
        ]);
    }

    public function importManifests(Request $request)
    {
        $this->validate($request, [
            'file' => ['required'],
        ]);

        $filenameWithExt = $request->file('file')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('file')->getClientOriginalExtension();
        $fileNameToStore = $filename . '.' . $extension;
        $path = $request->file('file')->storeAs('file', $fileNameToStore);

        $delivery = Delivery::find($request->deliveryID);
        $delivery->documents()->updateOrCreate([
            'documentable_id' => $request->deliveryID,
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'user_id' => Auth::user() ? Auth::user()->id : '',
            'file' => $path,
            'file_type' => $extension,
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $delivery . '}',
            'module' => $delivery,
            'activity' => 'create',
            'type' => 'fulfilment',
            'path' => $slice . '/' . $delivery,
        ];


        $this->logable($module);

        return redirect()->route('delivery.show', $request->deliveryID);
    }

    public function exportManifests($id)
    {
        $attachment = Documents::where('id', $id)->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $attachment->id . '}',
            'module' => $attachment,
            'activity' => 'store',
            'type' => 'erp',
            'path' => $slice . '/' . $attachment->id,
        ];

        $this->logable($module);

        return Storage::download($attachment->file);
    }

    public function pickingListIndex($id)
    {
        $pickingLists = Delivery::where('id', $id)->with(['deliveryItems' => function ($query) {
            $query->where('status', '!=', 'pending')->where('status', '!=', 'cancelled');
        }])->first();
        $orderItems = DB::table('order_items')
            ->join('products', 'order_items.product_id', 'products.id')
            ->select('products.name', 'products.sku', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->whereIn('order_items.id', $pickingLists->deliveryItems->pluck('order_item_id')->toArray())
            ->groupBy('products.name', 'products.sku')
            ->get();

        $pickingLists->products = $orderItems;
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\pickingList',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        return Inertia::render('Delivery/PickingListShow', [
            'pickingLists' => $pickingLists
        ]);
    }

    public function deliveryInspection($id)
    {
        $delivery = Delivery::where('id', $id)->first();
        $deliveryInspection = DeliveryItem::with('order.customer')->where('delivery_id', $id)->where('status', '!=', 'pending')->where('status', '!=', 'cancelled')->with('order')->get();

        // $currentURL = url()->current();
        // $slice = Str::after($currentURL, '8000');

        // $module = [
        //     'message' => '{' . $id  .'}',
        //     'module' => $deliveryInspection,
        //     'activity' => 'Edit',
        //     'type' => 'erp',
        //     'path' => $slice,
        // ];

        // $this->logable($module);
        return Inertia::render('Delivery/DeliveryInspection', [
            'delivery' => $delivery,
            'deliveryInspection' => $deliveryInspection,
        ]);
    }

    public function deliveryInspected(Request $request)
    {
         DeliveryItem::whereIn('id', $request->get('delivery_item_ids'))->update(['is_collected' => 1]);

        //    $currentURL = url()->current();
        //    $slice = Str::after($currentURL, '8000');

        //    $module = [
        //        'message' => '{' . $deliveyitems->id  .'}',
        //        'module' => $deliveyitems,
        //        'activity' => 'Update',
        //        'type' => 'erp',
        //        'path' => $slice,
        //    ];
        //    $logData =  $this->logable($module);
        //    $details = $deliveyitems;

        //    $final_data = json_encode($details);

        //     $LogDetail = new ActivityLogsDetails();
        //     $LogDetail->activity_log_id = $logData->id;
        //     $LogDetail->company_id = Auth::user()->company_id;
        //     $LogDetail->details = $final_data;
        //     $LogDetail->save();



        //    $currentURL = url()->current();
        //    $slice = Str::after($currentURL, '8000');

        //   $details =  $deliveyitems;
        //   $final_data = json_encode($details);

        //   $LogDetail = new ActivityLogsDetails();
        //   $LogDetail->company_id = Auth::user()->company_id;
        //   $LogDetail->activity_log_id = $logData->id;
        //   $LogDetail->is_old = 0;
        //   $LogDetail->details = $final_data;
        //   $LogDetail->save();

        return redirect()->route('deliveries.index');
    }
}
