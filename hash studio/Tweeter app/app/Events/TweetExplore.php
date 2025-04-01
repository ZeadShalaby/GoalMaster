<?php

namespace App\Events;

use App\Models\Tweets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TweetExplore
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $explore;
    public function __construct(Tweets $tweets)
    {
        //
        $this -> explore = $tweets;
        $this -> updateVieweer($this -> explore);

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

    function updateVieweer($explores){
        
        $explores -> explore = $explores -> explore + 1;
        $explores -> save();
    }
}
