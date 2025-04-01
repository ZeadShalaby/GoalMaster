<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikesController extends Controller
{

    /**
     * todo Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $check = Likes::where('user_id',auth()->user()->id)->where("tweet_id",$request->tweet_id)->get();
        if(isset($check)&& $check->count()!=0){
            foreach($check as $item)
            $tweeta = Likes::find($item->id); 
            $tweeta->delete();
            return back()->with('delete', "remove Like Success"); }
           
        $formFields = Likes::create([
            'user_id' => auth()->user()->id,
            'tweet_id' => $request->tweet_id,
        ]);

        return back()->with('success', "Like Success ."); 
    }

}
