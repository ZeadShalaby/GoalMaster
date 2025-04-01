<?php

namespace App\Listeners;

use App\Events\TweetVieweer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncreaseCounter
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
    public function handle(TweetVieweer $event): void
    {
        //
        $this -> updateVieweer($event -> views);
    }

    function updateVieweer($views){
        
        $views -> view = $views -> view + 1;
        $views -> save();
    }
}
