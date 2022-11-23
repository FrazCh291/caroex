<?php

namespace App\Exports\Reviews;

use App\Models\Review;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReviewExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $reviews = Review::with('products','channels')->get();

        return $reviews;
    }

    /**
     * @param mixed $rate
     * @return array
     */
    public function map($review): array
    {
        if($review->product_id === null) {
            if($review->status === 'review_unapproved') {
                return [
                    $review->name,
                    $review->email,
                    $review->channels->name,
                    $review->url,
                    '',
                    $review->rating,
                    $review->comment,
                    'Unapproved',
                ];
            }
            else {
                return [
                    $review->name,
                    $review->email,
                    $review->channels->name,
                    $review->url,
                    '',
                    $review->rating,
                    $review->comment,
                    'Approved',
                ];
            }
        }
        else {
            if($review->status === 'review_unapproved') {
                return [
                    $review->name,
                    $review->email,
                    $review->channels->name,
                    $review->url,
                    $review->products->name,
                    $review->rating,
                    $review->comment,
                    'Unapproved',
                ];
            }
            else {
                return [
                    $review->name,
                    $review->email,
                    $review->channels->name,
                    $review->url,
                    $review->products->name,
                    $review->rating,
                    $review->comment,
                    'Approved',
                ];
            }
        }
    }

    /**
     * @return array|string[]
     */
    public function headings(): array
    {
        return [
            'name',
            'email',
            'Channel',
            'url',
            'Product',
            'rating',
            'comment',
            'status',
        ];
    }
}
