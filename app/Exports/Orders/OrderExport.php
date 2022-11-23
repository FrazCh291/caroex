<?php

namespace App\Exports\Orders;

use App\Models\Feedback;
use App\Models\Order;
use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return OrderItem::with('order.channel', 'product')->orderBy('order_id', 'desc')->get();

    }

    /**
     * @param mixed $rate
     * @return array
     */
    public function map($orderItem): array
    {
        $address1 = $orderItem->order->shipping_address_1 ? $orderItem->order->shipping_address_1 : '';
        
        $add2 = $orderItem->order->shipping_address_2 ? $orderItem->order->shipping_address_2 : '';
        $add3 = $orderItem->order->shipping_address_town ? $orderItem->order->shipping_address_town : '';
        $add4 = $orderItem->order->shipping_address_postcode ? $orderItem->order->shipping_address_postcode : '';
        $add5 = $orderItem->order->shipping_country ? $orderItem->order->shipping_country : '';
        $add6 = $orderItem->order->shipping_address_postcode ? $orderItem->order->shipping_address_postcode : '';
        $address = $address1 . " " . $add2 . " " . $add3 . " " . $add4 . " " . $add5 . " " . $add6;
        return [
            $orderItem->id,
            $orderItem->order->order_number,
            $orderItem->product ? $orderItem->product->name : '',
            $orderItem->product ? $orderItem->product->sku : '',
            $orderItem->order->shipping_customer_name,
            $address ? $address : '',
            $orderItem->order->channel->name,
            $orderItem->order->order_date,
        ];
    }
    
    /**
     * @return array|string[]
     */
    public function headings(): array
    {
        return [
            'Order id',
            'Order code',
            'Product name',
            'Sku',
            'Customer',
            'Address',
            'Channel',
            'Order Date',
        ];
    }
}
