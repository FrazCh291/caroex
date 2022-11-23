<?php

namespace App\Exports;

use App\Models\Delivery;
use App\Models\DeliveryItem;
use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Inspectioncsv implements WithHeadings, WithMapping ,FromCollection
{
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $deliveryInspection = DeliveryItem::where('delivery_id', $this->filter)->where('status', '!=', 'pending')
         ->where('status', '!=', 'cancelled')->where('delivery_id', $this->filter)->with(['delivery','order.customer'])->get();
        return $deliveryInspection;
    }

    public function map($deliveryInspection): array
    {
            return [
                [
                    $deliveryInspection->id,
                    $deliveryInspection->company->name,
                    $deliveryInspection->order->order_number,
                    $deliveryInspection->order->product->name,
                    $deliveryInspection->delivery_method,
                    $deliveryInspection->delivery_type,
                    $deliveryInspection->delivery_date,
                    $deliveryInspection->is_collected,
                    $deliveryInspection->collection_failed_reason,
                    $deliveryInspection->note,
                    $deliveryInspection->status,
                    $deliveryInspection->deleted_at,
                    $deliveryInspection->created_at,
                    $deliveryInspection->updated_at
                ]

            ];
    }

    /**
     * @return array|string[]
     */
    public function headings(): array
    {
        return [
            'id ',
            'company ',
            'order_number',
            'product_name',
            'delivery_method',
            'delivery_type',
            'delivery_date',
            'is_collected',
            'collection_failed_reason',
            'note',
            'status',
            'deleted_at',
            'created_at',
            'updated_at',
        ];
    }
}
