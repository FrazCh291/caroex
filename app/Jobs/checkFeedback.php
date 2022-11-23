<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class checkFeedback implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $repeatJob;

    /**
     * checkFeedback constructor.
     * @param bool $repeatJob
     */
    public function __construct($repeatJob = false)
    {
        $this->repeatJob = $repeatJob;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $createdAt = 5;
        $resendAt = 5;
        $feedbacks = Feedback::where('status', 'pending')->get();

        foreach ($feedbacks as $feedback) {
            if (!$feedback->rating && !$feedback->review) {
                if ((Carbon::parse($feedback->created_at)->addDays($createdAt) < now() && !$feedback->last_sent_at) || (Carbon::parse($feedback->last_sent_at)->addDays($resendAt) < now())) {
                    dispatch(new SendEmailJob($feedback->customer, $feedback->order));
                    $feedback->last_sent_at = now();
                    $feedback->update();
                }
            }
        }

        if ($this->repeatJob) {
            dispatch(new checkFeedback(true))->delay(now()->addHours(6));
        }
    }
}
