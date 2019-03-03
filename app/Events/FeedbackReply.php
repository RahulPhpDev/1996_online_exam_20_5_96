<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FeedbackReply
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $feedbackId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($feedbackId)
    {
        // dd($feedbackId);
        $this->feedbackId = $feedbackId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [];
        // return new PrivateChannel('channel-name');
    }
}
