<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
//use Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
//    protected $auth;
//    
//    public function __construct(Guard $auth)
//    {
//        $this->auth = $auth;
//    }
    
    public function handle($request, Closure $next, $guard = null)
    {
    	if (Auth::guard('admin')->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('dashboard/login');
            }
        }
        
        
        
    	//$guard = 'admin';
        
//    	if (Auth::guard($guard)->check()) {
//            return redirect('/');
//        }
//    	if (!$request->session()->has('admin')) {
//            //return new RedirectResponse(url('/dashboard/login'));
//            //return redirect();
//            //return redirect()->intended();
//            return redirect('/dashboard/login')->with('beforePath', $request->path());
//        }
////        else {
////        	//Auth::logout();
////            //return view('dashboard.login') -> withErrors('管理者としてログインして下さい。');
////        	return redirect('/dashboard/login');
////        }
//        
        return $next($request);
    }
}
