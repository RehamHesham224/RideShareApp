<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\LoginNeedsVerfication;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function submit(Request $request){
        //1 validate phone number
        $request->validate([
            'phone' =>'required|numeric|min:10',
        ]);
        //2 create user
        $user=User::firstOrCreate([
            'phone'=>$request->phone
        ]);
        if(!$user){
            response()->json(['message'=>'Could not process a user with this phone number ']);
        }
        //3 send code
       $user->notify(new LoginNeedsVerfication());
        //4 response
        return response()->json(['message'=>'Text message notification sent.']);

    }
    public function verify(Request $request){
        //validate request
        $request->validate([
            'phone'=>'required|numeric|min:10',
            'login_code'=>'required|numeric|between:111111,999999',
        ]);
        //find user
        $user=User::where('phone',$request->phone)
            ->where('login_code',$request->login_code)
            ->first();
        // is code same as saved?
        //if so, return auth token
        if($user){
            $user->update([
                'login_code'=>null
            ]);
            return $user->createToken($request->login_code)->plainTextToken;
        }
        //if not,return message
        return response()->json(['message'=>'Invalid verification code.'],401);
    }

}
