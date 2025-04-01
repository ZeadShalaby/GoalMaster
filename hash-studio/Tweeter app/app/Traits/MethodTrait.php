<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\User;


trait MethodTrait

{   

/**
     * todo Display the specified resource.
     */
    public function notFollow($num)
    {
        $followingIds = auth()->user()->following->pluck('id')->toArray();
        $usersNotFollowing = User::whereNotIn('id', $followingIds)->where('id', '!=', auth()->user()->id)->with('media_one')->take($num)->get();
        return $usersNotFollowing;
    }

     // todo check login with username or email //
     protected function CheckField($request)
     {
     
         // ?login with phone number or email
         $field = filter_var($request->input('field'),FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
         $credentials = array(
            $field => $request->get('field'),
            'password' => $request->get('password')
        ); 
        return array(
            'credentials' => $credentials ,
            'fields' => $field 
        );
                  
     }
     
     // todo add new media 
     protected function Addmedia($info , $media)
     {
         $info->media()->create([
             'media' => $media
           ]);
     }


}