<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class AuthController extends Controller
{

   public function register(Request  $request){

       $validator = Validator::make($request->all(),[
          'name'=>'required',
          'phone'=>'required|unique:users',
       ]);

       if ($validator->fails())
       {
           return response(['errors'=>$validator->errors()->all()], 422);
       }

       $user  = new User();
       $user->name = $request->get('name');
       $user->email = $request->get('email');
       $user->phone = $request->get('phone');
       if(isset($request->fcm_token)){
           $user->fcm_token = $request->fcm_token;
       }
       $user->save();

       $accessToken = $user->createToken('authToken')->accessToken;
       return response(['user'=>$user,'token'=>$accessToken]);

   }


   public function login(Request $request){

       //sleep(3);

        $data = $request->validate([
           'phone'=>'required',
       ]);


     $user = User::where('phone', $request->phone)->first();
                        
     if (!$user) {
            return response(["message" => "User not found."], 404);
        }
        
      Auth::login($user);
      
      $accessToken = $user->createToken('authToken')->accessToken;
      
       if(isset($request->fcm_token)){
           $user = User::find(auth()->user()->id);
           $user->fcm_token = $request->fcm_token;
           $user->save();
       }
       return response(['user'=> auth()->user(),'token'=>$accessToken],200);
   }


   public function updateProfile(Request $request){


       $user =  auth()->user();

       if ($request->has('photo')) {
        $the_file_path = uploadImage('assets/admin/uploads', $request->photo);
        $user->photo = $the_file_path;
     }

       if($user->save()){
           return response(['message'=>['Your setting has been changed'],'user'=>$user]);
       }else{
           return response(['errors'=>['There is something wrong']],402);
       }
   }

   public function mobileVerified(Request $request)
   {

       $user = auth()->user();
       if(!$user){
       return response(['errors' => ['Unauthenticated']], 402);

       }

       $user->is_verified = 1;

       if ($user->save()) {
           return response(['message' => ['Your setting has been changed'], 'user' => $user], 200);
       } else {
           return response(['errors' => ['There is something wrong']], 402);
       }
   }

   public function language(Request $request)
   {
       $request->validate([
           'lang' => 'required'
       ]);
       $user = auth()->user();
       $user->locale = $request->lang;
       if ($user->save()) {
           return response(['message' => ['Your Lang has been changed']], 200);
       } else {
           return response(['errors' => ['There is something wrong']], 402);
       }
   }

   public function locale()
   {
       $user = auth()->user();

           return response([ 'data' => $user->locale], 200);

   }

       public function notifications()
   {
       $user = auth()->user();
       $notifications = Notification::where('user_id',$user->id)->orderBy('id','DESC')->get();
           return response([ 'data' => $notifications], 200);

   }

}

