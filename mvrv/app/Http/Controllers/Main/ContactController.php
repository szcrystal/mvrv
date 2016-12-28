<?php

namespace App\Http\Controllers\Main;

//use App\ArticleBase;
//use App\ArticlePost;
//use App\Tag;
//use Auth;
use App\Contact;
use App\ContactCategory;
use Mail;
//use App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
	//public $ctm;
    
	public function __construct(Contact $contact, ContactCategory $category, Mail $mail)
    {
        //$this->middleware('auth');
        
        $this-> contact = $contact;
        $this->category = $category;
        $this->mail = $mail;
        
        //$this->ctm = $ctm;
       
        //$this->user = Auth::user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$objs = $this->category->all();
        
        $cate_option = $objs->map(function ($obj) {
    		return $obj->category;
		});
//        foreach($objs as $obj) {
//        	$cate_option[] = $obj->category;
//        }

        return view('main.contact.index', ['cate_option'=>$cate_option]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
//            'admin_name' => 'required|max:255',
//            'admin_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
//            'admin_password' => 'required|min:6',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする

        $contactModel = $this->contact;
        
        $contactModel->fill($data); //モデルにセット
        $contactModel->save(); //モデルからsave
        //$id = $postModel->id;
        
        $this->sendMail($data);
        //$this->fakeMail($data);
        

        return view('main.contact.done')->with('status', '送信されました！');
        //return redirect('mypage/'.$id.'/edit')->with('status', '記事が追加されました！');
        
    }
    
    private function sendMail($data)
    {
    	$data['is_user'] = 1;
        Mail::send('emails.contact', $data, function($message) use ($data) //引数について　http://readouble.com/laravel/5/1/ja/mail.html
        {
            //$dataは連想配列としてviewに渡され、その配列のkey名を変数としてview内で取得出来る
            $message -> from('bonjour@frank.fam.cx', 'MovieReview')
                     -> to($data['email'], $data['name'])
                     -> subject('お問い合わせ送信完了しました');
            //$message->attach($pathToFile);
        });
        
        //for Admin
        $data['is_user'] = 0;
        //if(! env('MAIL_CHECK', 0)) { //本番時 env('MAIL_CHECK')がfalseの時
            Mail::send('emails.contact', $data, function($message) use ($data)
            {
                $message -> from('bonjour@frank.fam.cx', 'MovieReview')
                         -> to('opal@frank.fam.cx', 'MovieReview 運営者')
                         -> subject('お問い合わせがありました - MovieReview -');
            });
    }
    
    private function fakeMail($data)
    {
    	Mail::fake();

        // 注文コードの実行…

        Mail::assertSent($this::store(), function ($mail) use ($data) {
            return $mail->name === $data['name'];
        });

        // メッセージが指定したユーザに届いたことをアサート
        Mail::assertSentTo([$data['email']], $this::store());

        // Mailableが送られなかったことをアサート
        Mail::assertNotSent($this::store());
    }
    
    public function aaa()
    {
    	//$this->aaa = "aaa";
    	return "aaa";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
