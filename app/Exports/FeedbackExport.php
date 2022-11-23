<?php

namespace App\Exports;

use App\Models\Feedback;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FeedbackExport implements FromCollection, WithHeadings, WithMapping
{


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $feedback = Feedback::with('customer', 'order')->get();
        return $feedback;
    }

    /**
     * @param mixed $rate
     * @return array
     */
    public function map($feedback): array
    {
        return [
            $feedback->id,
            $feedback->name,
            $feedback->email,
            $feedback->url,
            $feedback->review,
            $feedback->ratings,
            $feedback->status
        ];
    }

    /**
     * @return array|string[]
     */
    public function headings(): array
    {
        return [
            'Order#',
            'customer',
            'name',
            'email',
            'url',
            'review',
            'ratings',
            'status',
        ];
    }
}
