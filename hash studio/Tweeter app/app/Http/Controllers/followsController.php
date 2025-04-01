<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tweets;
use App\Models\Follows;
use App\Traits\MethodTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class followsController extends Controller
{
    use MethodTrait;
    /**
     * todo Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Home'; 
        $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        $follow   = $this->notFollow(20);
        $tweets   = Tweets::with('media', 'user')->orderBy('created_at', 'desc')->get();
        return view('tweets.index', compact('tweets','trending','follow','pageTitle'));

    }

    // todo return followers of this users
    public function followers()
    {
        
        $pageTitle = 'Followers'; 
        $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        $follow   = $this->notFollow(2);
        $follows = Follows::where('following_id',Auth()->user()->id)->with('userfollowers')->get();
        return view('Auth.follow', compact('follows','follow','pageTitle','trending'));

    }

    // todo return following of this users
    public function following()
    {
        $pageTitle = 'Following'; 
        $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        $follow   = $this->notFollow(2);
        $follows = Follows::where('followers_id',Auth()->user()->id)->with('userfollowing')->get();
        return view('Auth.follow', compact('follows','follow','pageTitle','trending'));
    }


    /**
     * todo Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::find($request->userId);
        // todo add New tweet //    
        $follow = Follows::create([
            'followers_id' => auth()->user()->id,
            'following_id' => $request->userId,
        ]);
        return back()->with('success', "Followed Users : ".$user->username." , Success");
    }


    /**
     * todo Remove the specified resource from storage.
     */
    public function unfollow(Request $request)
    {
        $user = Follows::find($request->followed_id);
        //? Check if the follow relationship exists before trying to delete it.
        if ($user) {
            $user->delete();
            return back()->with('success', 'Unfollow successful.');
        }
        //? If the follow relationship does not exist, return with an error.
        return back()->with('error', 'Unfollow failed. Something Wrong.');

    }

    /**
     * todo Remove the specified resource from storage.
     */
    public function destroy(Request $request,Follows $follow)
    {

        if ($follow) {
            $follow->delete();
            return back()->with('success', 'Delete Followers Successful.');
        }
        //? If the follow relationship does not exist, return with an error.
        return back()->with('error', 'Unfollow failed. Something Wrong.');

    }
}
