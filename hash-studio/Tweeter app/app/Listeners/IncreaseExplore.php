<?php

namespace App\Listeners;

use App\Events\TweetExplore;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncreaseExplore
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TweetExplore $event): void
    {
        $this -> updateVieweer($event -> explore);
    }

    function updateVieweer($explores){
        
        $explores -> explore = $explores -> explore + 1;
        $explores -> save();
    }
}
