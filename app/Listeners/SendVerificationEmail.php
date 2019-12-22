<?php

namespace App\Listeners;

use App\Penpal;
use Illuminate\Auth\Events\Registered;

class SendVerificationEmail
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
     * @param  object  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        /** @var Penpal $penpal */
        $penpal = $event->user;
        $penpal->sendLoginEmail(false, 'auth.emails.registered');
    }
}
