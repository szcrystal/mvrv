<?php

namespace App\Http\Controllers\dashboard;

use App\Admin;
use App\Article;
use App\Tag;
use App\User;
use App\Category;
use App\TagRelation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ArticleController extends Controller
{

	public function __construct(Admin $admin, Article $article, Tag $tag, User $user, Category $category, TagRelation $tagRelation)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> article = $article;
        $this->user = $user;
        $this->category = $category;
        $this->tagRelation = $tagRelation;
        
        $this->perPage = 20;
        
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
        $atclObjs = Article::orderBy('id', 'desc')->paginate($this->perPage);
        
        $cateModel = $this->category;
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.article.index', ['atclObjs'=>$atclObjs, 'cateModel'=>$cateModel, 'users'=>$this->user]);
    }
    
    public function show($id)
    {
    	$article = $this->article->find($id);
        $cates = $this->category->all();
        $users = $this->user->where('active',1)->get();
        
//        $atclTag = array();
//        $n = 0;
//        while($n < 3) {
//        	$name = 'tag_'.$n+1;
//            $atclTag[] = explode(',', $article->tag_{$n+1});
//            $n++;
//        }
//        
//        print_r($atclTag);
//        exit();
        
        //$tags = $this->getTags();
        
//        echo $article->tag_1. "aaaaa";
//        foreach($tags[0] as $tag)
//        	echo $tag-> id."<br>";
//        exit();
        
    	return view('dashboard.article.form', ['article'=>$article, 'cates'=>$cates, 'users'=>$users, 'id'=>$id, 'edit'=>1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cates = $this->category->all();
        $users = $this->user->where('active',1)->get();
    	return view('dashboard.article.form', ['cates'=>$cates, 'users'=>$users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$except = '';
    	if($request->input('edit_id') !== NULL ) {
        	$except = ','. $request->input('edit_id');
        }
        $request['movie_url'] = rtrim($request->input('movie_url'), '/');
        //exit();
        
        $rules = [
            'cate_id' => 'required',
            'title' => 'required|max:255', /* |unique:admins 注意:unique */
            'movie_site' => 'required|max:255',
            'movie_url' => 'required|max:255|unique:articles,movie_url'.$except,
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        

        if(! isset($data['del_status'])) { //checkbox
        	$data['del_status'] = 0;
        }
        
//        $data['sumbnail'] = '/images/abc.jpg';
//        $data['sumbnail_url'] = 'http://example.com';
        
//        foreach($data as $key=>$val) { //checkboxの複数選択をカンマ区切りにする
//        	if(is_array($val))
//            	$data[$key] = implode(',', $val);
//        }
        
        //tagのチェックが一つもされていない時、Undefinedになるので空をセットする
//        $n = 0;
//        while ($n < 3) {
//        	$name = 'tag_'.($n+1);
//        	if(!isset($data[$name]))
//            	$data[$name] = '';
//            
//            $n++;
//        }

        if($request->input('edit_id') !== NULL ) { //update（編集）の時
            $atclModel = $this->article->find($request->input('edit_id'));
            $status = '動画情報が更新されました！';
        }
        else { //新規追加の時
        	//$data['owner_id'] = 0;
            $data['open_status'] = 0;
            $data['open_history'] = 0;
            $data['not_newdate'] = 0;
            $data['view_count'] = 0;
            
            $status = '動画情報が追加されました！';
            
        	$atclModel = $this->article;
        }
        
        $data['movie_url'] = rtrim($data['movie_url'], '/');
        
        $atclModel->fill($data); //モデルにセット
        $atclModel->save(); //モデルからsave
        
        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
//		$admin = Article::create([
//            'admin_name' => $data['admin_name'],
//			'admin_email' => $data['admin_email'],
//			'admin_password' => bcrypt($data['admin_password']),
//		]);
        
        //$tags = $this->getTags();
        $id = $atclModel->id;
    	//return view('dashboard.article.form', ['thisClass'=>$this, 'tags'=>$tags, 'status'=>'記事が更新されました。']);
        return redirect('dashboard/articles/'.$id)->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	return redirect('dashboard/articles/'.$id);
        
//        $article = $this->articleBase->find($id);
//        
//        //$bytes = random_bytes(5);
//		//$bytes = bin2hex(mt_rand());
//        $bytes = md5(uniqid(rand(), TRUE));
//        session(['del_key' => $bytes]);
//        
//        $tags = $this->getTags();
//        
//        return view('dashboard.article.form', ['article'=>$article, 'thisClass'=>$this, 'tags'=>$tags, 'id'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) //未使用
    {
        
        $rules = [
            'cate_id' => 'required',
            'title' => 'required|max:255',
            'movie_site' => 'required|max:255',
            'movie_url' => 'required',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        if(! isset($data['open_status'])) {
        	$data['open_status'] = 0;
        }
        if(! isset($data['del_status'])) {
        	$data['del_status'] = 0;
        }
        
        
        foreach($data as $key=>$val) { //checkboxの複数選択をカンマ区切りにする
        	if(is_array($data[$key]))
            	$data[$key] = implode(',', $data[$key]);
        }
        
        $article = $this->articleBase->find($id);
        $data = $request->all(); //$data:配列
        
        $data['movie_url'] = rtrim($data['movie_url'], '/');
        
        $article->fill($data);
        $article->save();
        
        return redirect('dashboard/articles/'.$id.'/edit')->with('status', 'ページが更新されました！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $title = $this->article->find($id)->title;
        $title = substr($title, 0, 20);
        
        $atclDel = $this->article->destroy($id); //article del
        $relDel = $this->tagRelation->where('atcl_id', $id)->delete(); //tagRelation del
        
        $status = $atclDel && $relDel ? '記事「'.$title.'」が削除されました' : '記事「'.$title.'」が削除出来ませんでした';
        
        return redirect('dashboard/articles')->with('status', $status);
    }
    
    
    public function getTags() {
    	$n = 0;
        $tags = array();
        
    	while($n < 3) { //tag取得
            $tags[] = Tag::where(['open_status'=>1, 'group'=>$n+1])
                   ->orderBy('id', 'desc')
                   ->get();
            
            $n++;
        }
        
        return $tags;
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
}
