<?php
namespace App\Traits\Requests;

trait TestAuth
{  


    // todo rules of login for users
    protected function rulesLogin($field){
      if($field == "gmail"){
      return [
        "field" => "required|exists:users,gmail",
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
        "name" => "required|min:4|max:20",
        "username" => "required|unique:users,username",
        "password" => "required|min:8",
        "birthday" => "required",
        "gender" => "required",
        "phone" => "required|min:10|max:10"
    ];
    }
    


   // todo rules store Tasks 
   protected function rulesStoreTask(){
    return  [
      "title" => 'required|unique:tasks,title',
      "description" => 'required|min:4|max:250',
      "status" => 'required',
      "due_dates" => 'required|date',
      "cat_id" => 'required|exists:categories,id',
  ];
  }


   // todo rules update Tasks 
   protected function rulesUpdateTask(){
    return  [
      "taskId" => 'required|exists:tasks,id',
      "title" => 'required|unique:tasks,title',
      "description" => 'required|min:4|max:250',
      "status" => 'required',
      "due_dates" => 'required|date',
      "cat_id" => 'required|exists:categories,id',
  ];
  }
}