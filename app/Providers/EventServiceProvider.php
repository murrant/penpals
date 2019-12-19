<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\PenpalVerified::class => [
            \App\Listeners\VerifyPenpal::class,
            \App\Listeners\AssignInitialAddresses::class,
        ],
        \App\Events\AddressRequestApproved::class => [
            \App\Listeners\AssignAddresses::class,
        ],
        \App\Events\AddressRequestDenied::class => [
            \App\Listeners\SendDenialMessage::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
