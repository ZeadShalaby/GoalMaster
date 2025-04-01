<?php

namespace App\Http\Controllers;

use App\Models\Tweets;
use App\Models\Favourite;
use App\Traits\MethodTrait;
use Illuminate\Http\Request;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;
use App\Traits\validator\ValidatorTrait;
use App\Http\Controllers\TweetsController;

class FavouritesController extends Controller
{

    use ValidatorTrait , TestAuth ,MethodTrait;
    /**
     * todo Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageTitle = 'Favourite';
        $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        $tweets = Favourite::where('user_id',auth()->user()->id)->orderBy('created_at', 'desc')->get();
        $follow = $this->notFollow(2); 
        return view('tweets.fav',['tweets' => $tweets,'trending'=>$trending,'follow'=>$follow,'pageTitle'=>$pageTitle ]);
    }

    /**
     * todo Store a newly created resource in storage.& delete
     */
    public function store(Request $request)
    {
        $check = Favourite::where('user_id',auth()->user()->id)->where("tweet_id",$request->tweet_id)->get();
        if(isset($check)&& $check->count()!=0){
            foreach($check as $item)
            $tweeta = Favourite::find($item->id); 
            $tweeta->delete();
            return back()->with('delete', "remove Fav Tweet Success"); }
            
        $formFields = Favourite::create([
            'user_id' => auth()->user()->id,
            'tweet_id' => $request->tweet_id,
        ]);

        return back()->with('success', "Save Tweet Success ."); 

    }

    /**
     * todo Display the specified resource.profile
     */
    public function show(Request $request,Follows $follow )
    {
        $pageTitle = 'Favourite';
        $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        $tweets = Favourite::where('user_id',$request->id)->orderBy('created_at', 'desc')->get();
        $follow = $this->notFollow(2); 
        return view('tweets.fav',['tweets' => $tweets,'trending'=>$trending,'follow'=>$follow,'pageTitle'=>$pageTitle ]);
    }


}
