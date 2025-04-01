<?php

namespace App\Http\Controllers;

use App\Models\Tweets;
use App\Traits\ImageTrait;
use App\Traits\MethodTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;
use App\Traits\validator\ValidatorTrait;

class TweetsTrashController extends Controller
{
    //
    use ImageTrait , ValidatorTrait , TestAuth , ResponseTrait,MethodTrait;

     /**
     * todo restore index the specified resource from storage.
     */
    public function restoreindex()
    {
       $pageTitle = 'Trash';
       $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
       $follow   = $this->notFollow(2);
       $tweets = Tweets::where('user_id',auth()->user()->id)->onlyTrashed()->with('media', 'user')->orderBy('deleted_at', 'desc')->get();
       return view('tweets.restore',['tweets'=>$tweets,'trending'=>$trending,'follow'=>$follow,'pageTitle'=>$pageTitle]);
      }

     /**
     * todo  restore the specified resource from storage.
     */
    public function restore(Request $request)
    {
       $tweet = Tweets::withTrashed()->find($request->tweet);
       if(!isset($tweet)){return back()->with('error','Some thing Wrong');}
       $tweet->restore();
       return back()->with('success',"Restore Tweets Successfully .");
      
    }


    /**
     * todo Remove the specified resource from storage.
     * !  Delete Forever
     */
    public function destroyForce(Request $request)
    {
        //
        $tweet = Tweets::withTrashed()->find($request->tweet);
        if(!isset($tweet)){return back()->with('error','Some thing Wrong');}
        $tweet->forceDelete();
        return back()->with('success',"delete tweet Succcessfully");
    }

}
