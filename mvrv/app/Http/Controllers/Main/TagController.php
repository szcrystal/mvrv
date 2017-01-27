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
    
    public function index(Request $request)
    {
    	$groupSlug = $request->path();
    	$group = $this->tagGroup->where('slug', $groupSlug)->first();

        $groupId = $group->id;
        $groupName = $group->name;
        
        $tagIds = $this->tag->where('group_id', $groupId)->get()->map(function($tg){
            return $tg->id;
        })->all();
        
        $atclIds = $this->tagRelation->whereIn('tag_id', $tagIds)->get()->map(function($tr){
            return $tr->atcl_id;
        })->all();
        
        
        $atcls = $this-> article->whereIn('id', $atclIds)->where([
                    ['del_status', '=', 0], ['open_status','=',1], ['owner_id', '>', 0]
                ])->orderBy('open_date','DESC')->paginate($this->perPage);
        
        //getArg
        $arg = Ctm::getArgForView('', 'all');
        extract($arg);
        
        $rankName = '全体'; /* ******** */
        $groupModel = $this->tagGroup;
        
        return view('main.tag.index', ['atcls'=>$atcls, 'groupName'=>$groupName, 'tagLeftRanks'=>$tagLeftRanks, 'cateLeft'=>$cateLeft, 'rightRanks'=>$rightRanks, 'rankName'=>$rankName, 'groupModel'=>$groupModel]);
    
    }
    
    public function show($tagSlug)
    {
    	//$group = $this->tagGroup->where('slug', $groupSlug)->first();
        $tag = $this->tag->where('slug', $tagSlug)->first();
        
        //Error
        if(!isset($tag)) {
        	abort(404);
        }
    
    	$tagIds = TagRelation::where('tag_id', $tag->id)->get()->map(function($tr){
        	return $tr->atcl_id;
        })->all();
        
        $atcls = $this->article->whereIn('id', $tagIds)->where([
        	['del_status', '=', 0], ['open_status','=',1], ['owner_id', '>', 0]
        ])->orderBy('open_date','DESC')->paginate($this->perPage);
        
        
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
        
        return view('main.tag.show', ['atcls'=>$atcls, 'tagName'=>$tag->name, 'tagLeftRanks'=>$tagLeftRanks, 'cateLeft'=>$cateLeft, 'rightRanks'=>$rightRanks, 'rankName'=>$rankName, 'groupModel'=>$groupModel, 'groupName'=>$groupName]);
    }
    
}

