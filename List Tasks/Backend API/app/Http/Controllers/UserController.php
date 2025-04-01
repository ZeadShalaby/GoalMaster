<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\Requests\TestAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Traits\validator\ValidatorTrait;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class UserController extends Controller
{
   
   use ResponseTrait , ValidatorTrait , TestAuth , ImageTrait;

   // todo Register to api natural user
   public function register(Request $request){
    // ! valditaion
    $rules = $this->rulesRegist();    
    $validator = $this->validate($request,$rules);
    if($validator !== true){return $validator;}

    // todo Register New Account //    
    $customer = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'gmail' => $request ->gmail,
        'password'  => Hash::make($request->password),
        'birthday' => $request->birthday,
        'gender' => $request->gender,
        'phone' => $request->phone,
        'avatar' => '/api/users/imageusers/user.png',
        'email_verified_at' => Carbon::now() ,
     ]);
     if($customer){return $this->returnSuccessMessage("Create Account Successfully .");}
     else{return $this->returnError('R001','Some Thing Wrong .');}

   }


    // todo Login Users
    public function login(Request $request){
        try{
        $infofield = $this->CheckField($request);
        // ! valditaion
        $rules = $this->rulesLogin($infofield['fields']);    
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // todo login  $credentials = $request->only(['gmail','password']);
        $token = Auth::guard('api')->attempt($infofield['credentials']);
        if(!$token)
        return $this->returnError('E001','information not valid.');

        $users =  Auth::guard('api')->user();
        $users -> token = $token;
        // ! return tocken
        return $this->returnData('Users',$users);
        }
        catch(Exception $ex){
            return $this->returnError($ex->getcode(),$ex->getMessage());
        }

    }


    // todo return users image
    public function imagesuser(Request $request){
        if(isset($request->avatar)){
          return $this->returnimageusers($request->avatar);}
        else {return 'null';}
    }


   // todo return users details
   public function profile(Request $request){
    $user = auth()->user();
    return $this->returnData("user",$user);
   } 


    // todo Logout Users
    public function logout(Request $request){

        $token = $request->auth_token; 
        if(isset($token)){
            try{
            // todo logout
            JWTAuth::setToken($token)->invalidate();
            }catch(TokenInvalidException $e){
                return $this->returnError("T003","Some Thing Went Wrongs");
            }
            catch(TokenExpiredException $e){
                return $this->returnError("T002","Some Thing Went Wrongs");
            }
            return $this->returnSuccessMessage('Logged Out Successfully');
        }
        else{
            return $this->returnError("T001","Some Thing Went Wrongs .");
        }
    }

}
