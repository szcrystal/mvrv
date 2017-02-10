<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('guest');
        $this->user = $user;
    }
    
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'email' => 'required|email|max:255',
//        ]);
//    }
    
//    public function sendResetLinkEmail()
//    {
//    	$request = Request::all();
//        
//        print_r($request);
//        //exit();
//        
//    	$rules = [
//            'email' => 'required|email|exists:users|max:255',
//        ];
//        
//        Validator::validate($request, $rules);
//        
//        $token = $request['_token'];
//    	
//        $this->user->sendPasswordResetNotification($token);
//        
//    }
}
