<?php

namespace App\Events;

use App\Penpal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Verified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $penpal;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Penpal $penpal)
    {
        $this->penpal = $penpal;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('penpal-mgmt');
    }
}
