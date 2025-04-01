<?php
namespace App\Traits\Requests;

use App\Enums\GenderEnums;
use Illuminate\Validation\Rules\Enum;

trait TestAuth
{  

    // todo rules of login for users
    protected function rulesLogin($field){
      if($field == "email"){
      return [
        "field" => "required|exists:users,email",
        "password" => "required"
    ];}
    else{
      return [
        "field" => "required|exists:users,username",
        "password" => "required"
    ];
    }
    }
  
    
    // todo rules of users registers
    protected function rulesRegist(){
      return [
        'name' => 'required|min:4|max:20',
        'password' => 'required|min:4',
        'birthday' => 'required|date',
        'gender' => ['required', new Enum(GenderEnums::class)],
        'email' => 'required|email|unique:users,email',
    ];
    }

        // todo rules of users Edit
        protected function rulesUpdate(){
          return [
            'name' => 'required|min:4|max:20',
            'password' => 'required|min:4',
            'birthday' => 'required|date',
            'email' => 'required|email|unique:users,email',
        ];
        }
    


   // todo rules store Tasks 
   protected function rulesStoreTweet(){
    return  [
      "description" => 'required|min:4|max:250',
      // "media" => "required|mimes|image:jpg,png,gif,mp4,mov,avi,wmv|max:10240" // max size in kilobytes (10 MB)
  ];
  }


   // todo rules update Tasks 
   protected function rulesUpdateTicket(){
    return  [
      "ticketId" => 'required|exists:tickets,id',
      "title" => 'required|unique:tickets,title',
      "description" => 'required|min:4|max:250',
      "status" => 'required',
      "due_dates" => 'required|date',
      "cat_id" => 'required|exists:categories,id',
  ];
  }
}