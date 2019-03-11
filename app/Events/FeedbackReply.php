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
    public $feedbackReply;
    public $token;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($feedbackId, $feedbackReply,$token)
    {
        // dd($feedbackId);
        $this->feedbackReply = $feedbackReply;
        $this->feedbackId = $feedbackId;
        $this->token = $token;
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
