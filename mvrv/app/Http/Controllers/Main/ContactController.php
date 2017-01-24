<?php

namespace App\Http\Controllers\Main;

use App\Article;
use App\Contact;
use App\ContactCategory;
use Mail;
//use App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
	//public $ctm;
    
	public function __construct(Contact $contact, ContactCategory $category, Article $article, Mail $mail)
    {
        //$this->middleware('auth');
        
        $this-> contact = $contact;
        $this->category = $category;
        $this->article = $article;
        $this->mail = $mail;
        
        //$this->ctm = $ctm;
       
        //$this->user = Auth::user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=0)
    {
    	$objs = $this->category->all();
        
        $cate_option = $objs->map(function ($obj) {
    		return $obj->category;
		});

        $atclObj = NULL;
        $select = '';
		if($id) {
        	$atclObj = $this->article->find($id);
            $select = '削除依頼';
        }

        return view('main.contact.index', ['cate_option'=>$cate_option, 'atclObj'=>$atclObj, 'select'=>$select]);
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
            'user_name' => 'required|max:255',
            'user_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
//            'admin_password' => 'required|min:6',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
		//$data['delete_id'] = 1;
        $contactModel = $this->contact;
        
        $contactModel->fill($data); //モデルにセット
        $contactModel->save(); //モデルからsave
        //$id = $postModel->id;
        
        if(isset($data['delete_id'])) {
        	$data['atclTitle'] = $this->article->find($data['delete_id'])->title;
        }
        
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
            $message -> from(env('ADMIN_EMAIL'), 'MovieReview')
                     -> to($data['user_email'], $data['user_name'])
                     -> subject('お問い合わせの送信が完了しました');
            //$message->attach($pathToFile);
        });
        
        //for Admin
        $data['is_user'] = 0;
        //if(! env('MAIL_CHECK', 0)) { //本番時 env('MAIL_CHECK')がfalseの時
            Mail::send('emails.contact', $data, function($message) use ($data)
            {
                $message -> from(env('ADMIN_EMAIL'), env('ADMIN_NAME'))
                         -> to(env('ADMIN_EMAIL'), env('ADMIN_NAME'))
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
