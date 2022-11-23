<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\CompanyPayment;
use App\Models\CurrencyExchange;
use App\Models\Invoice;
use DateTime;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Ejogga;
use App\Models\Module;
use App\Models\Import;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\StockLog;
use App\Models\OrderItem;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ProductStock;
use App\Models\DeliveryItem;
use App\Models\ProductTitle;
use App\Models\SalesChannel;
use App\Models\WarehouseStock;
use App\Services\Traits\Logger;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EjoggaImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected $fileName;
    use Logger;
    use DefaultActiveLog;

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
            'file_name' => $this->fileName,
            'user_id' => Auth::user()->id,
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
        ]);

        foreach ($rows as $row) {

            $date1 = strtr($row['order_date'], '/', '-');
            $date2 = substr($date1, 0, -6);

            if (DateTime::createFromFormat('Y-m-d', $date2) !== FALSE) {
                $date3 = Carbon::createFromFormat('Y-m-d', $date2);
                $date4 = $date3->toDateString();
            } else {
                $date4 = date('Y-m-d', strtotime($date2));
            };
            $date = $row['order_date'] == null ? null : date('Y-m-d', strtotime($date1));
            $customer_first_name = $row['first_name_billing'] == null ? null : Str::of($row['first_name_billing'])->trim();
            $customer_last_name = $row['last_name_billing'] == null ? null : Str::of($row['last_name_billing'])->trim();
            $cudtomer_name = $customer_first_name . " " . $customer_last_name;
            $customer_shipping_first_name = $row['first_name_shipping'] == null ? null : Str::of($row['first_name_shipping'])->trim();
            $customer_shipping_last_name = $row['last_name_shipping'] == null ? null : Str::of($row['last_name_shipping'])->trim();
            $shipping_customer_name = $customer_shipping_first_name . " " . $customer_shipping_last_name;
            $productTitle = ProductTitle::where('product_title', utf8_encode($row['item_name']))->first();

            $str = substr($this->fileName, 19);
            if (!$productTitle) {
                $error = ValidationException::withMessages([
                    'name' => ['Please add' . ' "' . utf8_encode($row['item_name']) . '" ' . ' into Product title table because this product name is not matching any lable. The file name is ' . $str . ' and order number is ' . $row['order_number']]
                ]);
                throw $error;
            }

            $moduleName = Ejogga::updateOrCreate(
                ['order_number' => $row['order_number']],
                [
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'order_number' => $row['order_number'] == null ? null : Str::of($row['order_number'])->trim(),
                    'import_id' => $import->id,
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'order_status' => $row['order_status'] == null ? null : Str::of($row['order_status'])->trim(),
                    'order_date' => $date4,
                    'customer_note' => $row['customer_note'] == null ? null : Str::of($row['customer_note'])->trim(),
                    'billing_first_name' => $row['first_name_billing'] == null ? null : Str::of($row['first_name_billing'])->trim(),
                    'billing_last_name' => $row['last_name_billing'] == null ? null : Str::of($row['last_name_billing'])->trim(),
                    'billing_company' => $row['company_billing'] == null ? null : Str::of($row['company_billing'])->trim(),
                    'billing_address_1_2' => $row['address_12_billing'] == null ? null : Str::of($row['address_12_billing'])->trim(),
                    'billing_city' => $row['city_billing'] == null ? null : Str::of($row['city_billing'])->trim(),
                    'billing_postcode' => $row['postcode_billing'] == null ? null : Str::of($row['postcode_billing'])->trim(),
                    'billing_country_code' => $row['country_code_billing'] == null ? null : Str::of($row['country_code_billing'])->trim(),
                    'billing_email' => $row['email_billing'] == null ? null : Str::of($row['email_billing'])->trim(),
                    'billing_phone' => $row['phone_billing'] == null ? null : Str::of($row['phone_billing'])->trim(),
                    'shipping_first_name' => $row['first_name_shipping'] == null ? null : Str::of($row['first_name_shipping'])->trim(),
                    'shipping_last_name' => $row['last_name_shipping'] == null ? null : Str::of($row['last_name_shipping'])->trim(),
                    'shipping_address_1_2' => $row['address_12_shipping'] == null ? null : Str::of($row['address_12_shipping'])->trim(),
                    'shipping_city' => $row['city_shipping'] == null ? null : Str::of($row['city_shipping'])->trim(),
                    'shipping_state_code' => $row['state_code_shipping'] == null ? null : Str::of($row['state_code_shipping'])->trim(),
                    'shipping_postcode' => $row['postcode_shipping'] == null ? null : Str::of($row['postcode_shipping'])->trim(),
                    'shipping_country_code' => $row['country_code_shipping'] == null ? null : Str::of($row['country_code_shipping'])->trim(),
                    'payment_method_title' => $row['payment_method_title'] == null ? null : Str::of($row['payment_method_title'])->trim(),
                    'cart_discount_amount' => $row['cart_discount_amount'] == null ? null : Str::of($row['cart_discount_amount'])->trim(),
                    'order_subtotal_amount' => $row['order_subtotal_amount'] == null ? null : Str::of($row['order_subtotal_amount'])->trim(),
                    'shipping_method_title' => $row['shipping_method_title'] == null ? null : Str::of($row['shipping_method_title'])->trim(),
                    'order_shipping_amount' => $row['order_shipping_amount'] == null ? null : Str::of($row['order_shipping_amount'])->trim(),
                    'order_refund_amount' => $row['order_refund_amount'] == null ? null : Str::of($row['order_refund_amount'])->trim(),
                    'order_total_amount' => $row['order_total_amount'] == null ? null : Str::of($row['order_total_amount'])->trim(),
                    'order_total_tax_amount' => $row['order_total_tax_amount'] == null ? null : Str::of($row['order_total_tax_amount'])->trim(),
                    'sku' => $row['sku'] == null ? null : Str::of($row['sku'])->trim(),
                    'item' => $row['item'] == null ? null : Str::of($row['item'])->trim(),
                    'item_name' => $row['item_name'] == null ? null : Str::of($row['item_name'])->trim(),
                    'quantity' => $row['quantity'] == null ? null : Str::of($row['quantity'])->trim(),
                    'item_cost' => $row['item_cost'] == null ? null : Str::of($row['item_cost'])->trim(),
                    'coupon_code' => $row['coupon_code'] == null ? null : Str::of($row['coupon_code'])->trim(),
                    'discount_amount' => $row['discount_amount'] == null ? null : Str::of($row['discount_amount'])->trim(),
                    'discount_amount_tax' => $row['discount_amount_tax'] == null ? null : Str::of($row['discount_amount_tax'])->trim(),
                ]);

            $customer = Customer::updateOrCreate(
                ['email' => $row['email_billing']],
                ['name' => $cudtomer_name ? $cudtomer_name : '',
                    'import_id' => $import->id,
                    'channel_id' => $import->channel_id,
                    'company_id' => Auth::user()->company_id,
                    'phone' => $row['phone_billing'] == null ? null : Str::of($row['phone_billing'])->trim(),
                    'address1_2' => $row['address_12_shipping'] == null ? null : Str::of($row['address_12_shipping'])->trim(),
                    'city' => $row['city_shipping'] == null ? null : Str::of($row['city_shipping'])->trim(),
                    'postcode' => $row['postcode_shipping'] == null ? null : Str::of($row['postcode_shipping'])->trim(),
                    'country' => $row['country_code_shipping'] == null ? null : Str::of($row['country_code_shipping'])->trim(),
                    'email' => $row['email_billing'] == null ? null : Str::of($row['email_billing'])->trim(),
                ]);

            $order = Order::updateOrCreate(
                ['order_number' => $row['order_number']],
                [
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'order_number' => $row['order_number'] == null ? null : Str::of($row['order_number'])->trim(),
                    'import_id' => $import->id,
                    'customer_id' => $customer ? $customer->id : '',
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'channel_id' => $import->channel_id,
                    'order_date' => $date4,
                    'order_status' => $row['order_status'] == null ? null : Str::of($row['order_status'])->trim(),
                    'customer_note' => $row['customer_note'] == null ? null : Str::of($row['customer_note'])->trim(),
                    'billing_customer_name' => $cudtomer_name ? $cudtomer_name : '',
                    'shipping_customer_name' => $shipping_customer_name ? $shipping_customer_name : '',
                    'billing_company' => $row['company_billing'] == null ? null : Str::of($row['company_billing'])->trim(),
                    'billing_address_1_2' => $row['address_12_billing'] == null ? null : Str::of($row['address_12_billing'])->trim(),
                    'billing_city' => $row['city_billing'] == null ? null : Str::of($row['city_billing'])->trim(),
                    'billing_postcode' => $row['postcode_billing'] == null ? null : Str::of($row['postcode_billing'])->trim(),
                    'billing_country' => $row['country_code_billing'] == null ? null : Str::of($row['country_code_billing'])->trim(),
                    'shipping_email' => $row['email_billing'] == null ? null : Str::of($row['email_billing'])->trim(),
                    'billing_phone' => $row['phone_billing'] == null ? null : Str::of($row['phone_billing'])->trim(),
                    'shipping_address_phone' => $row['phone_billing'] == null ? null : Str::of($row['phone_billing'])->trim(),
                    'shipping_address_1' => $row['address_12_shipping'] == null ? null : Str::of($row['address_12_shipping'])->trim(),
                    'shipping_address_city' => $row['city_shipping'] == null ? null : Str::of($row['city_shipping'])->trim(),
                    'shipping_state_code' => $row['state_code_shipping'] == null ? null : Str::of($row['state_code_shipping'])->trim(),
                    'shipping_address_postcode' => $row['postcode_shipping'] == null ? null : Str::of($row['postcode_shipping'])->trim(),
                    'shipping_address_county' => $row['country_code_shipping'] == null ? null : Str::of($row['country_code_shipping'])->trim(),
                    'payment_method_type' => $row['payment_method_title'] == null ? null : Str::of($row['payment_method_title'])->trim(),
                    'cart_discount_amount' => $row['cart_discount_amount'] == null ? null : Str::of($row['cart_discount_amount'])->trim(),
                    'order_subtotal_amount' => $row['order_subtotal_amount'] == null ? null : Str::of($row['order_subtotal_amount'])->trim(),
                    'dispatch_method' => $row['shipping_method_title'] == null ? null : Str::of($row['shipping_method_title'])->trim(),
                    'order_shipping_amount' => $row['order_shipping_amount'] == null ? null : Str::of($row['order_shipping_amount'])->trim(),
                    'order_refund_amount' => $row['order_refund_amount'] == null ? null : Str::of($row['order_refund_amount'])->trim(),
                    'order_total_amount' => $row['order_total_amount'] == null ? null : Str::of($row['order_total_amount'])->trim(),
                    'order_total_tax_amount' => $row['order_total_tax_amount'] == null ? null : Str::of($row['order_total_tax_amount'])->trim(),
                    'sku' => $row['sku'] == null ? null : Str::of($row['sku'])->trim(),
                    'item' => $row['item'] == null ? null : Str::of($row['item'])->trim(),
                    'product_name' => $row['item_name'] == null ? null : Str::of($row['item_name'])->trim(),
                    'quantity' => $row['quantity'] == null ? 1 : Str::of($row['quantity'])->trim(),
                    'item_price' => $row['item_cost'] == null ? null : Str::of($row['item_cost'])->trim(),
                    'coupon_code' => $row['coupon_code'] == null ? null : Str::of($row['coupon_code'])->trim(),
                    'discount_amount' => $row['discount_amount'] == null ? null : Str::of($row['discount_amount'])->trim(),
                    'discount_amount_tax' => $row['discount_amount_tax'] == null ? null : Str::of($row['discount_amount_tax'])->trim(),
                ]);
            $orderItem = OrderItem::updateOrCreate(
                ['order_id' => $order->id, 'product_name' => $row['item_name']],
                ['order_id' => $order->id,
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'return_status' => (isset($row['return_status']) ? $row['return_status'] : ''),
                    'quantity' => $row['quantity'] == null ? 1 : Str::of($row['quantity'])->trim(),
                    'product_name' => $row['item_name'] == null ? null : Str::of($row['item_name'])->trim(),
                    'order_date' => $date4,
                ]);

            $invoiceRecor = Invoice::where('reference_number', $row['order_number'])->first();
            if (!$invoiceRecor) {

                $id = DB::table('invoices')->max('id') + 1;
                $invoice = $order->invoices()->create([
                    'id' => $id,
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'customer_id' => $customer->id,
                    'supplier_id' => $import->channel_id,
                    'reference_number' => $row['order_number'] == null ? 0 : Str::of($row['order_number'])->trim(),
                    'invoice_date' => $date4,
                    'currency' => 'gbp',
                    'sub_total' => $row['order_subtotal_amount'] == null ? 0 : Str::of($row['order_subtotal_amount'])->trim(),
                    'status' => 'paid',
                    'balance' => $row['item_cost'] == null ? 0 : Str::of($row['item_cost'])->trim(),
                    'vat' => $row['order_total_tax_amount'] == null ? 0 : Str::of($row['order_total_tax_amount'])->trim(),
                    'total' => $row['order_total_amount'] == null ? 0 : Str::of($row['order_total_amount'])->trim(),
                    'is_sale' => true,
                ]);
                $invoice->invoice_number = 'INV' . str_pad($invoice->id, 6, "0", STR_PAD_LEFT);
                $invoice->update();
                $iid = DB::table('invoice_items')->max('id') + 1;
                $invoiceItem = new InvoiceItem();
                $invoiceItem->id = $iid;
                $invoiceItem->company_id = Auth::user() ? Auth::user()->company_id : '';
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->product_id = $productTitle ? $productTitle->product_id : null;
                $invoiceItem->currency = 'gbp';
                $invoiceItem->unit_price = $row['item_cost'] == null ? 0 : Str::of($row['item_cost'])->trim();
                $invoiceItem->quantity = $row['quantity'] == null ? 0 : Str::of($row['quantity'])->trim();
                $invoiceItem->total = $row['order_total_amount'] == 0 ? null : Str::of($row['order_total_amount'])->trim();
                $invoiceItem->save();
            } else {
                $invoiceRecor->company_id = Auth::user() ? Auth::user()->company_id : '';
                $invoiceRecor->customer_id = $customer->id;
                $invoiceRecor->supplier_id = $import->channel_id;
                $invoiceRecor->reference_number = $row['order_number'] == null ? 0 : Str::of($row['order_number'])->trim();
                $invoiceRecor->invoice_date = $date4;
                $invoiceRecor->currency = 'gbp';
                $invoiceRecor->sub_total = $row['order_subtotal_amount'] == null ? 0 : Str::of($row['order_subtotal_amount'])->trim();
                $invoiceRecor->status = 'paid';
                $invoiceRecor->balance =  $row['item_cost'] == null ? 0 : Str::of($row['item_cost'])->trim();
                $invoiceRecor->vat = $row['order_total_tax_amount'] == null ? 0 : Str::of($row['order_total_tax_amount'])->trim();
                $invoiceRecor->total =  $row['order_total_amount'] == null ? 0 : Str::of($row['order_total_amount'])->trim();
                $invoiceRecor->is_sale = true;
                $invoiceRecor->invoice_number ='INV' . str_pad($invoiceRecor->id, 6, "0", STR_PAD_LEFT);
                $invoiceRecor->update();

                $invoiceItem = InvoiceItem::where([['product_id', $productTitle->product_id],['invoice_id',$invoiceRecor->id]])->first();
                if($invoiceItem){
                    $invoiceItem->company_id = Auth::user() ? Auth::user()->company_id : '';
                    $invoiceItem->invoice_id = $invoiceRecor->id;
                    $invoiceItem->product_id = $productTitle ? $productTitle->product_id : null;
                    $invoiceItem->currency = 'gbp';
                    $invoiceItem->unit_price = $row['item_cost'] == null ? 0 : Str::of($row['item_cost'])->trim();
                    $invoiceItem->quantity = $row['quantity'] == null ? 0 : Str::of($row['quantity'])->trim();
                    $invoiceItem->total = $row['order_total_amount'] == 0 ? null : Str::of($row['order_total_amount'])->trim();
                    $invoiceItem->update();
                } else {
                    $iid = DB::table('invoice_items')->max('id') + 1;
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->id = $iid;
                    $invoiceItem->company_id = Auth::user() ? Auth::user()->company_id : '';
                    $invoiceItem->invoice_id = $invoiceRecor->id;
                    $invoiceItem->product_id = $productTitle ? $productTitle->product_id : null;
                    $invoiceItem->currency = 'gbp';
                    $invoiceItem->unit_price = $row['item_cost'] == null ? 0 : Str::of($row['item_cost'])->trim();
                    $invoiceItem->quantity = $row['quantity'] == null ? 0 : Str::of($row['quantity'])->trim();
                    $invoiceItem->total = $row['order_total_amount'] == 0 ? null : Str::of($row['order_total_amount'])->trim();
                    $invoiceItem->save();
                }
            }
            $payment = CompanyPayment::updateOrCreate([
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'invoice_id' => $invoice->id,
            ], [
                'company_id' => Auth::user() ? Auth::user()->company_id : '',
                'supplier_id' => $import->channel_id,
                'invoice_id' => $invoice->id,
                'payer_currency_id' => 'gbp',
                'total_gbp' => $invoice ? $invoice->total : '',
                'payee_currency_id' => 'gbp',
                'payment_reference' => $row['order_number'] == null ? 0 : Str::of($row['order_number'])->trim(),
                'payment_method' => 'payment_method_card',
                'amount' => $invoice ? $invoice->total : '',
                'payee_total' => $invoice ? $invoice->total : '',
                'payment_date' => $date4,
            ]);

//            $activeLog = new ActivityLog;
//            $className = get_class($moduleName);
//            $activeLog->company_id = Auth::user()->company_id;
//            $activeLog->user_id = Auth::user()->id;
//            $activeLog->module_name = $className;
//            $activeLog->activity = 'Import';
//            $activeLog->description = Auth::user()->name . ' ' . 'Import the CSV file';
//            $activeLog->save();

            $warehouse = Company::where('name', 'Bacup')->orderby('id', 'desc')->first();
            $orderQty = $row['quantity'] ? $row['quantity'] : 1;
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
            } else {
                $error = ValidationException::withMessages(['name' => ['Please add Bacup warehouse in the system']]);
                throw $error;
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
        return 700;
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
