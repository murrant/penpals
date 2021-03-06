<?php

namespace App\Listeners;

use App\Address;
use App\Events\PenpalVerified;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignInitialAddresses
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
     * @param PenpalVerified $event
     * @return void
     */
    public function handle(PenpalVerified $event)
    {
        $event->penpal->assignAddressAllotment();
    }
}
