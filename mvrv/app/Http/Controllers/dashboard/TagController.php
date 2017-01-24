<?php

namespace App\Http\Controllers\dashboard;

use App\Admin;
use App\Tag;
use App\TagGroup;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
	public function __construct(Admin $admin, Tag $tag, TagGroup $tagGroup, User $user)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this->tag = $tag;
        $this->tagGroup = $tagGroup;
        $this->user = $user;
        
        $this->perPage = 30;
        
        // URLの生成
		//$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')
           //->take(10)->get();
           ->paginate($this->perPage);
        
        $groupModel = $this->tagGroup;
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.tag.index', ['tags'=>$tags, 'groupModel'=>$groupModel]);
    }
    
//    public function tagsOne()
//    {
//    	$tags = Tag::where('group', 1)->orderBy('id', 'desc')->get();
//    	
//        return view('dashboard.tag.index', ['tags'=>$tags]);
//    }
//    
//    public function tagsTwo()
//    {
//    	$tags = Tag::where('group', 2)->orderBy('id', 'desc')->get();
//    	
//        return view('dashboard.tag.index', ['tags'=>$tags]);
//    }
//    
//    public function tagsThree()
//    {
//    	$tags = Tag::where('group', 3)->orderBy('id', 'desc')->get();
//    	
//        return view('dashboard.tag.index', ['tags'=>$tags]);
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$groups = $this->tagGroup->all();
        return view('dashboard.tag.form', ['groups'=>$groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$editId = $request->input('edit_id');
        $groupId = $request->input('group_id');
        
        $rules = [
        	'group_id' => 'required',
            'name' => 'required|same_tag:'.$editId.','.$groupId.'|max:255', //same_tag-> on AppServiceProvider
            'slug' => 'required|unique:tags,slug,'.$editId.'|max:255', /* |unique:admins 注意:unique */
        ];
        
        $messages = [
            'name.required' => '「タグ名」は必須です。',
            'name.same_tag' => '「タグ名」が指定したグループの中で既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();

        if($request->input('edit_id') !== NULL ) { //update（編集）の時
            $tagModel = $this->tag->find($request->input('edit_id'));
            $upText = 'タグが更新されました';
        }
        else { //新規追加の時
        	$tagModel = $this->tag;
            $upText = 'タグが追加されました';
            $data['view_count'] = 0;
        }
        
        $tagModel->fill($data); //モデルにセット
        $tagModel->save(); //モデルからsave
        
        $id = $tagModel->id;

        return redirect('dashboard/tags/'.$id)->with('status', $upText);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tagId)
    {
        $tag = $this->tag->find($tagId);
        $groups = $this->tagGroup->all();
        
    	return view('dashboard.tag.form', ['tag'=>$tag, 'groups'=>$groups, 'tagId'=>$tagId, 'edit'=>1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
