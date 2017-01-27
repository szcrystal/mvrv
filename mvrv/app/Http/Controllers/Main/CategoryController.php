<?php

namespace App\Http\Controllers\Main;

use App\Category;
use App\Article;
use App\TagGroup;

use Ctm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct(Category $category, Article $article, TagGroup $tagGroup)
    {
        $this->category = $category;
        $this->article = $article;
        $this->tagGroup = $tagGroup;
        
        $this->perPage = env('PER_PAGE', 20);
	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	
        //return view('dashboard.index', ['name'=>$adminUser->name]);
    }
    
    public function show($cateSlug)
    {
    	$cate = $this->category->where('slug', $cateSlug)->first();
        //$posts = $this->article->where(['cate_id'=>$cate->id, 'open_status'=>1])->get();
        $atcls = $this->article
                    ->where(['cate_id'=>$cate->id, 'open_status'=>1, 'del_status'=>0])
                    ->whereNotIn('owner_id', [0])
                    ->orderBy('open_date','DESC')
                    ->paginate($this->perPage);
        
        //getSidebarArg
        $arg = Ctm::getArgForView($cateSlug, 'cate');
        extract($arg);

        
        //Count
		$view = $cate->view_count;
        $view++;
        $cate->view_count = $view;
        $cate->save();
        
        $rankName = 'カテゴリー:'.$cate->name;
        $groupModel = $this->tagGroup;
        
        return view('main.category.show', ['atcls'=> $atcls, 'cateName'=>$cate->name, 'tagLeftRanks'=>$tagLeftRanks, 'cateLeft'=>$cateLeft, 'rightRanks'=>$rightRanks, 'rankName'=>$rankName, 'groupModel'=>$groupModel]);
    }
    

}
