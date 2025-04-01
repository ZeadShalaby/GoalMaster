<?php

namespace App\Traits;

use App\Models\Role;


trait ImageTrait

{   
   // todo save image 
   public function saveimage($image , $folder )
   {
      $image_name = time().'.'.$image->extension();
      $images = $image->move(public_path($folder),$image_name) ;
      $path = $folder.$image_name;

      return $path;
   }
   

   // todo return image users I Want it
   public function returnimageusers($value , $msg = "" )
   {
      return response()->download(public_path('images/users/'.$value));
   }

   // todo return image categories I Want it
   public function returnimagetweet($value , $msg = "" )
   {
      return response()->download(public_path('images/tweets/'.$value));
   }

}





