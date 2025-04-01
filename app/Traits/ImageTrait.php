<?php

namespace App\Traits;

use App\Models\Role;


trait ImageTrait

{   
   // todo save image 
   public function saveimage($image , $folder ,$path)
   {
      $image_name = time().'.'.$image->extension();
      $images = $image->move(public_path($folder),$image_name) ;
      $destination_path = "/api/rev/images/$path/";
      $http_address = env('APP_URL');
      $path = $destination_path.$image_name;

    return $path;
   }
   

   // todo return image users I Want it
   public function returnimageusers($value , $msg = "" )
   {
      return response()->download(public_path('images/users/'.$value));
   }

   // todo return image categories I Want it
   public function returnimagecat($value , $msg = "" )
   {
      return response()->download(public_path('images/imagecat/'.$value));
   }


}





