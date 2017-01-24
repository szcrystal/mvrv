<?php

namespace App\Http\Controllers\Main;

use App\Article;
use App\User;
use App\Tag;
use App\TagRelation;
use App\TagGroup;
use App\Category;
use App\Item;

use Ctm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct(Article $article, User $user, Tag $tag, TagRelation $tagRelation, TagGroup $tagGroup, Category $category, Item $item)
    {
        $this->middleware('search');
        
        $this->article = $article;
        $this->user = $user;
        $this->tag = $tag;
        $this->tagRelation = $tagRelation;
        $this->tagGroup = $tagGroup;
        $this->category = $category;
        $this->item = $item;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$atcl = Article::where([
                    ['del_status', '=', '0'], ['owner_id', '>', '0'], ['open_status','=',1]
                ])->get();
        
        
    	$posts = $atcl ->sortByDesc('open_date')->take(30); //Collection
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
        
        $arg = Ctm::getArgForView('', 'all');
        extract($arg);
        //compact('allRanks', 'tagLeftRanks', 'cateLeft', 'rightRanks')
        
        $groupModel = $this->tagGroup;
    
    	return view('main.index', ['posts'=>$posts, 'rankName'=>$rankName, 'tagLeftRanks'=>$tagLeftRanks, 'cateLeft'=>$cateLeft, 'rightRanks'=>$rightRanks, 'rankName'=>$rankName, 'groupModel'=>$groupModel]);
    }
    
    public function showSingle($postId)
    {
    	$atcl = Article::find($postId);
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
        $items = $this->item->where(['atcl_id'=>$postId, 'delete_key'=>0])->orderBy('item_sequence', 'asc')->get();
        
        //setCount
		$view = $atcl->view_count;
        $view++;
        $atcl->view_count = $view;
        $atcl->save();
        
        
        //getArg
        //$arg = $this->getArgForView();
        
    	return view('main.single', ['atcl'=>$atcl, 'user'=>$user, 'tagGroups'=>$tagGroups, 'tagGroupAll'=>$tagGroupAll, 'cate'=>$cate, 'items'=>$items ]);
    }
    
    private function getArgForView()
    {
    	$posts = ArticlePost::where('open_status', 1)
               ->orderBy('open_date', 'desc')
               ->take(30)
               ->get();
        
        $rankObjs = ArticleBase::where([
        				['del_status', '=', '0'], ['owner_id', '>', '0']
                    ])
               ->orderBy('view_count', 'desc')
               ->get();
        
        foreach($rankObjs as $obj) {
        	$objId[] = $obj->post_id;
            //$rankObj[] = $this->articlePost->find($obj->post_id);
        }
    
    	$ranks = $this->articlePost ->find($objId)->where('open_status', 1)->take(20);
        
        $tagRanks = $this->tag->orderBy('view_count', 'desc')->take(10)->get();
        
        return compact('posts', 'ranks', 'tagRanks');
    }
    
    
    
}
