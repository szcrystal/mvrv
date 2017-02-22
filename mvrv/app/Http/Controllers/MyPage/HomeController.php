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
use File;

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
    
    public function newCreate()
    {
//        $atcl = null;
//        
//        if($atclId) {
//        	$atcl = $this->article->find($atclId);
//        }
        
        $userId = Auth::user()->id;
        $cates = $this->category->all();
        
        return view('mypage.create', ['userId'=>$userId, 'cates'=>$cates]);
    }
    
    public function postBase(Request $request)
    {
    	$rules = [
        	'title' => 'required|max:255',
            'movie_site' => 'required|max:255', /* |unique:admins 注意:unique */
            'movie_url' => 'required|max:255',
            'cate_id' => 'required',
        ];
        $this->validate($request, $rules);
        
        $atclId = $request->input('atcl_id');
        
        $data = $request->all();
        
        if($atclId) {
            $atcl = Article::find($atclId);
        }
        else {
        	$atcl = $this->article;
            $data['open_status'] = 0;
            $data['open_history'] = 0;
            $data['del_status'] = 0;
            $data['not_newdate'] = 0;
            $data['view_count'] = 0;
            $data['owner_id'] = Auth::user()->id;
        }
        
        $atcl->fill($data); //モデルにセット
        $atcl->save(); //モデルからsave
        
        $id = $atcl->id;
        $status = '基本情報が更新されました！';
        
        return redirect('mypage/'.$id.'/edit')->with('status', $status);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($atclId='')
    {
    	if($atclId) { //from Admin
        	$atcl = Article::find($atclId);
            $cate = Category::find($atcl->cate_id);
            
            $movieUrl = $this->article->whereNotIn('id', [$atclId])->get()->map(function($item) {
                return $item->movie_url;
            })->all();
        }
        else { //new create
        	$atcl = NULL;
            $cate = '';
            
            $movieUrl = $this->article->get()->map(function($item) {
                //return rtrim($item->movie_url, '/');
                return $item->movie_url;
            })->all();
        }
        
        $userId = Auth::user()->id;
        
        $cates = $this->category->all();
        
        $tagGroupAll = $this->tagGroup->where('open_status', 1)->get();
        
        $tags = $this->tag->all()->groupBy('group_id')->toArray();
        
        

        return view('mypage.create', ['atcl'=> $atcl, 'userId'=>$userId, 'cate'=>$cate, 'cates'=>$cates, 'tagGroupAll'=>$tagGroupAll, 'tags'=>$tags, 'movieUrl'=>$movieUrl]);
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
        	//'title' => 'required|max:255',
            //'movie_url' => 'required|max:255',
        ];
        $this->validate($request, $rules);
        
        $userId = Auth::user()->id;
        
        $data = $request->all(); //requestから配列として$dataにする
        
        $inputAtclId = $request->input('atcl_id') ? $request->input('atcl_id') : 0;
        $rand = mt_rand();
        
        
        //Thumbnail Upload
        if($data['thumb_success']) {
        	if(!$data['thumb_choice']) { //input Upload
            	if($request->file('thumbnail') != '') {
                    $filename = $request->file('thumbnail')->getClientOriginalName();
                    
                    $aId = $inputAtclId ? $inputAtclId : $rand;
                    $pre = time() . '-';
                    $filename = $userId . '/' .$aId . '/thumbnail/' . $pre . $filename;
                    //if (App::environment('local'))
                    $path = $request->file('thumbnail')->storeAs('public', $filename);
                    //else
                    //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                    //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                
                    $data['thumbnail'] = $filename;
                }
        	}
            else { //URL入力の時
                if($data['thumbnail_outurl'] != '') {
                	try {
                    	$file = file_get_contents($data['thumbnail_outurl']);
                    }
                    catch (\Exception $e) {
                    	$getId = $inputAtclId ? $inputAtclId .'/' : '';
                        return redirect('mypage/'.$getId.'create')->withInput()->withErrors(array('画像の取得ができませんでした'));
                    }
                    
                    $info = pathinfo($data['thumbnail_outurl']);
                    
                    $aId = $inputAtclId ? $inputAtclId : $rand;
                    $pre = time() . '-';
                    $name = 'public/' . $userId . '/' .$aId . '/thumbnail/'. $pre . $info['basename'];
                    
                    Storage::put($name, $file);
                    
                    $data['thumbnail'] = $name;
                }
            }
        }
        
        $imgArr = $request->file('image_path');
        
        if(isset($data['item_type'])) {
            $sequence_num = 1;
            foreach($data['item_type'] as $key => $val) {
                
                if($val == '') { //item_typeが空ならスキップ
                    continue;
                }
                    
                //Create時にitem_idは使用しない

                //Item画像
                if(! $data['image_choice'][$key]) { // by UpLoad
                    if(isset($imgArr[$key])) {
                        $itemFileName = $imgArr[$key]->getClientOriginalName();
                        
                        $aId = $inputAtclId ? $inputAtclId : $rand;
                        $pre = time() . '-';
                        $itemFileName = $userId . '/' .$aId . '/item/' . $pre . $itemFileName;
                        
                        $itemPath = $imgArr[$key]->storeAs('public', $itemFileName);
                
                        $data['image_path'][$key] = $itemFileName;
                    }
                    else {
                        $data['image_path'][$key] = $data['image_path_hidden'][$key]; //空をセット
                    }
                }
                else { //by URL
                    if($data['image_outurl'][$key] != '') {
                    	try {
                        	$file = file_get_contents($data['image_outurl'][$key]);
                        }
                        catch (\Exception $e) {
                            $getId = $inputAtclId ? $inputAtclId .'/' : '';
                        	return redirect('mypage/'.$getId.'create')->withInput()->withErrors(array('画像の取得ができませんでした'));
                        }
                        $info = pathinfo($data['image_outurl'][$key]);
                        
                        $aId = $inputAtclId ? $inputAtclId : $rand;
                        $pre = time() . '-';
                        $name = 'public/' . $userId . '/' .$aId . '/item/'. $pre . $info['basename'];
                        
                        Storage::put($name, $file);
                        
                        $data['image_path'][$key] = $name;
                    }
                    else {
                        $data['image_path'][$key] = $data['image_path_hidden'][$key];
                    }
                }
                
                //by Link img url
                if($data['link_imgurl'][$key] != '') {
                    try {
                        $lFile = file_get_contents($data['link_imgurl'][$key]);
                    }
                    catch (\Exception $e) {
                        $getId = $inputAtclId ? $inputAtclId .'/' : '';
                        return redirect('mypage/'.$getId.'create')->withInput()->withErrors(array('画像の取得ができませんでした'));
                    }
                    $lInfo = pathinfo($data['link_imgurl'][$key]);
                    
                    $aId = $inputAtclId ? $inputAtclId : $rand;
                    $lPre = time() . '-';
                    $lName = 'public/' . $userId . '/' .$aId . '/item/'. $lPre . $lInfo['basename'];
                    
                    Storage::put($lName, $lFile);
                    
                    $data['link_imgpath'][$key] = $lName;
                }
                //else { $data['link_imgpath'][$key] = ''; }

                $itemModel = Item::create(
                    //['id' => $item_id, 'atcl_id' => $id],
                    [
                        'atcl_id' => 0,
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
                        'link_imgpath' => $data['link_imgpath'][$key],
                        'link_option' => $data['link_option'][$key] ? $data['link_option'][$key] : 0, //or NULL
                        'item_sequence' => $sequence_num,
                    ]
                );
                
                $itemId[] = $itemModel->id;
                
                $sequence_num++;
            }
            //exit();
        }
        
        
        if(isset($data['keep'])) {
            $data['open_status'] = 0;
        }
        if(isset($data['open'])) {
            $data['open_status'] = 1;
            $data['open_history'] = 1;
            $data['open_date'] = date('Y-m-d H:i:s', time());
        }

        
        if($inputAtclId) {
            $atclId = $inputAtclId;
            $atcl = Article::find($atclId);
            
            if($atcl->owner_id) { //オーナーが先に決まった時
                //return redirect('mypage/error')->with('owner_status', 1);
                return view('mypage.error', ['owner_status'=>1, 'atcl'=>$atcl]);
            }
            
            //オーナーが決まっていなければowner_idをセットして継続
            $atcl->owner_id = $userId;
            $atcl->save();
        }
        else {
        	$atcl = $this->article;
            
            $atcl->del_status = 0;
            $atcl->owner_id = $userId;
            $atcl->title = $data['title'];
            $atcl->movie_site = $data['movie_site'];
            $atcl->movie_url = $data['movie_url'];
            $atcl->cate_id = $data['cate_id'];
            $atcl->open_status = $data['open_status'];
            $atcl->open_history = isset($data['open_history']) ? $data['open_history'] : 0;
            $atcl->not_newdate = 0;
            $atcl->view_count = 0;
            
            $atcl->save();
            $atclId = $atcl->id;
            
            if(Storage::exists('public/' . $userId .'/'.$rand)) {
                Storage::move('public/' . $userId .'/'.$rand, 'public/' . $userId .'/'.$atclId);
                
                $data['thumbnail'] = str_replace($rand, $atclId, $data['thumbnail']);
                
                if(isset($itemId)) {
                    $this->item->find($itemId)->map(function($obj) use($atclId, $rand) {
                        $obj->image_path = str_replace($rand, $atclId, $obj->image_path);
                        $obj->link_imgpath = str_replace($rand, $atclId, $obj->link_imgpath);
                        $obj->save();
                    });
                }
            }
        }
        
        //$atclModel = $this->article;
        $data['movie_url'] = rtrim($data['movie_url'], '/');
        $atcl->fill($data); //モデルにセット
        $atcl->save(); //モデルからsave
        //$id = $atcl->id;
		
        if(isset($itemId)) {
            $this->item->find($itemId)->map(function($obj) use($atclId) {
                $obj->atcl_id = $atclId;
                $obj->save();
            });
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
        return redirect('mypage/'.$atclId.'/edit')->with('status', '記事が追加されました！');
        
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
        //Error
        if(!$atcl || Auth::user()->id != $atcl->owner_id) {
        	abort(404);
        }
        
        $cate = Category::find($atcl->cate_id);
        $cates = $this->category->all();
        $edit = 1;
        
        //relationからtagIdを取得
        $tagRelIds = $this->tagRelation->where('atcl_id', $atcl->id)->get()->map(function($rel){
        	return $rel->tag_id;
        })->all(); //配列にする
        
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
        
        $movieUrl = $this->article->whereNotIn('id', [$id])->get()->map(function($item) {
            return $item->movie_url;
        })->all();
        
        return view('mypage.edit', ['atcl'=>$atcl, 'cate'=>$cate, 'cates'=>$cates, 'edit'=>1, 'tagGroups'=>$tagGroups, 'tagGroupAll'=>$tagGroupAll, 'tags'=>$tags, 'items'=>$items, 'movieUrl'=>$movieUrl]);
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
            //'title' => 'required|max:255',
        ];
        
        $this->validate($request, $rules); //return redirect('mypage/'.$id.'/edit')->withInput();
        
        $data = $request->all(); //requestから配列として$dataにする
        
        if(! isset($data['not_newdate'])) { //更新日時変更
            $data['open_date'] = date('Y-m-d H:i:s', time());
            $data['not_newdate'] = 0;
        }
        
        if(isset($data['open'])) { //公開するボタン
            $data['open_status'] = 1;
            $data['open_history'] = 1;
        }
        elseif(isset($data['drop'])) { //公開取り下げボタン
        	$data['open_status'] = 0;
        }
        
//        if(count($request->file('image_path')) > 0) {
//        	print_r($request->file('image_path'));
//        }
//        exit();


        //Thumbnail Upload
        if($data['thumb_success']) {
        	if(!$data['thumb_choice']) { //input Upload
            	if($request->file('thumbnail') != '') {
                    $filename = $request->file('thumbnail')->getClientOriginalName();
                    $pre = time() . '-';
                    $filename = $userId . '/' .$id . '/thumbnail/' . $pre . $filename;
                    //if (App::environment('local'))
                    $path = $request->file('thumbnail')->storeAs('public', $filename);
                    //else
                    //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                    //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                
                    $data['thumbnail'] = $filename;
                }
        	}
            else { //URL入力の時
                if($data['thumbnail_outurl'] != '') {
                    try {
                    	$file = file_get_contents($data['thumbnail_outurl']);
                    }
                    catch (\Exception $e) {
                        return redirect('mypage/'.$id.'/edit')->withInput()->withErrors(array('画像の取得ができませんでした'));
                    }
                    
                    $info = pathinfo($data['thumbnail_outurl']);
                    $pre = time() . '-';
                    $name = 'public/' . $userId . '/' .$id . '/thumbnail/'. $pre . $info['basename'];
                    
                    Storage::put($name, $file); //s3
                    
                    $data['thumbnail'] = $name;
                }
            }
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
                    if(! $data['image_choice'][$key]) { // by UpLoad

                        if(isset($imgArr[$key])) {
                            $itemFileName = $imgArr[$key]->getClientOriginalName();
                            $pre = time() . '-';
                            $itemFileName = $userId . '/' .$id . '/item/' . $pre . $itemFileName;
                            $itemPath = $imgArr[$key]->storeAs('public', $itemFileName);
                    
                            $data['image_path'][$key] = $itemFileName;
                        }
                        else {
                            $data['image_path'][$key] = $data['image_path_hidden'][$key]; //空をセット
                        }
                        
                    }
                    else { //by URL
						if($data['image_outurl'][$key] != '') {
                        	try {
                            	$file = file_get_contents($data['image_outurl'][$key]);
                            }
                            catch (\Exception $e) {
                                return redirect('mypage/'.$id.'/edit')->withInput()->withErrors(array('画像の取得ができませんでした'));
                            }
                            $info = pathinfo($data['image_outurl'][$key]);
                            $pre = time() . '-';
                            $name = 'public/' . $userId . '/' .$id . '/item/'. $pre . $info['basename'];
                            Storage::put($name, $file);
                            
                            $data['image_path'][$key] = $name;
                        }
                        else {
                        	$data['image_path'][$key] = $data['image_path_hidden'][$key];
                        }
                    }
                    
                    //by Link img url
                    if($data['link_imgurl'][$key] != '') {
                    	try {
                    		$lFile = file_get_contents($data['link_imgurl'][$key]);
                        }
                        catch (\Exception $e) {
                            return redirect('mypage/'.$id.'/edit')->withInput()->withErrors(array('画像の取得ができませんでした'));
                        }
                        $lInfo = pathinfo($data['link_imgurl'][$key]);
                        $lPre = time() . '-';
                        $lName = 'public/' . $userId . '/' .$id . '/item/'. $lPre . $lInfo['basename'];
                        
                        Storage::put($lName, $lFile);
                        
                        $data['link_imgpath'][$key] = $lName;
                    }
                    //else { $data['link_imgpath'][$key] = ''; }

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
                            'link_imgpath' => $data['link_imgpath'][$key],
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
        $data['movie_url'] = rtrim($data['movie_url'], '/');
        
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
        	return redirect('m/'.$id)->with('fromMp', $mypage);
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
