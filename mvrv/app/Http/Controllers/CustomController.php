<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Tag;
use App\TagGroup;
use App\TagRelation;
use App\Fix;

use Illuminate\Http\Request;

class CustomController extends Controller
{
	
    public function __construct(Article $article, Category $category, Tag $tag)
    {
    	$this->article = $article;
        $this->category = $category;
        $this->tag = $tag;
        //$this->fix = $fix;
        
	}
    
    
    static function changeDate($arg, $rel=0)
    {
    	if(!$rel)
	        return date('Y/m/d H:i', strtotime($arg));
        else
        	return date('Y/m/d', strtotime($arg));
    }
    
    
    static function getArgForView($slug, $type)
    {
//    	$posts = Article::where('open_status', 1)
//               ->orderBy('open_date', 'desc')
//               ->take(30)
//               ->get();

//        foreach($rankObjs as $obj) {
//        	$objId[] = $obj->post_id;
//            //$rankObj[] = $this->articlePost->find($obj->post_id);
//        }
//    
//    	$ranks = $this->articlePost ->find($objId)->where('open_status', 1)->take(20);
        
        //非Openのグループidを取る
        $tgIds = TagGroup::where('open_status', 0)->get()->map(function($tg){
            return $tg->id;
        })->all();
        
        //人気タグ
        $tagLeftRanks = Tag::whereNotIn('group_id', $tgIds)->where('view_count','>',0)->orderBy('view_count', 'desc')->take(10)->get();
        
        //Category
        $cateLeft = Category::all(); //open_status
        
        //TOP20
        if($type == 'tag') {
        	$tag = Tag::where('slug', $slug)->first();
            $atclIds = TagRelation::where('tag_id', $tag->id)->get()->map(function($tr){
            	return $tr->atcl_id;
            })->all();
            
            $rightRanks = Article::find($atclIds)->where('open_status', 1)->sortByDesc('view_count')->take(20);
        }
        else if($type == 'cate') {
        	$cate = Category::where('slug', $slug)->first();
        	
            $rightRanks = Article::where('cate_id', $cate->id)->orderBy('view_count','desc')->take(20)->get();
        }
        else { //all
        	$rightRanks = Article::where([
                    ['del_status', '=', '0'], ['owner_id', '>', '0'], ['open_status','=',1]
                ])
           ->orderBy('view_count', 'desc')
           ->take(20)
           ->get();
        }
        
        return compact('tagLeftRanks', 'cateLeft', 'rightRanks');
    }
    
    static function shortStr($str, $length)
    {
    	if(mb_strlen($str) > $length) {
        	$continue = '…';
            $str = mb_substr($str, 0, $length);
            $str = $str . $continue;
        }

        return $str;
    }
    
    
    static function fixList()
    {
    	$fixes = Fix::where('not_open', 0)->get();
        
        return $fixes;
    }
    
}
