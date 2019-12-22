<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendApprovalMessage
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
    public function handle($event)
    {
        $penpal = $event->penpal;

        Mail::send('emails.request-approved', ['note' => $event->message], function ($m) use ($penpal) {
            $m->to($penpal->email, $penpal->name)->subject('PenPals for Yang - Request Approved');
        });

        $event->request->delete();
    }
}
