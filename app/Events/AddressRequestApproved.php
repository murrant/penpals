<?php

namespace App\Events;

use App\AddressRequest;
use App\Penpal;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddressRequestApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $penpal;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AddressRequest $request, Penpal $penpal, $message)
    {
        $this->request = $request;
        $this->penpal = $penpal;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
