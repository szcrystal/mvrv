<?php

namespace App\Http\Controllers\Auth;

use Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function login(Request $request)
    {
    	$rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
        ];
        
        $this->validate($request, $rules); //errorなら自動で$errorが返されてリダイレクト、通過で自動で次の処理へ
        
        $data = $request->all();
        
        $remember = isset($data['remember']) ? true : false;

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
            
            $user = Auth::user();
            
            if(!$user->active) {
            	Auth::logout();
            	$error[] = 'ログインが許可されていません。';
            	return redirect() -> back() -> withErrors($error);
            }
            
            return redirect()->intended('/');
        }
        else {
        	$error[] = 'メールアドレスとパスワードを確認して下さい。';
            return redirect() -> back() -> withErrors($error);
	    }
    }
    
}
