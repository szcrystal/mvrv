<?php

namespace App\Http\Controllers\dashboard;

use App\Admin;
use App\ArticleBase;
use App\Tag;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class MainController extends Controller
{
	//protected $redirectTo = 'dashboard/login';
    
	public function __construct(Admin $admin, ArticleBase $articleBase, Tag $tag)
    {
    	
        $this -> middleware('adminauth', ['except' => ['getRegister','postRegister']]);
        //$this->middleware('auth:admin', ['except' => 'getLogout']);
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> articleBase = $articleBase;
        
        // URLの生成
		//$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$adminUser = Auth::guard('admin')->user();
        return view('dashboard.index', ['name'=>$adminUser->name]);
    }
    
    
    public function getRegister () {
    	return view('dashboard.register');
    }
    
    public function postRegister(Request $request) {
        
    	//$admin = new Admin;
        
    	$rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255', /* |unique:admins 注意:unique */
            'password' => 'required|min:6',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        //$admin->fill($data); //モデルにセット
        //$admin->save(); //モデルからsave
        
        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
		$admin = Admin::create([
            'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
            //'admin' => 99,
		]);
        
        return view('dashboard.register', ['status'=>'管理者:'.$data['name'].'さんが追加されました。']);
    	
    }
    
    
    public function getLogout(Request $request) {
    	//$request->session()->pull('admin');
        Auth::guard('admin')->logout();
        return redirect('dashboard/login'); //->intended('/')
        //return view('dashboard.login');
    }
    
//    public function getArticles()
//    {
//    	$atclObjs = //Article::where('active', 1)
//               ArticleBase::orderBy('id', 'asc')
//               //->take(10)
//               ->get();
//        
//        return view('dashboard.article.article', ['atclObjs'=>$atclObjs]);
//    }
//    
//    public function getArticlesAdd()
//    {
//    	$tags = $this->getTags();
//        
//    	return view('dashboard.article.form', ['thisClass'=>$this, 'tags'=>$tags]);
//    }
    
//    public function postArticlesAdd(Request $request)
//    {
//    	$rules = [
////            'admin_name' => 'required|max:255',
////            'admin_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
////            'admin_password' => 'required|min:6',
//        ];
//        
//        $this->validate($request, $rules);
//        
//        $data = $request->all(); //requestから配列として$dataにする
//        
//        if(! isset($data['open_status'])) {
//        	$data['open_status'] = 0;
//        }
//        if(! isset($data['del_status'])) {
//        	$data['del_status'] = 0;
//        }
//        
//        
//        $data['up_date'] = $request->input('up_year'). '-' .$request->input('up_month') . '-' . $request->input('up_day');
//        
//        foreach($data as $key=>$val) { //checkboxの複数選択をカンマ区切りにする
//        	if(is_array($data[$key]))
//            	$data[$key] = implode(',', $data[$key]);
//        }
//
//        
//        $this->articleBase->fill($data); //モデルにセット
//        $this->articleBase->save(); //モデルからsave
//        
//        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
////		$admin = Article::create([
////            'admin_name' => $data['admin_name'],
////			'admin_email' => $data['admin_email'],
////			'admin_password' => bcrypt($data['admin_password']),
////		]);
//        
//        $tags = $this->getTags();
//        //いずれeditに
//    	return view('dashboard.article.form', ['thisClass'=>$this, 'tags'=>$tags, 'status'=>'記事が更新されました。']);
//        return redirect('dashboard/pages-edit/'."$id")->with('status', '固定ページが追加されました！');
//    }
    
    
    
    
    public function getTags() {
    	$n = 0;
        $tags = array();
        
    	while($n < 3) { //tag取得
            $tags[] = Tag::where(['open_status'=>1, 'group'=>$n+1])
                   ->orderBy('created_at', 'id')
                   ->get();
            
            $n++;
        }
        
        return $tags;
    }
    
    public function user()
    {
    	$value = $request->session()->get('admin.name', false);
        
        return $value;
    }
    
    
    
    
    
    public function selectBox($first, $last, $objNum=null) {
	
        if($objNum == null) {
            echo '<option value="--" selected>--</option>';
        }
        else {
            $select = ($objNum == '0000' || $objNum == '00') ? ' selected' : '';
            echo '<option value="--"' . $select .'>--</option>';
        }
        
        if($first > $last) { //逆順の時 Yearにて
            for($first; $first >= $last; $first--) {
                if(isset($objNum) && $first == $objNum)
                    echo '<option value="'.$first .'" selected>'.$first.'</option>';
                else
                    echo '<option value="'.$first .'">'.$first.'</option>';
            }
        }
        else {
            for($first; $first <= $last; $first++) {
                if(isset($objNum) && $first == $objNum)
                    echo '<option value="'.$first .'" selected>'.$first.'</option>';
                else
                    echo '<option value="'.$first .'">'.$first.'</option>';
            }
        }
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
        //
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
