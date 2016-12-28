<?php

namespace App\Http\Controllers\Main;

use App\Article;
use App\Tag;
use App\TagRelation;
use App\Category;
use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
	public function __construct(Article $article, Tag $tag, TagRelation $tagRelation, Category $category)
    {
        //$this->middleware('auth');
        
        $this-> article = $article;
        $this-> tag = $tag;
        $this->tagRelation = $tagRelation;
        $this->category = $category;
        
        //$this->user = Auth::user();
    }
    
    public function index()
    {
    	
    }
    
    public function show($slug)
    {
    	//$tag = $this->tag->find($tagId);
        $tag = $this->tag->where('slug', $slug)->first();
    
    	$tagRs = TagRelation::where('tag_id', $tag->id)
               ->orderBy('id', 'desc')
               //->take(30)
               ->get();
        
        $ids = array();
        foreach($tagRs as $tagR ) {
        	$ids[] = $tagR->atcl_id;
        }
        
        $tagPosts = $this->article->find($ids);
        
        //Count
		$view = $tag->view_count;
        $view++;
        $tag->view_count = $view;
        $tag->save();
        
        //getArg
        $arg = $this->getArgForView(); //extract??
        extract($arg);
        
        $rankName = 'タグ:'.$tag->name;
        
        return view('main.tag.show', ['tagPosts'=>$tagPosts, 'tagName'=>$tag->name, 'posts'=>$posts, 'ranks'=>$ranks, 'tagRanks'=>$tagRanks, 'cates'=>$cates, 'rankName'=>$rankName]);
    }
    
    
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
    
}
