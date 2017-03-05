<?php

namespace App\Http\Controllers\Main;

use App\Article;
use App\User;
use App\Tag;
use App\TagRelation;
use App\TagGroup;
use App\Category;
use App\Item;
use App\Fix;
use App\Totalize;
use App\TotalizeAll;

use Ctm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct(Article $article, User $user, Tag $tag, TagRelation $tagRelation, TagGroup $tagGroup, Category $category, Item $item, Fix $fix, Totalize $totalize, TotalizeAll $totalizeAll)
    {
        $this->middleware('search');
        
        $this->article = $article;
        $this->user = $user;
        $this->tag = $tag;
        $this->tagRelation = $tagRelation;
        $this->tagGroup = $tagGroup;
        $this->category = $category;
        $this->item = $item;
        $this->fix = $fix;
        $this->totalize = $totalize;
        $this->totalizeAll = $totalizeAll;
        
        $this->perPage = env('PER_PAGE', 20);
        $this->itemPerPage = 15;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$atcls = Article::where([
                    ['del_status', '=', 0], ['open_status','=',1], ['owner_id', '>', 0]
                ])->orderBy('open_date','DESC')->paginate($this->perPage);
        
    	//$atcls = $atcl ->sortByDesc('open_date')->paginate($this->perPage); //Collection
        //$ranks = $atcl ->sortByDesc('view_count')->take(20);
        
//        $objId = array();
//        foreach($rankObjs as $obj) {
//        	$objId[] = $obj->post_id;
//            //$rankObj[] = $this->articlePost->find($obj->post_id);
//        }
//    	$ranks = $this->article ->find($objId)->where('open_status', 1)->take(20);
        
        //$tagRanks = $this->tag->orderBy('view_count', 'desc')->take(10)->get();
        //$cates = $this->category->all();
        
        $rankName = '全体';
        $className = 'top';
        
        $rightRanks = Ctm::getArgForView('', 'all');
        //extract($arg);
        //compact('allRanks', 'tagLeftRanks', 'cateLeft', 'rightRanks')
        
        //$groupModel = $this->tagGroup;
    
    	return view('main.index', ['atcls'=>$atcls, 'rankName'=>$rankName, 'rightRanks'=>$rightRanks, 'rankName'=>$rankName, 'className'=>$className]);
    	//'groupModel'=>$groupModel, 'tagLeftRanks'=>$tagLeftRanks, 'cateLeft'=>$cateLeft
    }
    
    public function showSingle($postId)
    {
    	if(session('fromMp')) { //from MyPage
        	$atcl = Article::find($postId);
        }
        else {
            $atcl = Article::where([
                ['del_status', '=', 0], ['open_status','=',1], ['owner_id', '>', 0]
            ])->find($postId);
        }
        //Error
        if(!isset($atcl)) {
        	abort(404);
        }
        
        
        $user = User::find($atcl->owner_id);

		//relationからtagIdを取得
        $tagRelIds = $this->tagRelation->where('atcl_id', $postId)->get()->map(function($rel){
        	return $rel->tag_id;
        })
        ->all(); //配列にする
        
        //tagObjを取得してgroup分け
        $useTag = $this->tag->find($tagRelIds);
        $tagGroups = $useTag->groupBy('group_id')->toArray();
        
        //group分けした配列のkeyをnameに変更してtagsへ
        $tags = array();
        foreach($tagGroups as $key => $val) {
        	$tagName = $this->tagGroup->find($key)->name;
        	$tags[$tagName] = $val;
        }
        
        $tagGroupAll = $this->tagGroup->where('open_status', 1)->get();

        $cate = $this->category->find($atcl->cate_id);
        
        //Item
        $items = $this->item->where(['atcl_id'=>$postId, 'delete_key'=>0])->orderBy('item_sequence', 'asc')->paginate($this->itemPerPage);
        
        //setCount
        $date = date('Y-m-d', time());
        $total = $this->totalize->where(['atcl_id' => $postId, 'view_date' => $date])->first();
        
        //totalize
        if($total) {
        	$view = $total->view_count;
            $view++;
            $total->view_count = $view;
	        $total->save();
        }
        else {
        	$total = $this->totalize->create(
            	[
                    'atcl_id' => $postId,
                    'view_date' => $date,
                    'view_last' => date('Y-m-d H:i:s', time()),
                    'view_count' => 1,
                ]
            );
        }
        
        //totalize all
        $totalAll = $this->totalizeAll->where(['atcl_id' => $postId])->first();
        if($totalAll) {
        	$totalView = $totalAll->total_count;
            $totalView++;
            $totalAll->total_count = $totalView;
            $totalAll->view_last = $total->view_last;
	        $totalAll->save();
        }
        else {
        	$totalAll = $this->totalizeAll->create(
            	[
                    'atcl_id' => $postId,
                    'view_date' => $date,
                    'view_last' => $total->view_last,
                    'total_count' => 1,
                ]
            );
        }
        
//        $flight = TotalizeAll::updateOrCreate(
//    		['atcl_id' => $postId],
//    		[
//            	'view_date' => $total->view_date,
//                'view_last' => $total -> view_last,
//            	'total_count'
//            ]
//		);
        
    	return view('main.single', ['atcl'=>$atcl, 'user'=>$user, 'tagGroups'=>$tagGroups, 'tagGroupAll'=>$tagGroupAll, 'cate'=>$cate, 'items'=>$items]);
    }
    
    public function showFix(Request $request)
    {
    	$slug = $request->path();
        
    	$fix = $this->fix->where(['slug'=>$slug, 'not_open'=>0])->first();
        
        if(!$fix) {
        	abort(404);
        }
        
        return view('main.fix', ['fix'=>$fix]);
    }
    
}

