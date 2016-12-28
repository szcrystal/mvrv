<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Log;

class AuthForAdmin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if ($this->auth->guest()) {
            //return new RedirectResponse(url('/dashboard/login'));
            return redirect()->guest('/dashboard/login');
        }
        else if(Auth::user()->admin != 99) {
        	Auth::logout();
            return view('dashboard.login') -> withErrors('一般ユーザーのログインはできません。管理者としてログインして下さい。');
        	//return redirect('/');
        }
        
        return $next($request);
    }
}
