<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\CompanyPayment;
use Carbon\Carbon;
use App\Models\Deal;
use App\Models\Order;
use App\Models\Import;
use App\Models\Product;
use App\Models\Feedback;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\StockLog;
use App\Models\Gogroopie;
use App\Models\OrderItem;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\InvoiceItem;
use App\Models\SalesChannel;
use App\Models\ProductStock;
use App\Models\ProductTitle;
use App\Models\DeliveryItem;
use App\Models\DealsProducts;
use App\Models\WarehouseStock;
use App\Services\Traits\Logger;
use App\Models\DealsProductsRates;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Services\Traits\DefaultActiveLog;
use App\Services\Feedback\FeedbackService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class GogroopieImport implements ToCollection, WithHeadingRow, WithChunkReading
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
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\GogroopieImport',
            'activity' => 'view',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $channel_id = request()->get('channel_id');

        $saleChannel = SalesChannel::where('id', $channel_id)->first();

        $import = Import::updateOrCreate(['file_name' => $this->fileName], [
            'channel_id' => $saleChannel->id,
            'file_name' => $this->fileName,
            'user_id' => Auth::user()->id,
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
        ]);
        foreach ($rows as $row) {
            $date1 = strtr($row['redeem_date'], '/', '-');
            $date = date('Y-m-d', strtotime($date1));
            $productTitle = ProductTitle::where('product_title', trim($row['product']))->first();
//            $deal = Deal::where('deal_number', $row['deal_id'])->first();
            $str = substr($this->fileName, 19);
            //          if (!$deal) {
            //            $error = ValidationException::withMessages([
            //              'name' => [
            //            'Error importing file! Deal "' . $row['deal_id'] . '" does not exist in the system. Please add this deal before importing the file.' ]
            //      ]);
            //    throw $error;
            //y}
            if (!$productTitle) {
                $error = ValidationException::withMessages([
                    'name' => ['Error importing file! Product title: "' . trim($row['product']) . '" does not exist in the system. Please add this title to the product before importing the file. ']
                ]);
                throw $error;
            }

            $ship_add_1 = $row['house'] == null ? null : Str::of($row['house'])->trim();
            $ship_add_2 = $row['street'] == null ? null : Str::of($row['street'])->trim();
            $ship_address_1 = $ship_add_1 ? $ship_add_1 : '';
            $ship_address_2 = $ship_add_2 ? $ship_add_2 : '';
            $shipAddress = $ship_address_1 . " " . $ship_address_2;

            $moduleName = Gogroopie::updateOrCreate(
                ['voucher_code' => $row['voucher_code']],
                [
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'deal_id' => $row['deal_id'] == null ? null : Str::of($row['deal_id'])->trim(),
                    'import_id' => $import->id,
                    'voucher_code' => $row['voucher_code'] == null ? null : Str::of($row['voucher_code'])->trim(),
                    'full_name' => $row['full_name'] == null ? null : Str::of($row['full_name'])->trim(),
                    'email' => $row['email'] == null ? null : Str::of($row['email'])->trim(),
                    'house' => $row['house'] == null ? null : Str::of($row['house'])->trim(),
                    'street' => $row['street'] == null ? null : Str::of($row['street'])->trim(),
                    'city' => $row['city'] == null ? null : Str::of($row['city'])->trim(),
                    'country' => $row['country'] == null ? null : Str::of($row['country'])->trim(),
                    'phone' => $row['phone'] == null ? null : Str::of($row['phone'])->trim(),
                    'postcode' => $row['post_code'] == null ? null : Str::of($row['post_code'])->trim(),
                    'redeem_date' => trim($row['redeem_date']) == 'NULL' || trim($row['redeem_date']) == '' ? null : date('Y-m-d', strtotime(Str::before($row['redeem_date'], ' '))),
                    'deal_option' => $row['deal_option'] == null ? null : Str::of($row['deal_option'])->trim(),
                    'product' => $row['product'] == null ? null : Str::of($row['product'])->trim(),
                    'price_option' => $row['price_option'] == null ? null : Str::of($row['price_option'])->trim(),
                ]);

            $customer = Customer::updateOrCreate(
                ['email' => $row['email']],
                ['name' => $row['full_name'] == null ? null : Str::of($row['full_name'])->trim(),
                    'import_id' => $import->id,
                    'channel_id' => $import->channel_id,
                    'company_id' => Auth::user()->company_id,
                    'phone' => $row['phone'] == null ? null : Str::of($row['phone'])->trim(),
                    'address1_2' => $row['street'] == null ? null : Str::of($row['street'])->trim(),
                    'city' => $row['city'] == null ? null : Str::of($row['city'])->trim(),
                    'postcode' => $row['post_code'] == null ? null : Str::of($row['post_code'])->trim(),
                    'country' => $row['country'] == null ? null : Str::of($row['country'])->trim(),
                    'email' => $row['email'] == null ? null : Str::of($row['email'])->trim(),
                ]);

            $order = Order::updateOrCreate(
                ['order_number' => $row['voucher_code']],
                ['import_id' => $import->id,
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'customer_id' => $customer ? $customer->id : '',
                    'channel_id' => $import->channel_id,
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'deal_id' => $row['deal_id'] == null ? null : Str::of($row['deal_id'])->trim(),
                    'order_number' => $row['voucher_code'] == null ? null : Str::of($row['voucher_code'])->trim(),
                    'shipping_customer_name' => $row['full_name'] == null ? null : Str::of($row['full_name'])->trim(),
                    'shipping_email' => $row['email'] == null ? null : Str::of($row['email'])->trim(),
                    'shipping_address_1' => $shipAddress ? $shipAddress : '',
                    'shipping_address_town' => $row['city'] == null ? null : Str::of($row['city'])->trim(),
                    'shipping_country' => $row['country'] == null ? null : Str::of($row['country'])->trim(),
                    'shipping_address_phone' => $row['phone'] == null ? null : Str::of($row['phone'])->trim(),
                    'shipping_address_postcode' => $row['post_code'] == null ? null : Str::of($row['post_code'])->trim(),
                    'order_date' => trim($row['redeem_date']) == 'NULL' || trim($row['redeem_date']) == '' ? null : $date,
                    'deal_option' => $row['deal_option'] == null ? null : Str::of($row['deal_option'])->trim(),
                    'product_name' => $row['product'] == null ? null : Str::of($row['product'])->trim(),
                    'product_option' => $row['price_option'] == null ? null : Str::of($row['price_option'])->trim(),
                    'quantity' => 1,
                    'order_status' => 'processing',
                ]);

            $dealProduct = DealsProducts::where([['product_id', $productTitle->product_id], ['deal_number', $row['deal_id']]])->first();
            $rateToBeApplied = null;
            if ($dealProduct) {
                $dealRates = DealsProductsRates::where('deal_product_id', $dealProduct->id)->orderBy('start_date')->get();
                $checkdate = Carbon::parse($date);
                $count = $dealRates->count();
                if ($count > 1) {
                    for ($i = 0; $i < (count($dealRates) - 1); $i++) {
                        $dateFind = $checkdate->between($dealRates[$i]->start_date, $dealRates[$i + 1]->start_date);
                        if ($dateFind) {
                            if ($checkdate->lessThan(Carbon::parse($dealRates[$i + 1]->start_date))) {
                                $rateToBeApplied = $dealRates[$i];
                                break;
                            }
                            if ($checkdate->equalTo(Carbon::parse($dealRates[$i + 1]->start_date))) {
                                $rateToBeApplied = $dealRates[$i + 1];
                                break;
                            }
                        } elseif ((count($dealRates) - 1) == $i + 1) {
                            $rateToBeApplied = $dealRates[$i + 1];
                        }
                    }
                } else {
                    $rateToBeApplied = $dealRates[0];
                }
                $dealDate = trim($row['redeem_date']) == 'NULL' || trim($row['redeem_date']) == '' ? null : $date;
                $dealProductRates = DealsProductsRates::where([['deal_product_id', $dealProduct->id], ['start_date', '<=', $dealDate]])->latest('start_date')->first();
                if ($dealProductRates) {
                    $id = DB::table('invoices')->max('id') + 1;
                    $invoice = $order->invoices()->create([
                        'id' => $id,
                        'company_id' => Auth::user() ? Auth::user()->company_id : '',
                        'customer_id' => $customer->id,
                        'supplier_id' => $import->channel_id,
                        'reference_number' => $row['voucher_code'] == null ? null : Str::of($row['voucher_code'])->trim(),
                        'invoice_date' => trim($row['redeem_date']) == 'NULL' || trim($row['redeem_date']) == '' ? null : $date,
                        'currency' => 'gbp',
                        'vat' => 0,
                        'sub_total' => $dealProductRates ? $dealProductRates->deal_price : 0,
                        'status' => 'paid',
                        'balance' => $dealProductRates ? $dealProductRates->deal_price : 0,
                        'total' => $dealProductRates ? $dealProductRates->deal_price : 0,
                        'is_sale' => true,
                    ]);
                    $invoice->invoice_number = 'INV' . str_pad($invoice->id, 6, 0, STR_PAD_LEFT);
                    $invoice->update();

                    $order->invoice_number = $invoice->invoice_number;
                    $order->update();

                    $iid = DB::table('invoice_items')->max('id') + 1;
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->id = $iid;
                    $invoiceItem->company_id = Auth::user() ? Auth::user()->company_id : '';
                    $invoiceItem->invoice_id = $invoice->id;
                    $invoiceItem->product_id = $productTitle ? $productTitle->product_id : null;
                    $invoiceItem->currency = 'gbp';
                    $invoiceItem->unit_price = $dealProductRates ? $dealProductRates->deal_price : 1;
                    $invoiceItem->quantity = 1;
                    $invoiceItem->vat = 0;
                    $invoiceItem->total = $invoiceItem->unit_price * $invoiceItem->quantity;
                    $invoiceItem->save();

                    $payment = new CompanyPayment();
                    $payment->company_id = Auth::user() ? Auth::user()->company_id : '';
                    $payment->supplier_id = $import->channel_id;
                    $payment->invoice_id = $invoice->id;
                    $payment->payer_currency_id = 'gbp';
                    $payment->total_gbp = $invoice ? $invoice->total : '';
                    $payment->payee_currency_id = 'gbp';
                    $payment->payment_reference = $row['voucher_code'] == null ? null : Str::of($row['voucher_code'])->trim();
                    $payment->payment_method = 'payment_method_card';
                    $payment->amount = $invoice ? $invoice->total : '';
                    $payment->payee_total = $invoice ? $invoice->total : '';
                    $payment->payment_date = trim($row['redeem_date']) == 'NULL' || trim($row['redeem_date']) == '' ? null : $date;
                    $payment->save();

                }
            }

            $orderItem = OrderItem::updateOrCreate(
                ['order_id' => $order->id, 'product_name' => $row['product']],
                ['order_id' => $order->id,
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'deal_product_rate_id' => $rateToBeApplied ? $rateToBeApplied->id : null,
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'return_status' => (isset($row['return_status']) ? $row['return_status'] : ''),
                    'quantity' => 1,
                    'product_name' => $row['product'] == null ? null : Str::of($row['product'])->trim(),
                    'order_date' => trim($row['redeem_date']) == 'NULL' || trim($row['redeem_date']) == '' ? null : $date,
                ]);
            $warehouse = Company::where('name', 'Bacup')->orderby('id', 'desc')->first();
            $orderQty = 1;
            $product = Product::where('id', $productTitle->product_id)->first();
            if ($product->shipping_method) {
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
//                                $product_Stocks = ProductStock::where([['product_id', $product->id], ['date', date("Y-m-d", strtotime(Carbon::today()))]])->first();
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
                if ($product->shipping_method === 'Parcelforce') {
                    if (isset($orderItem->product_id) && $orderItem->product_id != 'null') {

                        if ($orderItem->product->quantity <= 0) {
                            DeliveryItem::updateOrCreate(
                                ['order_item_id' => $orderItem->id],
                                [
                                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                                    'order_item_id' => $orderItem->id,
                                    'order_id' => $order->id,
                                    'delivery_method' => 'Parcelforce',
                                    'status' => 'pending',
                                    'quantity' => $product->quantity,
                                    'note' => 'The product is out of stock'
                                ]);

                        } else {
                            $del = DeliveryItem::updateOrCreate(
                                ['order_item_id' => $orderItem->id],
                                [
                                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                                    'order_item_id' => $orderItem->id,
                                    'order_id' => $order->id,
                                    'delivery_method' => 'Tuffnells',
                                    'status' => 'processing'
                                ]);
                            if ($del->wasRecentlyCreated) {
                                $product->decrement('quantity', $orderQty);
                            }

                        }

                    }
                }
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
