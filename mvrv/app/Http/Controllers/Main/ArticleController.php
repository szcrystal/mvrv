<?php

namespace App\Http\Controllers\Main;

use App\Article;
use App\Tag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function __construct(Article $article, Tag $tag)
    {
        //$this->middleware('auth');
        
        $this-> article = $article;
        $this-> tag = $tag;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    { //ルートで指定 middleware('auth')
    
    	$n = 0;
    	while($n < 3) { //tag取得
            $tags[] = Tag::where(['open_status'=>1, 'group'=>$n+1])
                   ->orderBy('created_at', 'id')
                   ->get();
            
            $n++;
        }
        
    	return view('main.article.new', ['article'=>$this, 'userId'=>$userId, 'tags'=>$tags]);
        //return view('home');
    }
    
    
    public function postIndex(Request $request)
    {
        //ルートで指定 middleware('auth')
        
    	$rules = [
//            'admin_name' => 'required|max:255',
//            'admin_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
//            'admin_password' => 'required|min:6',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        if(! isset($data['open_status'])) {
        	$data['open_status'] = 0;
        }
        
        $data['up_date'] = $request->input('up_year'). '-' .$request->input('up_month') . '-' . $request->input('up_day');
        
        foreach($data as $key=>$val) { //checkboxの複数選択をカンマ区切りにする
        	if(is_array($data[$key]))
            	$data[$key] = implode(',', $data[$key]);
        }

        
        $this->article->fill($data); //モデルにセット
        $this->article->save(); //モデルからsave
        
        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
//		$admin = Article::create([
//            'admin_name' => $data['admin_name'],
//			'admin_email' => $data['admin_email'],
//			'admin_password' => bcrypt($data['admin_password']),
//		]);
        
        //いずれeditに
        return view('main.article.new', ['article'=>$this, 'userId'=>$data['user_id'], 'status'=>'記事が更新されました。']);
    	
    }
    
    
    public function showSingle($postId)
    {
    	$postObj = Article::find($postId);
        
    	return view('main.article.single', ['postObj'=>$postObj]);//, ['postObj'=>$postObj]
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
