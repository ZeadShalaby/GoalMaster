<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use App\Models\Tweets;
use App\Models\Follows;
use App\Models\Favourite;
use App\Traits\ImageTrait;
use App\Traits\MethodTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\validator\ValidatorTrait;


class UserController extends Controller
{
    use ImageTrait , ValidatorTrait , TestAuth , ResponseTrait,MethodTrait;

   // todo profile page
   public function index()
   {

    $pageTitle = 'Profile';
    $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
    $tweets    = Tweets::where('user_id',auth()->user()->id)->with('media', 'user')->orderBy('created_at', 'desc')->get();
    $follow = $this->notFollow(2); 
    return view('Auth.index',['tweets' => $tweets,'trending'=>$trending,'follow'=>$follow,'pageTitle'=>$pageTitle ]);
} 
   
 

    // todo login page
   function loginindex()
    {
        return view('Auth.login');
    }

    
    // todo Login Users
    public function login(Request $request){
        try{
        $infofield = $this->CheckField($request);
        // ! valditaion
        $rules = $this->rulesLogin($infofield['fields']);    
        $validator = $this->validate($request,$rules);
        if($validator !== true){return back()->with('error', $validator);}

        $auth = Auth::attempt($infofield['credentials']);
        if(!$auth)
        return back()->with('error', "information not valid.");
        return redirect('/tweets');
         }
        catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    
    // todo register page
    function registerIndex()
    {
        return view('Auth.register');
    }

    // todo add new account
    public function register(Request $request){
        // ! valditaion
        $rules = $this->rulesRegist();    
        $validator = $this->validate($request,$rules);
        if($validator !== true){return back()->with('error', $validator);}
       
        // todo Register New Account //    
        $customer = User::create([
            'name'     => $request->name,
            'username' => Str::slug($request->name) . '_' . strtoupper(Str::random(3)),
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
            'gender'   => strtolower($request->gender),
        ]);
        $this->Addmedia($customer , "/images/users/users.png");
         
        if($customer){
            return redirect('/users/login')->with('status', "Welcome : ".$customer->username);}
            else{return back()->with('error', "Some Thing Wrong .");}
    }
    

    
    /**
     * todo Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        $pageTitle = "Edit-profile";
        $trending = Tweets::select('description','explore','id')->with('media', 'user')->orderBy('explore', 'desc')->take(3)->get();
        $follow = $this->notFollow(2); 
        $user->load('media_one');
        return view('Auth.edit',['users'=>$user,'pageTitle'=>$pageTitle,'trending'=>$trending,'follow'=>$follow]);
    }

      // todo profile page
   public function update(Request $request,User $user)
   {
        // ! valditaion
        $rules = $this->rulesUpdate();    
        $validator = $this->validate($request,$rules);
        if($validator !== true){return back()->with('error', $validator);}
       
        // todo Register New Account //    
        $customer = $user->update([
            'name'     => $request->name,
            'username' => Str::slug($request->name) . '_' . strtoupper(Str::random(3)),
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
        ]);

        if($customer){
            return back()->with('success', "change info : ".$user->username." , success" );}
            else{return back()->with('error', "Some Thing Wrong .");}

   } 


    // todo change image of users 
    public function changeimg(Request $request)
    {
        //? Validate the request if needed
        $request->validate(['media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', ]);
        //? Get the user's media
        $user_media = Media::where('mediaable_type', 'User')->where('mediaable_id', auth()->user()->id)->first(); 
        if ($request->hasFile('media')) {
            //? Save the new image
            $path = $this->saveimage($request->file('media'), 'images/users/');
            //? Update the media record
            $user_media->update(['media' => $path]);
            return back()->with('success', "Photo changed successfully.");
        } else {
            return back()->with('error', "No image file selected.");
        }
    }
    


    /**
     * todo Remove the specified resource from storage.
     */
    public function destroy(Request $request ,User $user)
    {
        // todo delete my account
        $user->delete();
        return redirect('/');  
    }
    
    // todo logout in account
    function logout()
    {
        Auth::logout();
        return redirect('/');
    }
  

}
