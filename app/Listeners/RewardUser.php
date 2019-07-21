<?php

namespace App\Listeners;
use Illuminate\Support\Facades\Log;
use App\Events\UserReferred;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\wallet;
class RewardUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserReferred  $event
     * @return void
     */
    public function handle(UserReferred $event)
    {
        $referral = \App\ReferralLink::find($event->referralId);
        if (!is_null($referral)) {
            \App\ReferralRelationship::create(['referral_link_id' => $referral->id, 'user_id' => $event->user->id]);

            // Example...
            if ($referral->program->name === 'Sign-up Bonus') {
                // User who was sharing link
                $provider = $referral->user;
                //$provider->wallet
                Log::info($provider);
                Log::info($provider->id);
                $wallet = wallet::find($provider->wallet->id);
                $wallet->balance = $wallet->balance + 100;
                $wallet->save();
                // User who used the link
                $user = $event->user;
                $user->addCredits(20);
                Log::info($user);
                Log::info($user->id);
                //$wallet = wallet::find($user->wallet->id);
                $wallet = new wallet;
                $wallet->user_id = $user->id;
                $wallet->balance = 50;
                $wallet->save();
            }

        }
    }
}
