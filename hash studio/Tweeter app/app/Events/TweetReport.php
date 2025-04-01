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

class TweetReport
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $tweetReport;
    public function __construct(Tweets $tweets)
    {
        //
        $this -> tweetReport = $tweets;
        $this -> updateVieweer($this -> tweetReport);

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


    function updateVieweer($tweetReports){
        if($tweetReports -> report < 4){
        $tweetReports -> report = $tweetReports -> report + 1;
        $tweetReports -> save();}
        else{$tweetReports->forceDelete();}
    }
}
