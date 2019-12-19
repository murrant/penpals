<?php

namespace App\Listeners;

use App\Events\AddressRequestApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignAddresses
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
     * @param object $event
     * @return void
     * @throws \App\Exceptions\MaxAddresses
     */
    public function handle(AddressRequestApproved $event)
    {
        $event->penpal->assignAddressAllotment($event->request->amount);
        $event->request->delete();
    }
}
