<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
    	$confirm_key = openssl_random_pseudo_bytes(32);
        $data['confirm_token'] = bin2hex($confirm_key);
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirm_token' => $data['confirm_token'],
            'active' => 0,
        ]);
        
        $data['user_id'] = $user->id;
        
    	$this->sendRegistMail($data);
        
//        $status = 'ユーザー登録確認メールを送信しました。';
//        
//        return redirect('register')->with('status', $status);
        //return view('dashboard.article.form', ['cates'=>$cates, 'users'=>$users]);
    }
    
    public function registerConfirm($key, Request $request)
    {
    	if(!isset($key)) {
        	abort(404);
        }
    	
        $user = User::find($request->input('uid'));
        
        if (! $user || $key != $user->confirm_token) {
            $errorStatus = 'ユーザーを有効化することが出来ませんでした。';
            if($user)
	            $user->delete();
            
            return redirect('register')->with('errorStatus', $errorStatus);
        }

		$user->active = 1;
        $user->confirm_token = '';
        $user->save();
        
        $status = '新規ユーザー登録が完了しました。ログインしてください。';
        return redirect('login')->with('status', $status);
    }
    
    private function sendRegistMail($data)
    {
        Mail::send('emails.register', $data, function($message) use ($data) //引数について　http://readouble.com/laravel/5/1/ja/mail.html
        {
            //$dataは連想配列としてviewに渡され、その配列のkey名を変数としてview内で取得出来る
            $message -> from(env('ADMIN_EMAIL'), 'MovieReview')
                     -> to($data['email'], $data['name'])
                     -> subject('ユーザーの仮登録が完了しました');
            //$message->attach($pathToFile);
        });
        
        //$rel = $mail->failures();
    }
    
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
 
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
 
        $this->create($request->all());
 
        $status = 'ユーザー登録用確認メールを送信しました。';
 
        return redirect('register')->with('status', $status);
    }
    

}
