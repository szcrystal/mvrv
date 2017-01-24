<?php

namespace App\Http\Controllers\Main;

use App\Article;
use App\Tag;
use App\TagGroup;
use App\TagRelation;
use App\Category;
use Auth;
use Ctm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
	public function __construct(Article $article, Tag $tag, TagGroup $tagGroup, TagRelation $tagRelation, Category $category)
    {
        //$this->middleware('auth');
        
        $this-> article = $article;
        $this-> tag = $tag;
        $this->tagGroup = $tagGroup;
        $this->tagRelation = $tagRelation;
        $this->category = $category;
        
        $this->perPage = env('PER_PAGE', 20);
    }
    
    public function index($groupSlug)
    {
    	$group = $this->tagGroup->where('slug', $groupSlug)->first();
        
        if(!isset($group)) {
        	abort(404);
        }
        else {
            $groupId = $group->id;
            $groupName = $group->name;
            
            $tagIds = $this->tag->where('group_id', $groupId)->get()->map(function($tg){
                return $tg->id;
            })->all();
            
            $atclIds = $this->tagRelation->whereIn('tag_id', $tagIds)->get()->map(function($tr){
                return $tr->atcl_id;
            })->all();
            
            
            $atcls = $this-> article->whereIn('id', $atclIds)->where([
                        ['del_status', '=', '0'], ['owner_id', '>', '0'], ['open_status','=',1]
                    ])->paginate($this->perPage);
            
            //getArg
            $arg = Ctm::getArgForView('', 'all');
            extract($arg);
            
            $rankName = '全体'; /* ******** */
            $groupModel = $this->tagGroup;
            
            return view('main.tag.index', ['atcls'=>$atcls, 'groupName'=>$groupName, 'tagLeftRanks'=>$tagLeftRanks, 'cateLeft'=>$cateLeft, 'rightRanks'=>$rightRanks, 'rankName'=>$rankName, 'groupModel'=>$groupModel]);
    	
        }//else
        
    }
    
    public function show($groupSlug, $tagSlug)
    {
    	//$tag = $this->tag->find($tagId);
        $tag = $this->tag->where('slug', $tagSlug)->first();
    
    	$tagRs = TagRelation::where('tag_id', $tag->id)
               ->orderBy('id', 'desc')
               //->take(30)
               ->get();
        
        $ids = array();
        foreach($tagRs as $tagR ) {
        	$ids[] = $tagR->atcl_id;
        }
        
        //$tagPosts = $this->article->find($ids)->where('open_status', 1);
        $tagPosts = $this->article->whereIn('id', $ids)->where('open_status', 1)->paginate($this->perPage);
        
        //getArg
        $arg = Ctm::getArgForView($tagSlug, 'tag');
        extract($arg);
        
        $groupName = $this->tagGroup->find($tag->group_id)->name;
        $rankName = $groupName.'：'.$tag->name;
        
        $groupModel = $this->tagGroup;
        
        //Count
		$view = $tag->view_count;
        $view++;
        $tag->view_count = $view;
        $tag->save();
        
        return view('main.tag.show', ['tagPosts'=>$tagPosts, 'tagName'=>$tag->name, 'tagLeftRanks'=>$tagLeftRanks, 'cateLeft'=>$cateLeft, 'rightRanks'=>$rightRanks, 'rankName'=>$rankName, 'groupModel'=>$groupModel, 'groupName'=>$groupName]);
    }
    
    /*
    private function getArgForView()
    {
    	$posts = Article::where('open_status', 1)
               ->orderBy('open_date', 'desc')
               ->take(30)
               ->get();
        
        $ranks = Article::where([
        				['del_status', '=', '0'], ['owner_id', '>', '0'], ['open_status','=',1]
                    ])
               ->orderBy('view_count', 'desc')
               ->take(20)
               ->get();
        
//        foreach($rankObjs as $obj) {
//        	$objId[] = $obj->post_id;
//            //$rankObj[] = $this->articlePost->find($obj->post_id);
//        }
//    
//    	$ranks = $this->articlePost ->find($objId)->where('open_status', 1)->take(20);
        
        $tagRanks = $this->tag->orderBy('view_count', 'desc')->take(10)->get();
        
        $cates = $this->category->all();
        
        return compact('posts', 'ranks', 'tagRanks', 'cates');
    }
    */
    
}
