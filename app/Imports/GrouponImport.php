<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Deal;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Import;
use App\Models\Product;
use App\Models\Groupon;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Feedback;
use App\Models\StockLog;
use App\Models\Warehouse;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Models\DeliveryItem;
use App\Models\ProductTitle;
use App\Models\ProductStock;
use App\Models\SalesChannel;
use App\Models\DealsProducts;
use App\Models\WarehouseStock;
use App\Services\Traits\Logger;
use App\Models\DealsProductsRates;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\DefaultActiveLog;
use App\Services\Feedback\FeedbackService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class GrouponImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected $fileName;
    use Logger;
    use DefaultActiveLog;
    /**
     * @param $file
     */
    public function __construct($file)
    {
        $this->fileName = $file;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $channel_id = request()->get('channel_id');
        $saleChannel = SalesChannel::where('id', $channel_id)->first();
        $import = Import::updateOrCreate(['file_name' => $this->fileName], [
            'channel_id' => $saleChannel->id,
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
            'file_name' => $this->fileName,
            'user_id' => Auth::user()->id,
        ]);
        $this->logable($import, $saleChannel);

        foreach ($rows as $row) {
//            $singleQuantity = $row['quantity'];
            $date1 = strtr($row['order_date'], '/', '-');
            $date = date('Y-m-d', strtotime($date1));
            $product = ProductTitle::where('product_title', trim($row['item_name']))->first();
//dd($product);
//            if (!$product) {
//                $product = ProductTitle::where('product_title', 'Swift Foldable Pedal Bike 26' . '' . '- Black')->first();
//            }

            $str = substr($this->fileName, 19);
            if (!$product) {
                $error = ValidationException::withMessages([
                    'name' => ['Error importing file! Product title: "' . trim($row['item_name']) . '" does not exist in the system. Please add this title to the product before importing the file. ']
               ]);
                throw $error;
            }

            $ship_add_1 = $row['shipment_address_street'] == null ? null : Str::of($row['shipment_address_street'])->trim();
            $ship_add_2 = $row['shipment_address_street_2'] == null ? null : Str::of($row['shipment_address_street_2'])->trim();
            $shipAddress = $ship_add_1 . ", " . $ship_add_2;
            $bill_add_1 = $row['billing_address_name'] == null ? null : Str::of($row['billing_address_name'])->trim();
            $bill_add_2 = $row['billing_address_street'] == null ? null : Str::of($row['billing_address_street'])->trim();
            $billAddress = $bill_add_1 . ", " . $bill_add_2;
            Groupon::updateOrCreate(
                ['groupon_number' => $row['groupon_number']],
                [
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'groupon_number' => $row['groupon_number'] == null ? null : Str::of($row['groupon_number'])->trim(),
                    'import_id' => $import ? $import->id : null,
                    'product_id' => $product ? $product->product_id : null,
                    'fulfillment_line_item_id' => $row['fulfillment_line_item_id'] == null ? null : Str::of($row['fulfillment_line_item_id'])->trim(),
                    'merchant_sku_item' => $row['merchant_sku_item'] == null ? null : Str::of($row['merchant_sku_item'])->trim(),
                    'quantity_requested' => $row['quantity_requested'] == null ? null : Str::of($row['quantity_requested'])->trim(),
                    'shipment_method_requested' => $row['shipment_method_requested'] == null ? null : Str::of($row['shipment_method_requested'])->trim(),
                    'shipment_address_name' => $row['shipment_address_name'] == null ? null : Str::of($row['shipment_address_name'])->trim(),
                    'shipment_address_street' => $row['shipment_address_street'] == null ? null : Str::of($row['shipment_address_street'])->trim(),
                    'shipment_address_street_2' => $row['shipment_address_street_2'] == null ? null : Str::of($row['shipment_address_street_2'])->trim(),
                    'shipment_address_city' => $row['shipment_address_city'] == null ? null : Str::of($row['shipment_address_city'])->trim(),
                    'shipment_address_stat' => $row['shipment_address_stat'] == null ? null : Str::of($row['shipment_address_stat'])->trim(),
                    'order_date' => trim($row['order_date']) == 'NULL' || trim($row['order_date']) == '' ? null : date('Y-m-d', strtotime(Str::before($date, ' '))),
                    'shipment_address_postal_code' => $row['shipment_address_postal_code'] == null ? null : Str::of($row['shipment_address_postal_code'])->trim(),
                    'shipment_address_country' => $row['shipment_address_country'] == null ? null : Str::of($row['shipment_address_country'])->trim(),
                    'gift' => $row['gift'] == null ? null : Str::of($row['gift'])->trim(),
                    'gift_message' => $row['gift_message'] == null ? null : Str::of($row['gift_message'])->trim(),
                    'quantity_shipped' => $row['quantity_shipped'] == null ? null : Str::of($row['quantity_shipped'])->trim(),
                    'shipment_carrier' => $row['shipment_carrier'] == null ? null : Str::of($row['shipment_carrier'])->trim(),
                    'shipment_method' => $row['shipment_method'] == null ? null : Str::of($row['shipment_method'])->trim(),
                    'shipment_tracking_number' => $row['shipment_tracking_number'] == null ? null : Str::of($row['shipment_tracking_number'])->trim(),
                    'groupon_sku' => $row['groupon_sku'] == null ? null : Str::of($row['groupon_sku'])->trim(),
                    'custom_field_value' => $row['custom_field_value'] == null ? null : Str::of($row['custom_field_value'])->trim(),
                    'permalink' => $row['permalink'] == null ? null : Str::of($row['permalink'])->trim(),
                    'item_name' => $row['item_name'] == null ? null : Str::of($row['item_name'])->trim(),
                    'vendor_id' => $row['vendor_id'] == null ? null : Str::of($row['vendor_id'])->trim(),
                    'salesforce_deal_option_id' => $row['salesforce_deal_option_id'] == null ? null : Str::of($row['salesforce_deal_option_id'])->trim(),
                    'groupon_cost' => $row['groupon_cost'] == null ? null : Str::of($row['groupon_cost'])->trim(),
                    'billing_address_name' => $row['billing_address_name'] == null ? null : Str::of($row['billing_address_name'])->trim(),
                    'billing_address_street' => $row['billing_address_street'] == null ? null : Str::of($row['billing_address_street'])->trim(),
                    'billing_address_city' => $row['billing_address_city'] == null ? null : Str::of($row['billing_address_city'])->trim(),
                    'billing_address_stat' => $row['billing_address_stat'] == null ? null : Str::of($row['billing_address_stat'])->trim(),
                    'billing_address_postal_code' => $row['billing_address_postal_code'] == null ? null : Str::of($row['billing_address_postal_code'])->trim(),
                    'billing_address_country' => $row['billing_address_country'] == null ? null : Str::of($row['billing_address_country'])->trim(),
                    'purchase_order_number' => $row['purchase_order_number'] == null ? null : Str::of($row['purchase_order_number'])->trim(),
                    'product_weight' => $row['product_weight'] == null ? null : Str::of($row['product_weight'])->trim(),
                    'product_weight_unit' => $row['product_weight_unit'] == null ? null : Str::of($row['product_weight_unit'])->trim(),
                    'product_length' => $row['product_length'] == null ? null : Str::of($row['product_length'])->trim(),
                    'product_width' => $row['product_width'] == null ? null : Str::of($row['product_width'])->trim(),
                    'product_height' => $row['product_height'] == null ? null : Str::of($row['product_height'])->trim(),
                    'product_dimension_unit' => $row['product_dimension_unit'] == null ? null : Str::of($row['product_dimension_unit'])->trim(),
                    'customer_phone' => $row['customer_phone'] == null ? null : Str::of($row['customer_phone'])->trim(),
                    'incoterms' => $row['incoterms'] == null ? null : Str::of($row['incoterms'])->trim(),
                    'hts_code' => $row['hts_code'] == null ? null : Str::of($row['hts_code'])->trim(),
                    'pl_name' => $row['3pl_name'] == null ? null : Str::of($row['3pl_name'])->trim(),
                    'pl_warehouse_location' => $row['3pl_warehouse_location'] == null ? null : Str::of($row['3pl_warehouse_location'])->trim(),
                    'kitting_details' => $row['kitting_details'] == null ? null : Str::of($row['kitting_details'])->trim(),
                    'sell_price' => $row['sell_price'] == null ? null : Str::of($row['sell_price'])->trim(),
                    'deal_opportunity_id' => $row['deal_opportunity_id'] == null ? null : Str::of($row['deal_opportunity_id'])->trim(),
                    'shipment_strategy' => $row['shipment_strategy'] == null ? null : Str::of($row['shipment_strategy'])->trim(),
                    'fulfillment_method' => $row['fulfillment_method'] == null ? null : Str::of($row['fulfillment_method'])->trim(),
                    'country_of_origin' => $row['country_of_origin'] == null ? null : Str::of($row['country_of_origin'])->trim(),
                    'merchant_permalink' => $row['merchant_permalink'] == null ? null : Str::of($row['merchant_permalink'])->trim(),
                    'bom_sku' => $row['deal_opportunity_id'] == null ? null : Str::of($row['bom_sku'])->trim(),
                ]);

            $customer = Customer::updateOrCreate(
                ['phone' => $row['customer_phone']],
                ['name' => $row['shipment_address_name'] == null ? null : Str::of($row['shipment_address_name'])->trim(),
                'import_id' => $import->id,
                    'channel_id' => $import->channel_id,
                    'company_id' => Auth::user()->company_id,
                    'phone' => $row['customer_phone'] == null ? null : Str::of($row['customer_phone'])->trim(),
                    'address1_2' => $shipAddress ? $shipAddress : '',
                    'city' => $row['shipment_address_city'] == null ? null : Str::of($row['shipment_address_city'])->trim(),
                    'postcode' => $row['shipment_address_postal_code'] == null ? null : Str::of($row['shipment_address_postal_code'])->trim(),
                    'country' => $row['shipment_address_country'] == null ? null : Str::of($row['shipment_address_country'])->trim(),
                ]);

            $order = Order::updateOrCreate(
                ['order_number' => $row['groupon_number']
                ],
                ['order_number' => $row['groupon_number'] == null ? null : Str::of($row['groupon_number'])->trim(),
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'customer_id' => $customer ? $customer->id : '',
                    'import_id' => $import ? $import->id : null,
                    'product_id' => $product ? $product->product_id : null,
                    'channel_id' => $import->channel_id,
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
//                    'order_date' => $date ? $date : '',
                    'order_date' => trim($row['order_date']) == 'NULL' || trim($row['order_date']) == '' ? null : $date,
                    'deal_id' => $row['fulfillment_line_item_id'] == null ? null : Str::of($row['fulfillment_line_item_id'])->trim(),
                    'merchant_sku_item' => $row['merchant_sku_item'] == null ? null : Str::of($row['merchant_sku_item'])->trim(),
                    'quantity_requested' => $row['quantity_requested'] == null ? null : Str::of($row['quantity_requested'])->trim(),
                    'dispatch_method' => $row['shipment_method_requested'] == null ? null : Str::of($row['shipment_method_requested'])->trim(),
                    'shipping_customer_name' => $row['shipment_address_name'] == null ? null : Str::of($row['shipment_address_name'])->trim(),
                    'shipping_address_1' => $row['shipment_address_street'] == null ? null : Str::of($row['shipment_address_street'])->trim(),
                    'shipping_address_2' => $row['shipment_address_street_2'] == null ? null : Str::of($row['shipment_address_street_2'])->trim(),
                    'shipping_address_town' => $row['shipment_address_city'] == null ? null : Str::of($row['shipment_address_city'])->trim(),
                    'shipping_address_postcode' => $row['shipment_address_postal_code'] == null ? null : Str::of($row['shipment_address_postal_code'])->trim(),
                    'shipping_country' => $row['shipment_address_country'] == null ? null : Str::of($row['shipment_address_country'])->trim(),
                    'shipping_address_phone	' => $row['customer_phone'] == null ? null : Str::of($row['customer_phone'])->trim(),
                    'gift_message' => $row['gift_message'] == null ? null : Str::of($row['gift_message'])->trim(),
                    'quantity' => $row['quantity_shipped'] == null ? 1 : Str::of($row['quantity_shipped'])->trim(),
                    'shipment_carrier' => $row['shipment_carrier'] == null ? null : Str::of($row['shipment_carrier'])->trim(),
                    'shipment_tracking_number' => $row['shipment_tracking_number'] == null ? null : Str::of($row['shipment_tracking_number'])->trim(),
                    'groupon_sku' => $row['groupon_sku'] == null ? null : Str::of($row['groupon_sku'])->trim(),
                    'permalink' => $row['permalink'] == null ? null : Str::of($row['permalink'])->trim(),
                    'product_name' => $row['item_name'] == null ? null : Str::of($row['item_name'])->trim(),
                    'vendor_id' => $row['vendor_id'] == null ? null : Str::of($row['vendor_id'])->trim(),
                    'saleforce_deal_option_id' => $row['salesforce_deal_option_id'] == null ? null : Str::of($row['salesforce_deal_option_id'])->trim(),
                    'billing_customer_name' => $row['billing_address_name'] == null ? null : Str::of($row['billing_address_name'])->trim(),
                    'billing_address_1' => $row['billing_address_street'] == null ? null : Str::of($row['billing_address_street'])->trim(),
                    'billing_city' => $row['billing_address_city'] == null ? null : Str::of($row['billing_address_city'])->trim(),
                    'billing_postcode' => $row['billing_address_postal_code'] == null ? null : Str::of($row['billing_address_postal_code'])->trim(),
                    'billing_country' => $row['billing_address_country'] == null ? null : Str::of($row['billing_address_country'])->trim(),
                    'purchase_order_number' => $row['purchase_order_number'] == null ? null : Str::of($row['purchase_order_number'])->trim(),
                    'product_weight' => $row['product_weight'] == null ? null : Str::of($row['product_weight'])->trim(),
                    'product_weight_unit' => $row['product_weight_unit'] == null ? null : Str::of($row['product_weight_unit'])->trim(),
                    'product_length' => $row['product_length'] == null ? null : Str::of($row['product_length'])->trim(),
                    'product_width' => $row['product_width'] == null ? null : Str::of($row['product_width'])->trim(),
                    'product_height' => $row['product_height'] == null ? null : Str::of($row['product_height'])->trim(),
                    'product_dimension_unit' => $row['product_dimension_unit'] == null ? null : Str::of($row['product_dimension_unit'])->trim(),
                    'incoterms' => $row['incoterms'] == null ? null : Str::of($row['incoterms'])->trim(),
                    'hts_code' => $row['hts_code'] == null ? null : Str::of($row['hts_code'])->trim(),
                    'pl_name' => $row['3pl_name'] == null ? null : Str::of($row['3pl_name'])->trim(),
                    'pl_warehouse_location' => $row['3pl_warehouse_location'] == null ? null : Str::of($row['3pl_warehouse_location'])->trim(),
                    'kitting_details' => $row['kitting_details'] == null ? null : Str::of($row['kitting_details'])->trim(),
                    'item_price' => $row['sell_price'] == null ? null : Str::of($row['sell_price'])->trim(),
                    'deal_opportunity_id' => $row['deal_opportunity_id'] == null ? null : Str::of($row['deal_opportunity_id'])->trim(),
                    'shipment_strategy' => $row['shipment_strategy'] == null ? null : Str::of($row['shipment_strategy'])->trim(),
                    'fulfillment_method' => $row['fulfillment_method'] == null ? null : Str::of($row['fulfillment_method'])->trim(),
                    'country_of_origin' => $row['country_of_origin'] == null ? null : Str::of($row['country_of_origin'])->trim(),
                    'merchant_permalink' => $row['merchant_permalink'] == null ? null : Str::of($row['merchant_permalink'])->trim(),
                    'bom_sku' => $row['deal_opportunity_id'] == null ? null : Str::of($row['bom_sku'])->trim(),
                    'order_status' => 'processing'
                ]);
            $dealProduct = DealsProducts::where([['product_id', $product->product_id], ['deal_number', $row['fulfillment_line_item_id']]])->first();
            $rateToBeApplied=null;
            if($dealProduct){
                $dealRates = DealsProductsRates::where('deal_product_id', $dealProduct->id)->orderBy('start_date')->get();
                $checkdate = Carbon::parse($date);
                $count = $dealRates->count();
                if($count > 1){
                    for($i=0;$i<(count($dealRates)-1);$i++){
                        $dateFind = $checkdate->between($dealRates[$i]->start_date, $dealRates[$i+1]->start_date);
                        if($dateFind){
                            if($checkdate->lessThan(Carbon::parse($dealRates[$i+1]->start_date))){
                                $rateToBeApplied=$dealRates[$i];
                                break;
                            }
                            if($checkdate->equalTo(Carbon::parse($dealRates[$i+1]->start_date))){
                                $rateToBeApplied=$dealRates[$i+1];
                                break;
                            }
                        }elseif((count($dealRates)-1)==$i+1){
                            $rateToBeApplied=$dealRates[$i+1];
                        }
                    }
                }
                else{
                    $rateToBeApplied = $dealRates[0];
                }
            }
            $orderItem = OrderItem::updateOrCreate(
                ['order_id' => $order->id,
                    'product_name' => $row['item_name']],
                ['order_id' => $order->id,
                    'product_id' => $product ? $product->product_id : null,
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'return_status' => (isset($row['return_status']) ? $row['return_status'] : ''),
                    'deal_product_rate_id' => $rateToBeApplied?$rateToBeApplied->id: null,
                    'product_name' => $row['item_name'] == null ? null : Str::of($row['item_name'])->trim(),
                    'item_cost' => $row['sell_price'] == null ? null : Str::of($row['sell_price'])->trim(),
                    'quantity' => ($row['quantity_requested'] == null ? null : (Str::of($row['quantity_requested'])->trim() ? Str::of($row['quantity_requested'])->trim() : 1)),
                    'order_date' => trim($row['order_date']) == 'NULL' || trim($row['order_date']) == '' ? null : $date,
                ]);

            $warehouse = Company::where('name', 'Bacup')->orderby('id', 'desc')->first();
            $stockLogs = StockLog::create([
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'order_item_id' => $orderItem->id,
                'warehouse_id' => $warehouse ? $warehouse->id : 1,
                'supplier_id' => 1,
                'product_id' => $product ? $product->product_id : null,
                'user_id' => Auth::user() ? Auth::user()->id : '',
                'quantity' => '-' . $orderItem->quantity,
            ]);
            $orderQty = 1;
            $productStocks = ProductStock::where('product_id', $stockLogs->product_id)
                ->where('company_id', Auth::user() ? Auth::user()->company_id : '')->first();
            $product = Product::where('id', $product->product_id)->first();
            if ($productStocks) {
                if (isset($product->shipping_method)) {
                    if ($product->shipping_method === 'Tuffnells') {
                        if (isset($orderItem->product_id) && $orderItem->product_id != 'null') {
                            $evetDate = Carbon::now();
                            if ($productStocks->quantity < $orderQty) {

                                $delivery = Delivery::updateOrCreate(
                                    ['company_id' => Auth::user() ? Auth::user()->company_id : '',
                                        'status' => 'pending',
                                    ]);
                                DeliveryItem::updateOrCreate(
                                    ['order_item_id' => $orderItem->id],
                                    ['order_item_id' => $orderItem->id,
                                        'company_id' => Auth::user() ? Auth::user()->company_id : '',
                                        'order_id' => $order->id,
                                        'delivery_id' => $delivery->id,
                                        'delivery_method' => 'Tuffnells',
                                        'delivery_date' => $evetDate,
                                        'status' => 'pending',
                                        'note' => 'This product is out of stock. The order quantity were:' . $orderQty . ''
                                    ]);

                            } else {
                                $delivery = Delivery::updateOrCreate(
                                    ['company_id' => Auth::user() ? Auth::user()->company_id : '',
                                        'status' => 'pending',
                                    ]);
                                DeliveryItem::updateOrCreate(
                                    ['order_item_id' => $orderItem->id],
                                    [
                                        'company_id' => Auth::user() ? Auth::user()->company_id : '',
                                        'order_item_id' => $orderItem->id,
                                        'order_id' => $order->id,
                                        'delivery_id' => $delivery->id,
                                        'delivery_method' => 'Tuffnells',
                                        'delivery_date' => $evetDate,
                                        'status' => 'processing'
                                    ]);
                                $productStocks->quantity = $productStocks->quantity + $stockLogs->quantity;
                                $productStocks->save();

                                if($warehouse) {
                                    $warehouseStock = WarehouseStock::where('product_id', $stockLogs->product_id)->where('warehouse_id', $warehouse->id)
                                        ->where('company_id', Auth::user() ? Auth::user()->company_id : '')->first();
                                    if ($warehouseStock) {
                                        $warehouseStock->quantity = $warehouseStock->quantity - $orderQty;
                                        $warehouseStock->save();
                                    }
                                }
                            }

                        }
                    }
//                    if ($product->shipping_method === 'Parcelforce') {
//                        if (isset($orderItem->product_id) && $orderItem->product_id != 'null') {
//
//                            if ($orderItem->product->quantity <= 0) {
//                                DeliveryItem::updateOrCreate(
//                                    ['order_item_id' => $orderItem->id],
//                                    [
//                                        'company_id' => Auth::user() ? Auth::user()->company_id : '',
//                                        'order_item_id' => $orderItem->id,
//                                        'order_id' => $order->id,
//                                        'delivery_method' => 'Parcelforce',
//                                        'status' => 'pending',
//                                        'quantity' => $product->quantity,
//                                        'note' => 'The product is out of stock'
//                                    ]);
//
//                            } else {
//                                $del = DeliveryItem::updateOrCreate(
//                                    ['order_item_id' => $orderItem->id],
//                                    [
//                                        'company_id' => Auth::user() ? Auth::user()->company_id : '',
//                                        'order_item_id' => $orderItem->id,
//                                        'order_id' => $order->id,
//                                        'delivery_method' => 'Tuffnells',
//                                        'status' => 'processing'
//                                    ]);
//                                if ($del->wasRecentlyCreated) {
//                                    $product->decrement('quantity', $orderQty);
//                                }
//
//                            }
//
//                        }
//                    }
                }
            } else {
                if (!$productStocks) {
                    $error = \Illuminate\Validation\ValidationException::withMessages([
                        'name' => ['Please add' . ' "' . $row['item_name'] . '" ' . ' into Stock Log table because this product is not existing in our system . The file name is ' . $str . ' and order number is ' . $row['groupon_number']]
                    ]);
                    throw $error;
                }
            }

//            $feedback = Feedback::where('order_id', $order->id)->first();
//
//            if (!is_array($feedback)) {
//                $feedback = new FeedbackService();
//                $feedback->storeFeedback($customer, $order);
//            }
        }

        Import::where('id', $import->id)->update(['number_of_rows' => count($rows)]);
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 15000;
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
}
