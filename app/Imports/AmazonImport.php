<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\Import;
use App\Models\Amazon;
use App\Services\Traits\Logger;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Feedback;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Models\DeliveryItem;
use App\Models\ProductTitle;
use Smalot\PdfParser\Parser;
use App\Models\SalesChannel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Services\Feedback\FeedbackService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AmazonImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    protected $fileName;
    use Logger;

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
            'file_name' => $this->fileName,
            'user_id' => Auth::user()->id,
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
        ]);
        $this->logable($import, $saleChannel);
        foreach ($rows as $row) {
            $singleQuantity = $row['quantity'];
            $product = ProductTitle::where('product_title', $row['product_name'])->first();
            $str = substr($this->fileName, 19);
            if (!$product) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'name' => ['Please add' . ' "' . $row['product_name'] . '" ' . ' into Product title table because this product name is not matching any lable. The file name is ' . $str . ' and order number is ' . $row['order_id']]
                ]);
                throw $error;
            }

            $ship_add_1 = $row['ship_address_1'] == null ? null : Str::of($row['ship_address_1'])->trim();
            $ship_add_2 = $row['ship_address_2'] == null ? null : Str::of($row['ship_address_2'])->trim();
            $ship_add_3 = $row['ship_address_3'] == null ? null : Str::of($row['ship_address_3'])->trim();
//            $ship_address_1 = $ship_add_1 ? $ship_add_1 : '';
//            $ship_address_2 = $ship_add_2 ? $ship_add_2 : '';
//            $ship_address_3 = $ship_add_3 ? $ship_add_3 : '';
//            $shipAddress = $ship_address_1 . " " . $ship_address_2 . " " . $ship_address_3;

            Amazon::updateOrCreate(
                ['order_id' => $row['order_id']],
                [
                    'product_id' => $product ? $product->product_id : null,
                    'order_id' => $row['order_id'] == null ? null : Str::of($row['order_id'])->trim(),
                    'import_id' => $import->id,
                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                    'customer_name' => $row['buyer_name'] == null ? null : Str::of($row['buyer_name'])->trim(),
                    'order_date' => trim($row['payments_date']) == 'NULL' || trim($row['payments_date']) == '' ? null : date('Y-m-d', strtotime(Str::before($row['payments_date'], ' '))),
                    'postal_address_1' => $row['ship_address_1'] == null ? null : Str::of($row['ship_address_1'])->trim(),
                    'postal_address_2' => $row['ship_address_2'] == null ? null : Str::of($row['ship_address_2'])->trim(),
                    'postal_address_3' => $row['ship_address_3'] == null ? null : Str::of($row['ship_address_3'])->trim(),
                    'phone' => $row['buyer_phone_number'] == null ? null : Str::of($row['buyer_phone_number'])->trim(),
                    'ship_city' => $row['ship_city'] == null ? null : Str::of($row['ship_city'])->trim(),
                    'ship_country' => $row['ship_country'] == null ? null : Str::of($row['ship_country'])->trim(),
                    'ship_state' => $row['ship_state'] == null ? null : Str::of($row['ship_state'])->trim(),
                    'post_code' => $row['ship_postal_code'] == null ? null : Str::of($row['ship_postal_code'])->trim(),
                    'item_name' => $row['product_name'] == null ? null : Str::of($row['product_name'])->trim(),
                    'order_item_id' => $row['order_item_id'] == null ? null : Str::of($row['order_item_id'])->trim(),
                    'sku' => $row['sku'] == null ? null : Str::of($row['sku'])->trim(),
                    'quantity' => $row['quantity_to_ship'] == null ? null : Str::of($row['quantity_to_ship'])->trim(),
                    'email' => $row['buyer_email'] == null ? null : Str::of($row['buyer_email'])->trim(),
                ]);

            $customer = Customer::updateOrCreate(
                ['email' => $row['buyer_email']],
                ['name' => $row['buyer_name'] == null ? null : Str::of($row['buyer_name'])->trim(),
                'import_id' => $import->id,
                    'channel_id' => $import->channel_id,
                    'company_id' => Auth::user()->company_id,
                    'phone' => $row['buyer_phone_number'] == null ? null : Str::of($row['buyer_phone_number'])->trim(),
                    'postal_address_1' => $row['ship_address_1'] == null ? null : Str::of($row['ship_address_1'])->trim(),
                    'city' => $row['ship_city'] == null ? null : Str::of($row['ship_city'])->trim(),
                    'postcode' => $row['ship_postal_code'] == null ? null : Str::of($row['ship_postal_code'])->trim(),
                    'country' => $row['ship_country'] == null ? null : Str::of($row['ship_country'])->trim(),
                    'email' => $row['buyer_email'] == null ? null : Str::of($row['buyer_email'])->trim(),
                ]);

            $order = Order::updateOrCreate(
                ['order_number' => $row['order_id']],
                ['import_id' => $import->id,
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'customer_id' => $customer ? $customer->id : '',
                    'channel_id' => $import->channel_id,
                    'order_number' => $row['order_id'] == null ? null : Str::of($row['order_id'])->trim(),
                    'shipping_customer_name' => $row['buyer_name'] == null ? null : Str::of($row['buyer_name'])->trim(),
                    'shipping_address_1' => $shipAddress ? $shipAddress : '',
                    'shipping_address_town' => $row['ship_city'] == null ? null : Str::of($row['ship_city'])->trim(),
                    'shipping_country' => $row['ship_country'] == null ? null : Str::of($row['ship_country'])->trim(),
                    'shipping_address_phone' => $row['buyer_phone_number'] == null ? null : Str::of($row['buyer_phone_number'])->trim(),
                    'shipping_address_postcode' => $row['ship_postal_code'] == null ? null : Str::of($row['ship_postal_code'])->trim(),
                    'order_date' => trim($row['payments_date']) == 'NULL' || trim($row['payments_date']) == '' ? null : date('Y-m-d', strtotime(Str::before($row['payments_date'], ' '))),
                    'product_name' => $row['product_name'] == null ? null : Str::of($row['product_name'])->trim(),
                    'quantity' => $row['quantity_to_ship'] == null ? null : Str::of($row['quantity_to_ship'])->trim(),
                    'order_status' => 'processing',
                ]);
            $message = 'Import';
            $this->logForOrder($order, $message);
            $orderItem = OrderItem::updateOrCreate(
                ['order_id' => $order->id, 'product_name' => $row['product_name']],
                ['order_id' => $order->id,
                    'product_id' => $product ? $product->product_id : null,
                    'created_by' => Auth::user() ? Auth::user()->id : '',
                    'return_status' => (isset($row['return_status']) ? $row['return_status'] : ''),
                    'quantity' => 1,
                    'product_name' => $row['product_name'] == null ? null : Str::of($row['product_name'])->trim(),
                    'order_date' => trim($row['order_date']) == 'NULL' || trim($row['order_date']) == '' ? null : $date,
                ]);

            $stockItems = StockItem::create([
                'order_item_id' => $orderItem->id,
                'warehouse_id' => 1,
                'supplier_id' => 1,
                'product_id' => $product ? $product->product_id : null,
                'user_id' => Auth::user() ? Auth::user()->id : '',
                'quantity' => $orderItem->quantity,
            ]);

            $product = Product::where('id', $product->product_id)->first();
            if (isset($product->shipping_method)) {
                if ($product->shipping_method === 'Tuffnells') {
                    if (isset($orderItem->product_id) && $orderItem->product_id != 'null') {
                        $eventDate = Carbon::now();
                        if ($product->quantity < $singleQuantity) {
                            DeliveryItem::updateOrCreate(
                                ['order_item_id' => $orderItem->id],
                                ['order_item_id' => $orderItem->id,
                                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                                    'order_id' => $order->id,
                                    'delivery_method' => 'Tuffnells',
                                    'delivery_date' => $eventDate,
                                    'status' => 'pending',
                                    'quantity' => $product->quantity,
                                    'note' => 'The product is out of stock'
                                ]);

                        } else {

                            DeliveryItem::updateOrCreate(
                                ['order_item_id' => $orderItem->id],
                                [
                                    'company_id' => Auth::user() ? Auth::user()->company_id : '',
                                    'order_item_id' => $orderItem->id,
                                    'order_id' => $order->id,
                                    'delivery_method' => 'Tuffnells',
                                    'delivery_date' => $eventDate,
                                    'status' => 'processing'
                                ]);
                            $product->decrement('quantity', $singleQuantity);
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
                                    'note' => 'The product is out of stock Required quantity is 1'
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
                                $product->decrement('quantity', 1);
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

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 200;
    }

    public function logable($import, $saleChannel)
    {
        $request = [
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::user()->id,
            'module' => $import,
            'activity' => 'Import',
            'description' => Auth::user()->name . ' ' . $saleChannel->name . ' ' . 'import CSV'
        ];

        $this->log($request);
    }

    public function logForOrder($module, $message)
    {
        $request = [
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::user()->id,
            'module' => $module,
            'activity' => 'Import',
            'description' => Auth::user()->name . ' ' . $message . ' ' . 'import this order'
        ];

        $this->log($request);
    }


}
