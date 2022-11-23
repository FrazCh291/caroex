<?php

namespace App\Services\Feedback;

use App\Models\Feedback;

class FeedbackService
{
    public function storeFeedback($customer, $order,$salesChannel)
    {
        $feedback = new Feedback();
        $feedback->customer_id = $customer->id;
        $feedback->order_id = $order->id;
        $feedback->channel_id = $salesChannel->id;
        $feedback->status = 'pending';
        $feedback->save();

        return $feedback;
    }
}

