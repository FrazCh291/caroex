<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\CompanyPayment;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\DeliveryItem;
use App\Models\Import;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductTitle;
use App\Models\SalesChannel;
use App\Models\StockLog;
use App\Models\StockOver;
use App\Models\WarehouseStock;
use App\Services\Traits\DefaultActiveLog;
use App\Services\Traits\Logger;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockOverImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected $fileName;
    use Logger;
    use DefaultActiveLog;

    public function __construct($file)
    {
        $this->fileName = $file;

    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $channel_id = request()->get('channel_id');
        $saleChannel = SalesChannel::where('id', $channel_id)->first();
        $import = Import::updateOrCreate(['file_name' => $this->fileName], [
            'channel_id' => $saleChannel->id,
            'file_name' => $this->fileName,
            'user_id' => Auth::user()->id,
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
        ]);


        foreach ($rows as $row) {
            $orderDate = strtr($row['date_added'], '/', '-');
            $orderDate_substr = substr($orderDate, 0, -6);

            if (DateTime::createFromFormat('Y-m-d', $orderDate_substr) !== FALSE) {
                $orderDate_substr_corbon = Carbon::createFromFormat('Y-m-d', $orderDate_substr);
                $formated_date = $orderDate_substr_corbon->toDateString();
            }  else {
                $formated_date =  date('Y-m-d', strtotime($orderDate_substr));
            };

            $customer_first_name = $row['payment_first_name'] == null ? null : Str::of($row['payment_first_name'])->trim();
            $customer_last_name = $row['payment_last_name'] == null ? null : Str::of($row['payment_last_name'])->trim();
            $cudtomer_name = $customer_first_name . " " . $customer_last_name;
            $customer_shipping_first_name = $row['shipping_first_name'] == null ? null : Str::of($row['shipping_first_name'])->trim();
            $customer_shipping_last_name = $row['shipping_last_name'] == null ? null : Str::of($row['shipping_last_name'])->trim();
            $shipping_customer_name = $customer_shipping_first_name . " " . $customer_shipping_last_name;
            $productTitle = ProductTitle::where('product_title', utf8_encode($row['item_name']))->first();

            $str = substr($this->fileName, 19);
            if (!$productTitle) {
                $error = ValidationException::withMessages([
                    'name' => ['Please add' . ' "' . $row['item_name'] . '" ' . ' into Product title table because this product name is not matching any lable. The file name is ' . $str . ' and order number is ' . $row['order_id']]
                ]);
                throw $error;
            }

            $boomtekk = StockOver::updateOrCreate(
                ['order_id' => $row['order_id']],
                [
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'import_id' => $import ? $import->id : null,
                    'order_id' => $row['order_id'] == null ? null : Str::of($row['order_id'])->trim(),
                    'invoice_number' => $row['invoice_number'] == null ? null : Str::of($row['invoice_number'])->trim(),
                    'invoice_prefix' => $row['invoice_prefix'] == null ? null : Str::of($row['invoice_prefix'])->trim(),
                    'store_id' =>  $row['store_id'] == null ? null : Str::of($row['store_id'])->trim(),
                    'store_name' => $row['store_name'] == null ? null : Str::of($row['store_name'])->trim(),
                    'store_url' => $row['store_url'] == null ? null : Str::of($row['store_url'])->trim(),
                    'customer_id' => $row['customer_id'] == null ? null : Str::of($row['customer_id'])->trim(),
                    'customer_group' => $row['customer_group'] == null ? null : Str::of($row['customer_group'])->trim(),
                    'first_name' => $row['first_name'] == null ? null : Str::of($row['first_name'])->trim(),
                    'last_name' => $row['last_name'] == null ? null : Str::of($row['last_name'])->trim(),
                    'email' => $row['email'] == null ? null : Str::of($row['email'])->trim(),
                    'telephone' => $row['telephone'] == null ? null : Str::of($row['telephone'])->trim(),
                    'fax' => $row['fax'] == null ? null : Str::of($row['fax'])->trim(),
                    'payment_first_name' => $row['payment_first_name'] == null ? null : Str::of($row['payment_first_name'])->trim(),
                    'payment_last_name' => $row['payment_last_name'] == null ? null : Str::of($row['payment_last_name'])->trim(),
                    'payment_company' => $row['payment_company'] == null ? null : Str::of($row['payment_company'])->trim(),
                    'payment_address_1' => $row['payment_address_1'] == null ? null : Str::of($row['payment_address_1'])->trim(),
                    'payment_address_2' => $row['payment_address_2'] == null ? null : Str::of($row['payment_address_2'])->trim(),
                    'payment_city' => $row['payment_city'] == null ? null : Str::of($row['payment_city'])->trim(),
                    'payment_postcode' => $row['payment_postcode'] == null ? null : Str::of($row['payment_postcode'])->trim(),
                    'payment_country' => $row['payment_country'] == null ? null : Str::of($row['payment_country'])->trim(),
                    'payment_country_id' => $row['payment_country_id'] == null ? null : Str::of($row['payment_country_id'])->trim(),
                    'payment_zone' => $row['payment_zone'] == null ? null : Str::of($row['payment_zone'])->trim(),
                    'payment_zone_id' => $row['payment_zone_id'] == null ? null : Str::of($row['payment_zone_id'])->trim(),
                    'payment_address_format' => $row['payment_address_format'] == null ? null : Str::of($row['payment_address_format'])->trim(),
                    'payment_method' => $row['payment_method'] == null ? null : Str::of($row['payment_method'])->trim(),
                    'payment_code' => $row['payment_code'] == null ? null : Str::of($row['payment_code'])->trim(),
                    'shipping_first_name' => $row['shipping_first_name'] == null ? null : Str::of($row['shipping_first_name'])->trim(),
                    'shipping_last_name' => $row['shipping_last_name'] == null ? null : Str::of($row['shipping_last_name'])->trim(),
                    'shipping_company' => $row['shipping_company'] == null ? null : Str::of($row['shipping_company'])->trim(),
                    'shipping_address_1' => $row['shipping_address_1'] == null ? null : Str::of($row['shipping_address_1'])->trim(),
                    'shipping_address_2' => $row['shipping_address_2'] == null ? null : Str::of($row['shipping_address_2'])->trim(),
                    'shipping_city' => $row['shipping_city'] == null ? null : Str::of($row['shipping_city'])->trim(),
                    'shipping_postcode' => $row['shipping_postcode'] == null ? null : Str::of($row['shipping_postcode'])->trim(),
                    'shipping_country' => $row['shipping_country'] == null ? null : Str::of($row['shipping_country'])->trim(),
                    'shipping_country_id' => $row['shipping_country_id'] == null ? null : Str::of($row['shipping_country_id'])->trim(),
                    'iso_code' => $row['iso_code'] == null ? null : Str::of($row['iso_code'])->trim(),
                    'shipping_zone' => $row['shipping_zone'] == null ? null : Str::of($row['shipping_zone'])->trim(),
                    'shipping_zone_id' => $row['shipping_zone_id'] == null ? null : Str::of($row['shipping_zone_id'])->trim(),
                    'shipping_address_format' => $row['shipping_address_format'] == null ? null : Str::of($row['shipping_address_format'])->trim(),
                    'shipping_method' => $row['shipping_method'] == null ? null : Str::of($row['shipping_method'])->trim(),
                    'shipping_code' => $row['shipping_code'] == null ? null : Str::of($row['shipping_code'])->trim(),
                    'comment' => $row['comment'] == null ? null : Str::of($row['comment'])->trim(),
                    'total' => $row['total'] == null ? null : Str::of($row['total'])->trim(),
                    'order_status_id' => $row['order_status_id'] == null ? null : Str::of($row['order_status_id'])->trim(),
                    'affiliate_id' => $row['affiliate_id'] == null ? null : Str::of($row['affiliate_id'])->trim(),
                    'commission' => $row['commission'] == null ? null : Str::of($row['commission'])->trim(),
                    'language_id' => $row['language_id'] == null ? null : Str::of($row['language_id'])->trim(),
                    'currency_id' => $row['currency_id'] == null ? null : Str::of($row['currency_id'])->trim(),
                    'currency_code' => $row['currency_code'] == null ? null : Str::of($row['currency_code'])->trim(),
                    'currency_value' => $row['currency_value'] == null ? null : Str::of($row['currency_value'])->trim(),
                    'ip' => $row['ip'] == null ? null : Str::of($row['ip'])->trim(),
                    'forwarded_ip' => $row['forwarded_ip'] == null ? null : Str::of($row['forwarded_ip'])->trim(),
                    'user_agent' => $row['user_agent'] == null ? null : Str::of($row['user_agent'])->trim(),
                    'accept_language' => $row['accept_language'] == null ? null : Str::of($row['accept_language'])->trim(),
                    'date_added' => $row['date_added'] == null ? null : ($row['date_added']),
                    'date_modified' => $row['date_modified'] == null ? null : ($row['date_modified']),
                ]);
            $customer = Customer::updateOrCreate(
                ['email' => $row['email']],
                ['name' => $cudtomer_name ? $cudtomer_name : '',
                    'import_id' => $import->id,
                    'channel_id' => $import->channel_id,
                    'company_id' => Auth::user()->company_id,
                    'phone' =>  $row['telephone'] == null ? null : Str::of($row['telephone'])->trim(),
                    'address1_2' => ($row['payment_address_1'] == null ? null : Str::of($row['payment_address_1'])->trim()) . ($row['payment_address_2'] == null ? null : Str::of($row['payment_address_2'])->trim()),
                    'city' => $row['payment_city'] == null ? null : Str::of($row['payment_city'])->trim(),
                    'postcode' => $row['payment_postcode'] == null ? null : Str::of($row['payment_postcode'])->trim(),
                    'country' => $row['payment_country'] == null ? null : Str::of($row['payment_country'])->trim(),
                    'email' => $row['email'] == null ? null : Str::of($row['email'])->trim(),
                ]);
            $order = Order::updateOrCreate(
                ['order_number' => $row['order_id']],
                [
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'order_number' => $row['order_id'] == null ? null : Str::of($row['order_id'])->trim(),
                    'import_id' => $import->id,
                    'customer_id' => $customer ? $customer->id : '',
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'channel_id' => $import->channel_id,
                    'order_date' => $row['date_added'] == null ? null : ($row['date_added']),
                    'order_status' => 'processing',
                    'customer_note' => $row['comment'] == null ? null : Str::of($row['comment'])->trim(),
                    'billing_customer_name' => $cudtomer_name ? $cudtomer_name : '',
                    'shipping_customer_name' => $shipping_customer_name ? $shipping_customer_name : '',
                    'billing_company' => $row['payment_company'] == null ? null : Str::of($row['payment_company'])->trim(),
                    'billing_address_1_2' => ($row['payment_address_1'] == null ? null : Str::of($row['payment_address_1'])->trim()) . ($row['payment_address_2'] == null ? null : Str::of($row['payment_address_2'])->trim()),
                    'billing_city' => $row['payment_city'] == null ? null : Str::of($row['payment_city'])->trim(),
                    'billing_postcode' => $row['payment_postcode'] == null ? null : Str::of($row['payment_postcode'])->trim(),
                    'billing_country' => $row['payment_country'] == null ? null : Str::of($row['payment_country'])->trim(),
                    'shipping_email' => $row['email'] == null ? null : Str::of($row['email'])->trim(),
                    'billing_phone' => $row['telephone'] == null ? null : Str::of($row['telephone'])->trim(),
                    'shipping_address_phone' => $row['telephone'] == null ? null : Str::of($row['telephone'])->trim(),
                    'shipping_address_1' => ($row['shipping_address_1'] == null ? null : Str::of($row['shipping_address_1'])->trim()) . ($row['shipping_address_2'] == null ? null : Str::of($row['shipping_address_2'])->trim()),
                    'shipping_address_city' =>$row['shipping_city'] == null ? null : Str::of($row['shipping_city'])->trim(),
                    'shipping_address_postcode'=> $row['shipping_postcode'] == null ? null : Str::of($row['shipping_postcode'])->trim(),
                    'shipping_state_code' => $row['shipping_zone'] == null ? null : Str::of($row['shipping_zone'])->trim(),
                    'shipping_address_county' => $row['shipping_zone'] == null ? null : Str::of($row['shipping_zone'])->trim(),
                    'payment_method_type' => $row['payment_code'] == null ? null : Str::of($row['payment_code'])->trim(),
                    'order_subtotal_amount' => $row['total'] == null ? null : Str::of($row['total'])->trim(),
                    'order_total_amount' => $row['total'] == null ? null : Str::of($row['total'])->trim(),
                    'order_total_tax_amount' => $row['total'] == null ? null : Str::of($row['total'])->trim(),
                    'product_name' => $row['item_name'] == null ? null : Str::of($row['item_name'])->trim(),
                    'quantity' => 1,
                    'item_price' => $row['total'] == null ? null : Str::of($row['total'])->trim(),
                ]);
            $orderItem = OrderItem::updateOrCreate(
                ['order_id' => $order->id, 'product_name' => $row['item_name']],
                ['order_id' => $order->id,
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'quantity' => 1,
                    'product_name' => $row['item_name'] == null ? null : Str::of($row['item_name'])->trim(),
                    'order_date' => $row['date_added'] == null ? null : ($row['date_added']),
                ]);
            $id = DB::table('invoices')->max('id') + 1;
            $invoice = $order->invoices()->create([
                'id' => $id,
                'company_id' => Auth::user()?Auth::user()->company_id:'',
                'customer_id' => $customer->id,
                'supplier_id' => $import->channel_id,
                'reference_number' => $row['order_id'] == null ? 0 : Str::of($row['order_id'])->trim(),
                'invoice_date' =>  $formated_date,
                'currency' => 'gbp',
                'sub_total' => $row['total'] == null ? 0 : Str::of($row['total'])->trim(),
                'status' => 'paid',
                'balance' => $row['total'] == null ? 0 : Str::of($row['total'])->trim(),
                'total' => $row['total'] == null ? 0 : Str::of($row['total'])->trim(),
                'is_sale' => true,
            ]);
            $invoice->invoice_number = 'INV'.str_pad($invoice->id, 6 , "0",STR_PAD_LEFT);
            $invoice->update();
            $iid = DB::table('invoice_items')->max('id') + 1;
            $invoiceItem = new InvoiceItem();
            $invoiceItem->id = $iid;
            $invoiceItem->company_id = Auth::user()?Auth::user()->company_id:'';
            $invoiceItem->invoice_id = $invoice->id;
            $invoiceItem->product_id = $productTitle ? $productTitle->product_id : null;
            $invoiceItem->currency = 'gbp';
            $invoiceItem->unit_price = $row['total'] == null ? 0 : Str::of($row['total'])->trim();
            $invoiceItem->quantity = 1;
            $invoiceItem->total = $row['total'] == 0 ? null : Str::of($row['total'])->trim();
            $invoiceItem->save();


            $payment = new CompanyPayment();
            $payment->company_id = Auth::user()?Auth::user()->company_id:'';
            $payment->supplier_id = $import->channel_id;
            $payment->invoice_id = $invoice->id;
            $payment->payer_currency_id = 'gbp';
            $payment->total_gbp =  $invoice?$invoice->total:'';
            $payment->payee_currency_id = 'gbp';
            $payment->payment_reference = $row['order_id'] == null ? 0 : Str::of($row['order_id'])->trim();
            $payment->payment_method = 'payment_method_card';
            $payment->amount = $invoice?$invoice->total:'';
            $payment->payee_total = $invoice?$invoice->total:'';
            $payment->payment_date = $formated_date;
            $payment->save();

//            $activeLog = new ActivityLog;
//            $className = get_class($moduleName);
//            $activeLog->company_id = Auth::user()->company_id;
//            $activeLog->user_id = Auth::user()->id;
//            $activeLog->module_name = $className;
//            $activeLog->activity = 'Import';
//            $activeLog->description = Auth::user()->name . ' ' . 'Import the CSV file';
//            $activeLog->save();

            $warehouse = Company::where('name', 'Bacup')->orderby('id', 'desc')->first();
            $orderQty = 1;
            $product = Product::where('id', $productTitle->product_id)->first();

            if ($product->shipping_method && $warehouse) {
                $stockLogs = StockLog::create([
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'order_item_id' => $orderItem->id,
                    'warehouse_id' => $warehouse ? $warehouse->id : 1,
                    'supplier_id' => $import->channel_id,
                    'product_id' => $product ? $product->id : null,
                    'user_id' => Auth::user() ? Auth::user()->id : '',
                    'quantity' => '-' . $orderItem->quantity,
                ]);
                if ($product->shipping_method === 'Tuffnells') {
                    if (isset($orderItem->product_id) && $orderItem->product_id != 'null') {
                        $eventDate = Carbon::now();
                        $productStocks = ProductStock::where([['product_id', $product->id], ['company_id', Auth::user() ? Auth::user()->company_id : '']])->latest('date')->first();
                        if ($productStocks) {
                            $product_Stocks = $productStocks->where([['date', date("Y-m-d", strtotime(Carbon::today()))]])->where('company_id', Auth::user() ? Auth::user()->company_id : '')->first();
                            if ($product_Stocks) {
                                $product_Stocks->quantity = $product_Stocks->quantity + $stockLogs->quantity;
                                $product_Stocks->date = date("Y-m-d", strtotime(Carbon::today()));
                                $product_Stocks->update();
                            } else {
                                $product_Stocks = new ProductStock();
                                $product_Stocks->company_id = Auth::user() ? Auth::user()->company_id : '';
                                $product_Stocks->product_id = $product->id;
                                $product_Stocks->date = date("Y-m-d", strtotime(Carbon::today()));
                                $product_Stocks->quantity = $productStocks->quantity + $stockLogs->quantity;
                                $product_Stocks->save();
                            }
                            if ($warehouse) {
                                $warehouseStock = WarehouseStock::where('product_id', $product->id)->where('warehouse_id', $warehouse->id)
                                    ->where('company_id', Auth::user() ? Auth::user()->company_id : '')->first();
                                if ($warehouseStock) {
                                    $warehouseStock->quantity = $warehouseStock->quantity - $orderQty;
                                    $warehouseStock->update();
                                } else {
                                    $warehouse_Stocks = new WarehouseStock();
                                    $warehouse_Stocks->company_id = Auth::user() ? Auth::user()->company_id : '';
                                    $warehouse_Stocks->product_id = $product->id;
                                    $warehouse_Stocks->warehouse_id = $warehouse->id;
                                    $warehouse_Stocks->quantity = $product_Stocks->quantity;
                                    $warehouse_Stocks->save();
                                }
                            }
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
                                    'delivery_date' => $eventDate,
                                    'status' => 'processing'
                                ]);
                        } else {
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
                                    'delivery_date' => $eventDate,
                                    'status' => 'pending',
                                    'note' => 'This product is out of stock. The order quantity were:' . $orderQty . ''
                                ]);
                            $product_Stocks = new ProductStock();
                            $product_Stocks->company_id = Auth::user() ? Auth::user()->company_id : '';
                            $product_Stocks->product_id = $product->id;
                            $product_Stocks->date = date("Y-m-d", strtotime(Carbon::today()));
                            $product_Stocks->quantity = $stockLogs->quantity;
                            $product_Stocks->save();

                            $warehouse_Stocks = new WarehouseStock();
                            $warehouse_Stocks->company_id = Auth::user() ? Auth::user()->company_id : '';
                            $warehouse_Stocks->product_id = $product->id;
                            $warehouse_Stocks->warehouse_id = $warehouse->id;
                            $warehouse_Stocks->quantity = $stockLogs->quantity;
                            $warehouse_Stocks->save();
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

//            $feedback = Feedback::where('order_id', $order->id)->first();
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
        return 200;
    }
}
