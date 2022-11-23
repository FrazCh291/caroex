<?php

namespace App\Jobs;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use App\Services\RenewSubscription;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ActivateSubscription
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscriptions = Subscription::where('end_at', '>=', now())->get();

        foreach ($subscriptions as $subscription) {
            if ($subscription->auto_renew == 1) {
                $renewPackageSub = new RenewSubscription();
                $renewPackageSub->renewPackageSubscription($subscription->id);
            } else {
                Subscription::where('id', $subscription->id)->update(['is_active' => 0]);
            }
        }
    }
}
