<?php

namespace App\Listeners;

use App\Events\PenpalVerified;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VerifyPenpal
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
     * @param  PenpalVerified  $event
     * @return void
     */
    public function handle(PenpalVerified $event)
    {
        $penpal = $event->penpal;
        $penpal->email_verified_at = Carbon::now();
        $penpal->save();
    }
}
