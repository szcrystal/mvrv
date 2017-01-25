<?php

namespace App\Http\Controllers\MyPage;

use App\Article;
use App\Tag;
use App\TagGroup;
use App\TagRelation;
use App\Category;
use App\Item;
use Auth;
use DB;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    
	public function __construct(Article $article, Tag $tag, TagGroup $tagGroup, TagRelation $tagRelation, Category $category, Item $item)
    {
        $this->middleware('auth');
        
        $this-> article = $article;
        $this-> category = $category;
        $this-> tag = $tag;
        $this->tagGroup = $tagGroup;
        $this->tagRelation = $tagRelation;
        $this->item = $item;
        
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
        
//        $atcls = Article::where(['owner_id'=>0, 'del_status'=>0])
//            	->orderBy('id', 'desc')
//                ->get();
//        
//        $closeCount = $posts->where('open_status', 0)->count();
        
        $cateModel = $this->category;
        
        return view('mypage.index', ['posts'=>$posts, 'user'=>$user, 'cateModel'=>$cateModel]);
    }
    
    public function newMovie() {
    	$user = Auth::user();
        
    	$atcls = Article::where(['owner_id'=>0, 'del_status'=>0])
            	->orderBy('id', 'desc')
                ->get();
        
        $closeCount = Article::where(['owner_id'=>$user->id, 'open_status'=>0])->count();
        
        $cateModel = $this->category;
        
        return view('mypage.newMovie', ['atcls'=>$atcls, 'user'=>$user, 'cateModel'=>$cateModel, 'closeCount'=>$closeCount]);
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
        
        $tagGroupAll = $this->tagGroup->where('open_status', 1)->get();
        
        $tags = $this->tag->all()->groupBy('group_id')->toArray();

        return view('mypage.create', ['atcl'=> $atcl, 'userId'=>$userId, 'cate'=>$cate, 'tagGroupAll'=>$tagGroupAll, 'tags'=>$tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$atclId = $request->input('atcl_id');
    	$atcl = Article::find($atclId);
        $userId = Auth::user()->id;
        
//        print_r($request->input('keyword'));
//        exit();
        
    	if($atcl->owner_id) { //オーナーが先に決まった時
        	//return redirect('mypage/error')->with('owner_status', 1);
            return view('mypage.error', ['owner_status'=>1, 'atcl'=>$atcl]);
    	}
        
        //オーナーが決まっていなければowner_idをセットして継続
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
            $data['open_history'] = 1;
            $data['open_date'] = date('Y-m-d H:i:s', time());
        }
        
        //Thumbnail Upload
        if($request->file('thumbnail') != '') {
            $filename = $request->file('thumbnail')->getClientOriginalName();
            $filename = $userId .'/' . $atclId .'/thumbnail/' . $filename;
            $path = $request->file('thumbnail')->storeAs('public', $filename);
        
            $data['thumbnail'] = $filename;
        }
        
        $imgArr = $request->file('image_path');
//            print_r($imgArr);
//            exit();
        
        if(isset($data['item_type'])) {
            $sequence_num = 1;
            foreach($data['item_type'] as $key => $val) {
                
                if($val == '') { //item_typeが空ならスキップ
                    continue;
                }
                    
                //Create時にitem_idは使用しない
                
                if(isset($imgArr[$key])) {
                    $itemFileName = $imgArr[$key]->getClientOriginalName();
                    $itemFileName = $userId .'/' . $atclId .'/item/' . $itemFileName;
                    $itemPath = $imgArr[$key]->storeAs('public', $itemFileName);
            
                    $data['image_path'][$key] = $itemFileName;
                }
                else {
                    $data['image_path'][$key] = $data['image_path_hidden'][$key];
                }

                $itemModel = Item::create(
                    //['id' => $item_id, 'atcl_id' => $id],
                    [
                        'atcl_id' => $atclId,
                        'item_type' => $data['item_type'][$key],
                        'main_title' => $data['main_title'][$key],
                        'title_option' => $data['title_option'][$key] ? $data['title_option'][$key] : 0,
                        'main_text' => $data['main_text'][$key],
                        'image_path' => $data['image_path'][$key],
                        'image_title' => $data['image_title'][$key],
                        'image_orgurl' => $data['image_orgurl'][$key],
                        'image_comment' => $data['image_comment'][$key],
                        'link_title' => $data['link_title'][$key],
                        'link_url' => $data['link_url'][$key],
                        'link_imgurl' => $data['link_imgurl'][$key],
                        'link_option' => $data['link_option'][$key] ? $data['link_option'][$key] : 0, //or NULL
                        'item_sequence' => $sequence_num,
                    ]
                );
                
                $sequence_num++;
            }
            //exit();
        }
        
        
        //タグセット
        //$tagGroups = $this->tagGroup->all();
        $tagGroups = $this->tagGroup->where('open_status',1)->get();
        
        foreach($tagGroups as $tg) {
            $tagArr = array();
            if(isset($data[$tg->slug])) {
                $tagArr = $data[$tg->slug];
            }
            
//            	if($data[$tg->slug] != '') //空登録を回避
//                	$tagArr = explode(' ', $data[$tg->slug]); //if(str_contains($data['tag_1'], ' ')) {
            
            foreach($tagArr as $tag) {
                $obj = $this->tag->where(['name'=>$tag, 'group_id'=>$tg->id])->first();
            
                //Tagsにセット
                if(!isset($obj)) { //同じタグがなければ 既存タグがない場合 or $obj（既存タグ）はあるがグループが違う場合
                    $settag = Tag::create([
                        'group_id' => $tg->id,
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
                    //$tagName = $obj->name;
                }
                
                
                //Relationにセット
                $settag = TagRelation::create([
                    'atcl_id' => $atclId,
                    'tag_id' => $tagId,
                    //'tag_name' => $tagName,
                ]);
                    
            }
        }

//            $tag_1 = explode(' ', $data['tag_1']);
//            foreach($tag_1 as $tag) {
//            	$obj = $this->tag->where('name', $tag)->first();
//            
//                //Tagsにセット
//                if(!isset($obj)) {
//                	$settag = Tag::create([
//                    	'group_id' => 1,
//                        'name' => $tag,
//                        //'slug' => NULL,
//                        'view_count' => 0,
//                    ]);
//                    
//                    //slugにIDをセット
//                    $tagm = $this->tag->find($settag->id);
//                    $tagm->slug = $settag->id;
//                    $tagm->save();
//                    //idと名前を取る
//                    $tagId = $settag->id;
//                    $tagName = $tag;
//                }
//                else {
//                	$tagId = $obj->id;
//                    $tagName = $obj->name;
//                }
//                
//                
//                //Relationにセット
//                $settag = TagRelation::create([
//                    'atcl_id' => $baseId,
//                    'tag_id' => $tagId,
//                    'tag_name' => $tagName,
//                ]);
//                	
//            }
        

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
        
        //relationからtagIdを取得
        $tagRelIds = $this->tagRelation->where('atcl_id', $atcl->id)->get()->map(function($rel){
        	return $rel->tag_id;
        })
        ->all(); //配列にする
        
        //tagObjを取得してgroup分け
        $useTag = $this->tag->find($tagRelIds);
        $tagGroups = $useTag->groupBy('group_id')->toArray();
        
        $tagGroupAll = $this->tagGroup->where('open_status', 1)->get();
        
        $tags = $this->tag->all()->groupBy('group_id')->toArray();
        
        $items = $this->item->where(['atcl_id'=>$id, 'delete_key'=>0])->orderBy('item_sequence', 'asc')->get();

        
        //group分けした配列のkeyをnameに変更してtagsへ
//        $tagWithNames = array();
//        foreach($tagGroups as $key => $val) {
//        	$tagName = $this->tagGroup->find($key)->name;
//        	$tagWithNames[$tagName] = $val;
//        }
		
        //$tagModel = $this->tag;
        
        return view('mypage.edit', ['atcl'=>$atcl, 'cate'=>$cate, 'edit'=>1, 'tagGroups'=>$tagGroups, 'tagGroupAll'=>$tagGroupAll, 'tags'=>$tags, 'items'=>$items]);
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
    	$userId = Auth::user()->id;
        
        $rules = [
//            'admin_name' => 'required|max:255',
//            'admin_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
//            'admin_password' => 'required|min:6',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        
        if(isset($data['open'])) { //公開するボタン 初公開
            $data['open_status'] = 1;
            $data['open_history'] = 1;
            $data['open_date'] = date('Y-m-d H:i:s', time());
        }
        else {
        	$data['open_status'] = isset($data['open_status']) ? 1 : 0;
        }
        
//        if(count($request->file('image_path')) > 0) {
//        	print_r($request->file('image_path'));
//        }
//        exit();
        
        //Thumbnail Upload
        if($request->file('thumbnail') != '') {
        	$filename = $request->file('thumbnail')->getClientOriginalName();
        	$filename = $userId . '/' .$id . '/thumbnail/' . $filename;
        	$path = $request->file('thumbnail')->storeAs('public', $filename);
        
        	$data['thumbnail'] = $filename;
        }
        
        $imgArr = $request->file('image_path');
//        print_r($imgArr);
//        print_r($data['main_title']);
//        exit();
        
        //Item セット
        if(isset($data['item_type'])) {
            $sequence_num = 1;
            foreach($data['item_type'] as $key => $val) {
                
                if($val == '') { //item_typeが空ならスキップ
                    continue;
                }
                
                $item_id = $data['item_id'][$key] != '' ? $data['item_id'][$key] : 0; //item_idは既存のitemにのみセットされている
                
                if($item_id && $data['delete_key'][$key]) { //delete_keyはjsにてitem_idのあるもののみにセット
                    Item::destroy($item_id); //find($item_id)->delete()
                }
                else {
                	//Item画像
                    if(isset($imgArr[$key])) {
                        $itemFileName = $imgArr[$key]->getClientOriginalName();
                        $itemFileName = UserId . '/' .$id . '/item/' . $itemFileName;
                        $itemPath = $imgArr[$key]->storeAs('public', $itemFileName);
                
                        $data['image_path'][$key] = $itemFileName;
                    }
                    else {
                        $data['image_path'][$key] = $data['image_path_hidden'][$key];
                    }

                    $itemModel = Item::updateOrCreate(
                        ['id' => $item_id, 'atcl_id' => $id],
                        [
                            'atcl_id' => $id,
                            'item_type' => $data['item_type'][$key],
                            'main_title' => $data['main_title'][$key],
                            'title_option' => $data['title_option'][$key] ? $data['title_option'][$key] : 0,
                            'main_text' => $data['main_text'][$key],
                            'image_path' => $data['image_path'][$key],
                            'image_title' => $data['image_title'][$key],
                            'image_orgurl' => $data['image_orgurl'][$key],
                            'image_comment' => $data['image_comment'][$key],
                            'link_title' => $data['link_title'][$key],
                            'link_url' => $data['link_url'][$key],
                            'link_imgurl' => $data['link_imgurl'][$key],
                            'link_option' => $data['link_option'][$key] ? $data['link_option'][$key] : 0, //or NULL
                            'item_sequence' => $sequence_num,
                        ]
                    );
                    
                    $sequence_num++;
                } //delete_key
            }
        	//exit();
        }
        
        
        //タグセット
        //$tagGroups = $this->tagGroup->all();
        $tagGroups = $this->tagGroup->where('open_status', 1)->get();
        
        $tagIds = array();
        
        foreach($tagGroups as $tg) {
        	$tagArr = array();
            if(isset($data[$tg->slug])) {
                $tagArr = $data[$tg->slug];
            }
//            if($data[$tg->slug] != '') //空登録を回避
//	            $tagArr = explode(' ', $data[$tg->slug]);
            
            foreach($tagArr as $tag) {
                $obj = $this->tag->where(['name'=>$tag, 'group_id'=>$tg->id])->first();
            
                //Tagsにセット
                if(!isset($obj)) { //既存タグがない場合 or $obj（既存タグ）はあるがグループが違う場合
                    $settag = Tag::create([
                        'group_id' => $tg->id,
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
                    //$tagName = $tag;
                }
                else {
                    $tagId = $obj->id;
                }
                
                //tagIdがRelationになければセット
                $tagRel = $this->tagRelation->where([
                    ['tag_id', '=', $tagId], ['atcl_id', '=', $id],
                ])->get();
                
                if($tagRel->isEmpty()) {
                    $settag = TagRelation::create([
                        'atcl_id' => $id,
                        'tag_id' => $tagId,
                    ]);
                }
                
                $tagIds[] = $tagId;
            } //foreach
        
        }
        
        
        //元々relationにあったtagがなくなった場合：今回取得したtagIdの中にrelationのtagIdがない場合
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
        $postModel->save(); //モデルsave
        
        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
//		$admin = Article::create([
//            'admin_name' => $data['admin_name'],
//			'admin_email' => $data['admin_email'],
//			'admin_password' => bcrypt($data['admin_password']),
//		]);

		

        if(isset($data['preview'])) {
        	$mypage = 'mypage/'.$id.'/edit/';
        	return redirect('single/'.$id)->with('fromMp', $mypage);
        }
		else {
        	return redirect('mypage/'.$id.'/edit')->with('status', '記事が更新されました！');
        }
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
    
    private function setTag() {
    	$tagGroups = $this->tagGroup->all();
            
        foreach($tagGroups as $tg) {
            $tagArr = explode(' ', $data[$tg->slug]); //if(str_contains($data['tag_1'], ' ')) {
            
            foreach($tagArr as $tag) {
                $obj = $this->tag->where('name', $tag)->first();
            
                //Tagsにセット
                if(!isset($obj)) { //同じタグがなければ
                    $settag = Tag::create([
                        'group_id' => $tg->id,
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
        }
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
    
    //Tagの取得
//        $n = 0;
//        while($n < 3) {
//            $str = 'tag_'. ($n+1);
//            $tagIds = array();
//            $tagIds = explode(',', $atcl->{$str});
//            
//            $tags[$n] = $this->tag->find($tagIds);
//            
//            $n++;
//        }
}
