<?php

namespace App\Imports;

use App\Models\Company;
use Carbon\Carbon;
use App\Models\Deal;
use App\Models\Order;
use App\Models\Import;
use App\Models\Wowcher;
use App\Models\Product;
use App\Models\Feedback;
use App\Models\Customer;
use App\Models\StockLog;
use App\Models\Delivery;
use App\Models\Warehouse;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\InvoiceItem;
use App\Models\ProductStock;
use App\Models\SalesChannel;
use App\Models\DeliveryItem;
use App\Models\ProductTitle;
use App\Models\DealsProducts;
use App\Models\CompanyPayment;
use App\Models\WarehouseStock;
use App\Services\Traits\Logger;
use App\Models\DealsProductsRates;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\DefaultActiveLog;
use App\Services\Feedback\FeedbackService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class WowcherImport implements ToCollection, WithHeadingRow, WithChunkReading
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
     * @param Collection $rows
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

        // $this->logable($import, $saleChannel);
        foreach ($rows as $row) {
            $date1 = strtr($row['redeemed_at'], '/', '-');
            $date = date('Y-m-d', strtotime($date1));
            $productTitle = ProductTitle::where('product_title', trim($row['product_name']))->first();
            //    $deal = Deal::where('deal_number', $row['deal_id'])->first();
            $str = substr($this->fileName, 19);

            //  if (!$deal) {
            //    $error = ValidationException::withMessages([
            //      'name' => [
            //        'Error importing file! Deal "' . $row['deal_id'] . '" does not exist in the system. Please add this deal before importing the file.' ]
            // ]);
            // throw $error;
            // }

            if (!$productTitle) {
                $error = ValidationException::withMessages([
                    'name' => ['Error importing file! Product title: "' . trim($row['product_name']) . '" does not exist in the system. Please add this title to the product before importing the file. ']
                ]);
                throw $error;
            }
            $ship_add_house = $row['house_number'] == null ? null : Str::of($row['house_number'])->trim();
            $ship_add_1 = $row['address_line_1'] == null ? null : Str::of($row['address_line_1'])->trim();
            $shipAddress = $ship_add_house ? $ship_add_house . ", " : '' . $ship_add_1;

            $moduleName = Wowcher::updateOrCreate(
                ['wowcher_code' => $row['wowcher_code']],
                [
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'deal_id' => $row['deal_id'] == null ? null : Str::of($row['deal_id'])->trim(),
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'import_id' => $import ? $import->id : null,
                    'redeemed_at' => trim($row['redeemed_at']) == 'NULL' || trim($row['redeemed_at']) == '' ? null : date('Y-m-d', strtotime(Str::before($row['redeemed_at'], ' '))),
                    'wowcher_code' => $row['wowcher_code'] == null ? null : Str::of($row['wowcher_code'])->trim(),
                    'deal_title' => $row['deal_title'] == null ? null : Str::of($row['deal_title'])->trim(),
                    'customer_name' => $row['customer_name'] == null ? null : Str::of($row['customer_name'])->trim(),
                    'house_number' => $row['house_number'] == null ? null : Str::of($row['house_number'])->trim(),
                    'address_line_1' => $row['address_line_1'] == null ? null : Str::of($row['address_line_1'])->trim(),
                    'address_line_2' => $row['address_line_2'] == null ? null : Str::of($row['address_line_2'])->trim(),
                    'city' => $row['city'] == null ? null : Str::of($row['city'])->trim(),
                    'county' => $row['county'] == null ? null : Str::of($row['county'])->trim(),
                    'postcode' => $row['postcode'] == null ? null : Str::of($row['postcode'])->trim(),
                    'email' => $row['email'] == null ? null : Str::of($row['email'])->trim(),
                    'phone' => $row['phone'] == null ? null : Str::of($row['phone'])->trim(),
                    'birthday' => $row['birthday'] == null ? null : Str::of($row['birthday'])->trim(),
                    'marketing_permission' => $row['marketing_permission'] == null ? null : Str::of($row['marketing_permission'])->trim(),
                    'product_name' => $row['product_name'] == null ? null : Str::of($row['product_name'])->trim(),
                    'product_options' => $row['product_options'] == null ? null : Str::of($row['product_options'])->trim(),
                    'sku' => $row['sku'] == null ? null : Str::of($row['sku'])->trim(),
                    'despatch_method' => $row['despatch_method'] == null ? null : Str::of($row['despatch_method'])->trim(),
                ]);
            $customer = Customer::updateOrCreate(
                ['email' => $row['email']],
                ['name' => $row['customer_name'] == null ? null : Str::of($row['customer_name'])->trim(),
                    'import_id' => $import->id,
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'channel_id' => $import->channel_id,
                    'phone' => $row['phone'] == null ? null : Str::of($row['phone'])->trim(),
                    'house_number' => $row['house_number'] == null ? null : Str::of($row['house_number'])->trim(),
                    'address1_2' => $shipAddress ? $shipAddress : '',
                    'city' => $row['city'] == null ? null : Str::of($row['city'])->trim(),
                    'postcode' => $row['postcode'] == null ? null : Str::of($row['postcode'])->trim(),
                    'country' => $row['county'] == null ? null : Str::of($row['county'])->trim(),
                    'email' => $row['email'] == null ? null : Str::of($row['email'])->trim(),
                ]);
            $order = Order::updateOrCreate(
                ['order_number' => $row['wowcher_code']],
                ['import_id' => $import->id,
                    'customer_id' => $customer ? $customer->id : '',
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'channel_id' => $import->channel_id,
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'deal_id' => $row['deal_id'] == null ? null : Str::of($row['deal_id'])->trim(),
                    'order_number' => $row['wowcher_code'] == null ? null : Str::of($row['wowcher_code'])->trim(),
                    'order_date' => trim($row['redeemed_at']) == null ? null : date('Y-m-d', strtotime(Str::before($row['redeemed_at'], ' '))),
                    'shipping_customer_name' => $row['customer_name'] == null ? null : Str::of($row['customer_name'])->trim(),
                    'house_number' => $row['house_number'] == null ? null : Str::of($row['house_number'])->trim(),
                    'shipping_address_1' => $shipAddress,
                    'shipping_address_2' => $row['address_line_2'] == null ? null : Str::of($row['address_line_2'])->trim(),
                    'shipping_address_town' => $row['city'] == null ? null : Str::of($row['city'])->trim(),
                    'shipping_county' => $row['county'] == null ? null : Str::of($row['county'])->trim(),
                    'shipping_address_postcode' => $row['postcode'] == null ? null : Str::of($row['postcode'])->trim(),
                    'shipping_email' => $row['email'] == null ? null : Str::of($row['email'])->trim(),
                    'shipping_address_phone' => $row['phone'] == null ? null : Str::of($row['phone'])->trim(),
                    'birthday' => $row['birthday'] == null ? null : Str::of($row['birthday'])->trim(),
                    'marketing_permalink' => $row['marketing_permission'] == null ? null : Str::of($row['marketing_permission'])->trim(),
                    'product_name' => $row['product_name'] == null ? null : Str::of($row['product_name'])->trim(),
                    'product_option' => $row['product_options'] == null ? null : Str::of($row['product_options'])->trim(),
                    'sku' => $row['sku'] == null ? null : Str::of($row['sku'])->trim(),
                    'dispatch_method' => $row['despatch_method'] == null ? null : Str::of($row['despatch_method'])->trim(),
                    'quantity' => 1,
                    'order_status' => 'processing',
                ]);
            $message = 'Import';
            // $this->logForOrder($order, $message);

            $dealProduct = DealsProducts::where([['product_id', $productTitle->product_id], ['deal_number', $row['deal_id']]])->first();
            $rateToBeApplied = null;
            if ($dealProduct) {
                $dealRates = DealsProductsRates::where([['deal_product_id', $dealProduct->id], ['start_date', '<=', $row['redeemed_at']]])->orderBy('start_date')->get();
                if ($dealRates) {
                    $checkdate = Carbon::parse($date);
                    $count = $dealRates->count();
                    if ($count == 1) {
                        $rateToBeApplied = $dealRates[0];
                    } else if ($count >= 2) {
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
                    }
                    $dealDate = trim($row['redeemed_at']) == null ? null : date('Y-m-d', strtotime(Str::before($row['redeemed_at'], ' ')));
                    $dealProductRates = DealsProductsRates::where([['deal_product_id', $dealProduct->id], ['start_date', '<=', $dealDate]])->latest('start_date')->first();
                    if ($dealProductRates) {
                        $id = DB::table('invoices')->max('id') + 1;
                        $invoice = $order->invoices()->create([
                            'id' => $id,
                            'company_id' => Auth::user() ? Auth::user()->company_id : '',
                            'customer_id' => $customer->id,
                            'supplier_id' => $import->channel_id,
                            'deal_number' => $order->deal_id,
                            'reference_number' => $row['wowcher_code'] == null ? null : Str::of($row['wowcher_code'])->trim(),
                            'invoice_date' => trim($row['redeemed_at']) == null ? null : date('Y-m-d', strtotime(Str::before($row['redeemed_at'], ' '))),
                            'currency' => 'gbp',
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
                        $invoiceItem->unit_price = $dealProductRates ? $dealProductRates->deal_price : 0;
                        $invoiceItem->vat = 0;
                        $invoiceItem->quantity = 1;
                        $invoiceItem->total = $invoiceItem->unit_price * $invoiceItem->quantity;
                        $invoiceItem->save();

                        $payment = new CompanyPayment();
                        $payment->company_id = Auth::user() ? Auth::user()->company_id : '';
                        $payment->supplier_id = $import->channel_id;
                        $payment->invoice_id = $invoice->id;
                        $payment->payer_currency_id = 'gbp';
                        $payment->total_gbp = $invoice ? $invoice->total : '';
                        $payment->payee_currency_id = 'gbp';
                        $payment->payment_reference = $row['wowcher_code'] == null ? null : Str::of($row['wowcher_code'])->trim();
                        $payment->payment_method = 'payment_method_card';
                        $payment->amount = $invoice ? $invoice->total : '';
                        $payment->payee_total = $invoice ? $invoice->total : '';
                        $payment->payment_date = trim($row['redeemed_at']) == null ? null : date('Y-m-d', strtotime(Str::before($row['redeemed_at'], ' ')));
                        $payment->save();
                    }
                } else {
                    $error = ValidationException::withMessages([
                        'name' => [
                            'Error importing file! Deal "' . $row['deal_id'] . '" does not have Deal Rate in the system. Please add this Deal Rate before importing the order:' . $row['wowcher_code']]
                    ]);
                    throw $error;
                }
            }

            $orderItem = OrderItem::updateOrCreate(
                ['order_id' => $order->id,
                    'product_name' => $row['product_name']],
                ['order_id' => $order->id,
                    'product_id' => $productTitle ? $productTitle->product_id : null,
                    'deal_product_rate_id' => $rateToBeApplied ? $rateToBeApplied->id : null,
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'return_status' => (isset($row['return_status']) ? $row['return_status'] : ''),
                    'quantity' => 1,
                    'status' => 'processing',
                    'product_name' => $row['product_name'] == null ? null : Str::of($row['product_name'])->trim(),
                    'order_date' => trim($row['redeemed_at']) == null ? null : date('Y-m-d', strtotime(Str::before($row['redeemed_at'], ' '))),
                ]);

            $warehouse = Company::where('name', 'Bacup')->orderby('id', 'desc')->first();
            $orderQty = 1;
            $product = Product::where('id', $productTitle->product_id)->first();
            if (isset($product->shipping_method)) {
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
            }
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
