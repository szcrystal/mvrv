<?php

namespace App\Http\Controllers\MyPage;

use App\Article;
use App\Tag;
use App\TagRelation;
use App\Category;
use Auth;
use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    
	public function __construct(Article $article, Tag $tag, TagRelation $tagRelation, Category $category)
    {
        $this->middleware('auth');
        
        $this-> article = $article;
        $this-> category = $category;
        $this-> tag = $tag;
        $this->tagRelation = $tagRelation;
        
        //$this->user = Auth::user();
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$user = Auth::user();
        
        $posts = Article::where(['owner_id'=>$user->id])
                   ->orderBy('created_at', 'desc')
                   ->get();
        
        $atcls = Article::where(['owner_id'=>0, 'del_status'=>0])
            	->orderBy('id', 'desc')
                ->get();
        
        $closeCount = $posts->where('open_status', 0)->count();
        
        $cateModel = $this->category;
        
        return view('mypage.index', ['posts'=>$posts, 'user'=>$user, 'atcls'=>$atcls, 'cateModel'=>$cateModel, 'closeCount'=>$closeCount]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($atclId)
    {
    	$atcl = Article::find($atclId);
        $userId = Auth::user()->id;
        $cate = Category::find($atcl->cate_id);
        
        //Tagの取得
        $n = 0;
        while($n < 3) {
            $str = 'tag_'. ($n+1);
            $tagIds = array();
            $tagIds = explode(',', $atcl->{$str});
            
            $tags[$n] = $this->tag->find($tagIds);
            
            $n++;
        }
        
        return view('mypage.create', ['atcl'=> $atcl, 'userId'=>$userId, 'cate'=>$cate, 'tags'=>$tags]); //, ['post'=>$post, 'atcl'=>$atcl]
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$baseId = $request->input('base_id');
    	$atcl = Article::find($baseId);
        $userId = Auth::user()->id;
        
    	if($atcl->owner_id) { //オーナーが先に決まった時
        	//return redirect('mypage/error')->with('owner_status', 1);
            return view('mypage.error', ['owner_status'=>1, 'atcl'=>$atcl]);
        	
    	}
        else { //オーナーが決まっていなければowner_idをセットして継続
            $atcl->owner_id = $userId;
        	$atcl->save();
        
            $rules = [
    //            'admin_name' => 'required|max:255',
    //            'admin_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
    //            'admin_password' => 'required|min:6',
            ];
            
            $this->validate($request, $rules);
            
            $data = $request->all(); //requestから配列として$dataにする
            
            if(isset($data['keep'])) {
                $data['open_status'] = 0;
            }
            if(isset($data['open'])) {
                $data['open_status'] = 1;
                $data['open_date'] = date('Y-m-d H:i:s', time());
            }
            
            
    		//if(str_contains($data['tag_1'], ' ')) {
            $tag_1 = explode(' ', $data['tag_1']);
            
            foreach($tag_1 as $tag) {
            	$obj = $this->tag->where('name', $tag)->first();
            
                //Tagsにセット
                if(!isset($obj)) {
                	$settag = Tag::create([
                    	'group_id' => 1,
                        'name' => $tag,
                        //'slug' => NULL,
                        'view_count' => 0,
                    ]);
                    
                    //slugにIDをセット
                    $tagm = $this->tag->find($settag->id);
                    $tagm->slug = $settag->id;
                    $tagm->save();
                    //idと名前を取る
                    $tagId = $settag->id;
                    $tagName = $tag;
                }
                else {
                	$tagId = $obj->id;
                    $tagName = $obj->name;
                }
                
                
                //Relationにセット
                $settag = TagRelation::create([
                    'atcl_id' => $baseId,
                    'tag_id' => $tagId,
                    'tag_name' => $tagName,
                ]);
                	
            }
            

            //$atclModel = $this->article;
            
            $atcl->fill($data); //モデルにセット
            $atcl->save(); //モデルからsave
            
            $id = $atcl->id;
            
            //articleBaseにpost_idをセット
            //$atcl->post_id = $id;
            //$atcl->save();
            
            //tagRelationへのセット
//            if(isset($data['open'])) { //公開（ボタン押下）時にセットする
//            	$n = 0;
//            	while ($n < 3) {
//                	$str = 'tag_id_'.($n+1);
//                    
//                    if($data[$str] != '') {
//                        $tags = explode(',', $data[$str]);
//                        foreach($tags as $tag) {
//                            TagRelation::create([
//                                'tag_id' => $tag,
//                                'post_id' => $id,
//                                'base_id' => $atcl->id,
//                            ]);
//                        }
//                    }
//                    
//                	$n++;
//                }
//            }

            //return view('dashboard.article.form', ['thisClass'=>$this, 'tags'=>$tags, 'status'=>'記事が更新されました。']);
            return redirect('mypage/'.$id.'/edit')->with('status', '記事が追加されました！');
        }
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
    	$atcl = Article::find($id);
        $cate = Category::find($atcl->cate_id);
        $edit = 1;
        
        return view('mypage.edit', ['atcl'=>$atcl, 'cate'=>$cate, 'edit'=>1]);
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
        else {
        	$data['open_date'] = date('Y-m-d H:i:s', time());
        }
        
        //タグセット
        $tag_1 = explode(' ', $data['tag_1']);
            
        foreach($tag_1 as $tag) {
            $obj = $this->tag->where('name', $tag)->first();
        
            //Tagsにセット
            if(!isset($obj)) {
                $settag = Tag::create([
                    'group_id' => 1,
                    'name' => $tag,
                    //'slug' => NULL,
                    'view_count' => 0,
                ]);
                
                //slugにIDをセット
                $tagm = $this->tag->find($settag->id);
                $tagm->slug = $settag->id;
                $tagm->save();
                //idと名前を取る
                $tagId = $settag->id;
                $tagName = $tag;
                
            }
            else {
                $tagId = $obj->id;
                $tagName = $obj->name;
            }
            
            //tagIdがRelationになければセット
            $tagRel = $this->tagRelation->where([
            	['tag_id', '=', $tagId], ['atcl_id', '=', $id],
            ])->get();
            if($tagRel->isEmpty()) {
                $settag = TagRelation::create([
                    'atcl_id' => $id,
                    'tag_id' => $tagId,
                    'tag_name' => $tagName,
                ]);
            }
            
            $tagIds[] = $tagId;
        } //foreach
        
        
        //元々relationにあったtagがなくなった場合：今回取得したtagIdの中にrelationのtagIdがない場合
//        $tr = $this->tagRelation->where('atcl_id', $id)->get();
//    	foreach($tr as $val) {
//        	$relTagIds[] = $val->tag_id;
//        }
		$relTagIds = $this->tagRelation->where('atcl_id', $id)->get()->map(function($rel){
        	return $rel->tag_id;
        });
        
        foreach($relTagIds as $relTagId) {
        	if(! in_array($relTagId, $tagIds)) {
            	$tagRel = $this->tagRelation->where([
                    ['tag_id', '=', $relTagId], ['atcl_id', '=', $id],
                ])->delete();
            }
        }
        
        //exit();
        
        
        $postModel = $this->article->find($id);
        
        $postModel->fill($data); //モデルにセット
        $postModel->save(); //モデルからsave
        
        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
//		$admin = Article::create([
//            'admin_name' => $data['admin_name'],
//			'admin_email' => $data['admin_email'],
//			'admin_password' => bcrypt($data['admin_password']),
//		]);
        

        return redirect('mypage/'.$id.'/edit')->with('status', '記事が更新されました！');
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
    
    // --------------------------------------------------------------------------------------
    //        if(! isset($data['open_status'])) {
    //        	$data['open_status'] = 0;
    //        }
            
    //        $data['up_date'] = $request->input('up_year'). '-' .$request->input('up_month') . '-' . $request->input('up_day');
    //        
    //        foreach($data as $key=>$val) { //checkboxの複数選択をカンマ区切りにする
    //        	if(is_array($data[$key]))
    //            	$data[$key] = implode(',', $data[$key]);
    //        }
}
