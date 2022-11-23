<?php

namespace App\Exports\Orders;

use Carbon\Carbon;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filter;
    protected $lastRecord;
    protected $sum;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->filter['channel_id'] !== 'all') {
            $orders = Order::whereBetween('order_date', [Carbon::parse($this->filter['date_from'])->startOfDay(),
                Carbon::parse($this->filter['date_to'])->endOfDay()])->where('channel_id',
                $this->filter['channel_id'])->with('customer', 'channel')->get();
        }
        else {
            $orders = Order::whereBetween('order_date', [Carbon::parse($this->filter['date_from'])->startOfDay(),
                Carbon::parse($this->filter['date_to'])->endOfDay()])->with('customer', 'channel')->get();
        }

        $this->sum = $orders->sum('order_total_amount');
        $this->lastRecord = $orders[sizeOf($orders) - 1];

        return $orders;
    }

    /**
     * @param mixed $rate
     * @return array
     */
    public function map($order): array
    {
        if ($order->id == $this->lastRecord['id']) {
            return [
                [
                    $order->order_number,
                    $order->channel->name,
                    $order->customer->name,
                    $order->order_total_amount,
                    $order->order_status,
                    $order->order_date
                ],
                [
                    'Total',
                    '',
                    '',
                    $this->sum,
                    '',
                    ''
                ]

            ];
        }
        else {
            return [
                $order->order_number,
                $order->channel->name,
                $order->customer->name,
                $order->order_total_amount,
                $order->order_status,
                $order->order_date

            ];
        }
    }

    /**
     * @return array|string[]
     */
    public function headings(): array
    {
        return [
            'Order',
            'Channel',
            'Customer',
            'Total Amount',
            'Status',
            'Date',
        ];
    }
}
