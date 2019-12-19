<?php

namespace App\Listeners;

use App\Events\AddressRequestDenied;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendDenialMessage
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
    public function handle(AddressRequestDenied $event)
    {
        $penpal = $event->penpal;
        Mail::send('emails.request-denied', ['message' => $event->message], function ($m) use ($penpal) {
            $m->to($penpal->email)->subject('PenPals for Yang - Request Denied');
        });
        $event->request->delete();
    }
}
