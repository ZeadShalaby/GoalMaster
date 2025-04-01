<?php

namespace App\Listeners;

use App\Events\TweetReport;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncreaseCountShare
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(TweetReport $event): void
    {
        $this -> updateVieweer($event -> tweetReport);
    }

    function updateVieweer($tweetReports){
        
        $tweetReports -> report = $tweetReports -> report + 1;
        $tweetReports -> save();
    }
}

