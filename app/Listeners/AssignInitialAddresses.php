<?php

namespace App\Listeners;

use App\Address;
use App\Events\Verified;
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
     * @param Verified $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $penpal = $event->penpal;

        // grab x random unassigned addresses
        $addresses = Address::query()->randomAllotment()->get();

        $penpal->addresses()->saveMany($addresses);
    }
}
