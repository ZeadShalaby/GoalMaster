<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Likes;
use App\Models\Shares;
use App\Models\Tweets;
use App\Models\Follows;
use App\Models\Favourite;
use App\Traits\ImageTrait;
use App\Events\TweetReport;
use App\Traits\MethodTrait;
use App\Events\TweetExplore;
use App\Events\TweetVieweer;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Events\TweetCountShare;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;
use App\Traits\validator\ValidatorTrait;

class TweetsController extends Controller
{
    //
    use ImageTrait , ValidatorTrait , TestAuth , ResponseTrait , MethodTrait;

    /**
     * todo Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Home';
        $trending  = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        $follow    = $this->notFollow(2);
        $shares    = Shares::with('tweets', 'user')->orderBy('created_at', 'desc')->get();
        $tweets    = Tweets::with('media', 'user')->orderBy('created_at', 'desc')->get();
        return view('tweets.index', compact('tweets','trending','follow', 'shares','pageTitle'));
    }


    /**
     * todo Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ! valditaion
        $rules = $this->rulesStoreTweet();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return back()->with('error', $validator);}
        // todo check type media
        $path  = $this->checkTypeMedia($request);
        // todo create tweet with || ^ media
        $tweet = $this->tweetStore($request->description , $path);
 
        if($tweet){return back()->with('success', "create Tweets success");}
        else{back()->with('error','Some Thing Wrong .');}
    }


    // todo check type of media
    public function checkTypeMedia($request)
    {
        if ($request->hasFile('video')) {
            return $this->saveimage($request->video , 'images/tweets/video/' ); 
        } elseif ($request->hasFile('path'))  {
            return $this->saveimage($request->path , 'images/tweets/img/' ); 
        }
    }


    // todo create tweet with || ^ media
    public function tweetStore($description , $path)
    {
       //? add New tweet   
       $tweet = Tweets::create([
           'description' => $description,
           'user_id' => auth()->user()->id,
       ]);
       //? create in media
       if( $path != null)
       $this->Addmedia($tweet,$path);
       return $tweet;
    }


    /**
     * todo Display the specified resource.
     */
    public function show(Request $request , Tweets $tweet)
    {
        //
        $pageTitle = 'Show Tweets';
        $tweet->load('media_one'); 
        $follow = $this->notFollow(2); 
        event(new TweetVieweer($tweet)); 
        $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        return view('tweets.show',['tweet'=>$tweet,'trending'=>$trending,'follow'=>$follow , 'pageTitle'=>$pageTitle]);

    }

    
    /**
     * todo Display the specified resource.
     */
    public function explore(Request $request , Tweets $tweet)
    {
        //
        event(new TweetExplore($tweet));
        return back()->with('explore', "Explore Tweet Success ."); 
    }


    // todo return all tweets with hight explore first
    public function exploreall()
    {
        $pageTitle = 'Explore';
        $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        $follow   = $this->notFollow(2);
        $tweets   = Tweets::with('media', 'user')->orderBy('explore', 'desc')->get();
        return view('tweets.index', compact('tweets','trending','follow','pageTitle'));

    }

     /**
     * todo Display the specified resource.
     */
    public function share(Request $request , Tweets $tweet)
    {
        $pageTitle = 'Re-tweet';
        $tweet->load('media_one'); 
        $follow = $this->notFollow(2); 
        $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        return view('tweets.retweet',['tweet'=>$tweet,'trending'=>$trending,'follow'=>$follow , 'pageTitle'=>$pageTitle]);
    }

    /**
     * todo Display the specified resource.
     */
    public function shareStore(Request $request,Tweets $tweet )
    {
        if(isset($request->description)&& $request->description!= null){
        // ! valditaion
        $rules = $this->rulesStoreTweet();
        $validator = $this->validate($request,$rules);
        if($validator !== true){return back()->with('error', $validator);}
        }
        Shares::create([
            'description' => $request->description,
            'tweet_id'     => $tweet->id,
            'user_id'     => auth()->user()->id
        ]);
        return redirect()->route('tweets.index')->with('success','share tweets successfully');
    }

     /**
     * todo Display the specified resource.
     */
    public function report(Request $request , Tweets $tweet)
    {
        //
        event(new TweetReport($tweet));
        return back()->with('error', "Report Tweet Success ."); 

    }


    /**
     * todo Show the form for editing the specified resource.
     */
    public function edit(Request $request,Tweets $tweet)
    {
        //
        $pageTitle = 'Edit Tweets';
        $tweet->load('media_one'); 
        $follow = $this->notFollow(2); 
        $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        return view('tweets.edit',['tweet'=>$tweet,'trending'=>$trending,'follow'=>$follow , 'pageTitle'=>$pageTitle]);

    }

    /**
     * todo Update the specified resource in storage.
     */
    public function update(Request $request, Tweets $tweet)
    {
        //
        // ! valditaion
        $rules = $this->rulesStoreTweet();$path = null; 
        $validator = $this->validate($request,$rules);
        if($validator !== true){return back()->with('error', $validator);}

        $tweet->update([
            'description'=>$request->description,
        ]);

        return redirect()->route('tweets.show', $tweet->id)->with('success', 'Tweet updated successfully!');
    }


    /**
     * todo Remove the specified resource from storage.
     * ! Soft Delete
     */
    public function destroy(Request $request,Tweets $tweet)
    {
        //
        if(!isset($tweet)){return back()->with('error','Some thing Wrong');}
        $tweet->delete();
        return back()->with('success',"delete tweet Succcessfully");
    }                                     



    // todo autocompleteSearch by description
    public function autocompleteSearch(Request $request)
    {
        $pageTitle = 'Home';
        $filterResult = Tweets::select('id','description','explore')->where('description', 'LIKE', '%'.$request->get('query'). '%')
        ->orderBy('explore', 'desc')->take(2)->get();
        $follow   = $this->notFollow(2);
        $tweets   = Tweets::with('media', 'user')->orderBy('created_at', 'desc')->get();
        return view('tweets.index',['tweets' => $tweets,'trending' => $filterResult,'follow' => $follow,'pageTitle'=>$pageTitle]);
    
    } 
}


