<?php

namespace App\Http\Middleware;

use App\User;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
    
        if (Auth::guard($guard)->check()) {
            return redirect('/');
        }
        

        if($request->has('userLogin') && $request->userLogin) { //ログイン時のみ activeかどうか
            $email = $request->input('email');
            $user = User::where(['email'=>$email])->first();
            
            if(! $user->active) {
                //return redirect('login')->with('status', 'ログインが許可されていません');
                $error = 'ログインが許可されていません';
                return redirect() -> back() -> withErrors($error);
            }
        }

        return $next($request);
    }
}
