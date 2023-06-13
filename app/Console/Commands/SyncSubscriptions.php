<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use http\Env\Response;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class SyncSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = Subscription::all();

        foreach ($subscriptions as $subscription) {
            // platform is Android ~ Google Play Store
            if ($subscription->platform_id == 1) {
                // returns a non-200 status code
                if ($subscription->status !== 'active') {
                    return response()->json(['status' => 'active']);
                }
            } else {// platform is IOS ~ App Store
                // returns a non-200 status code
                if ($subscription->platform_id == 'expired') {
                    return response()->json(['subscription' => 'expired']);
                } else {
                    $lastStatus = Redis::get('subs_'.$subscription->id.':'.$subscription->status);
                    if ($lastStatus === 'active' && $subscription->status !== 'expired') {
                        /// TODO: Send email report to admin
                    }
                }
            }

            Redis::set('subs_'.$subscription->id.':'.$subscription->status);
        }
    }
}
