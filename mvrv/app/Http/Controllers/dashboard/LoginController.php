<?php

namespace App\Http\Controllers\dashboard;

use App\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

use Auth;

use Closure;

class LoginController extends Controller
{
    //protected $redirectTo = 'dashboard'; //Login後のリダイレクト先 MiddleWare内のメソッドにも指定あり
    
    public function __construct(Admin $admin)
    {
        //$this->middleware('adminGuest', ['except' => 'getLogout']);
        //$this->middleware('auth:admin', ['except' => 'index']);
        
        $this->admin = $admin;
    }
    
    public function index()
    {
//    	echo session('beforePath');
//        exit();
    	return view('dashboard.login');
    }
    
    public function postLogin(Request $request)
    {
    	$rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ];
        
        //$this->validate($request, $rules); //errorなら自動で$errorが返されてリダイレクト、通過で自動で次の処理へ
        
        $data = $request->all();
        
        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'] ])) {
            // 認証に成功した
            return redirect()->intended('dashboard');
        }
        else {
        	$error[] = 'メールアドレスとパスワードを確認して下さい。';
            //return redirect('dashboard/login') -> withErrors('メールアドレスとパスワードを確認して下さい。');
            return redirect() -> back() -> withErrors($error);
	    }
    }
    
//    public function postLogin(Request $request)
//    {
//    	$rules = [
//            'admin_email' => 'required|email|max:255',
//            'admin_password' => 'required|min:6',
//        ];
//        
//        //$this->validate($request, $rules); //errorなら自動で$errorが返されてリダイレクト、通過で自動で次の処理へ
//        
//        
//        $data = $request->all();
//        
//        $oneObj = Admin::where('admin_email', $data['admin_email']) -> first();
//        
////        $sesArr = array(
////        	'id' => $oneObj->id,
////        	'name' => $oneObj->admin_name,
////            'email' =>$oneObj->admin_email,
////        );
////        $request->session()->put('admin', $sesArr);
//
//        //$request->session()->push('admin.name', 'developers');
//        
//        //print_r($request->session()->all());
//        
//        
//        if($oneObj && Hash::check($data['admin_password'], $oneObj->admin_password)) { //
//        	$sesArr = array(
//                'id' => $oneObj->id,
//                'name' => $oneObj->admin_name,
//                'email' =>$oneObj->admin_email,
//            );
//            $request->session()->put('admin', $sesArr);
//        	
//            if(isset($data['beforePath']))
//            	return redirect($data['beforePath']);
//            else
//	        	return redirect('dashboard')/*->intended('dashboard')*/; //intended: redirectがうまくいかなかった時
//        }
//        else {
//        	$error[] = 'メールアドレスとパスワードを確認して下さい。';
//            //$error[] = 'hogehoge';
//            //return redirect('dashboard/login') -> withErrors('メールアドレスとパスワードを確認して下さい。');
//            return redirect() -> back() -> withErrors($error);
//	    }
//    
//    }
    
    
    
    
    
}
