<?php

namespace App\Listeners;

use App\Events\Verified;
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
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $penpal = $event->penpal;
        $penpal->email_verified_at = Carbon::now();
        $penpal->save();
    }
}
