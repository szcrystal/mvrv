<?php

namespace App\Http\Controllers\Main;

use App\Article;
use App\User;
use App\Tag;
use App\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct(Article $article, User $user, Tag $tag, Category $category)
    {
        //$this->middleware('auth');
        
        $this->article = $article;
        $this->user = $user;
        $this->tag = $tag;
        $this->category = $category;
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
        
        $ranks = $atcl ->sortByDesc('view_count')->take(20);
        
//        $objId = array();
//        foreach($rankObjs as $obj) {
//        	$objId[] = $obj->post_id;
//            //$rankObj[] = $this->articlePost->find($obj->post_id);
//        }
//    	$ranks = $this->article ->find($objId)->where('open_status', 1)->take(20);
        
        $tagRanks = $this->tag->orderBy('view_count', 'desc')->take(10)->get();
        
        $cates = $this->category->all();
        
        $rankName = '全体';
    
    	return view('main.index', ['posts'=>$posts, 'ranks'=>$ranks, 'tagRanks'=>$tagRanks, 'cates'=>$cates, 'rankName'=>$rankName]);
        //return view('home');
    }
    
    public function showSingle($postId)
    {
    
    	$atcl = Article::find($postId);
        $user = User::find($atcl->owner_id);
        
        $n = 0;
        while($n < 3) {
            $str = 'tag_'. ($n+1);
            $tagIds = array();
            $tagIds = explode(',', $atcl->{$str});
            
            $tags[$n] = $this->tag->find($tagIds);
            
            $n++;
        }
        

        //Count
		$view = $atcl->view_count;
        $view++;
        $atcl->view_count = $view;
        $atcl->save();
        
        //getArg
        //$arg = $this->getArgForView();
        
    	return view('main.single', ['atcl'=>$atcl, 'user'=>$user, 'tags'=>$tags ]);
        
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
