<?php

namespace App\Http\Controllers\dashboard;

use App\Tag;
use App\TagGroup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagGroupController extends Controller
{
	public function __construct(Tag $tag, TagGroup $tagGroup)
    {
    	$this->tag = $tag;
        $this->tagGroup = $tagGroup;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = TagGroup::orderBy('id', 'desc')
           //->take(10)
           ->get();
        
        return view('dashboard.tagGroup.index', ['groups'=>$groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.tagGroup.form');
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
        
        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required|unique:tag_groups,slug,'.$editId.'|max:255', /* |unique:admins 注意:unique */
        ];
        
        $messages = [
            'name.required' => '「グループ名」は必須です。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all(); //requestから配列として$dataにする
        

        if(! isset($data['open_status'])) { //checkbox
        	$data['open_status'] = 0;
        }
        

        if($request->input('edit_id') !== NULL ) { //update（編集）の時
        	$status = 'タググループが更新されました！';
            $groupModel = $this->tagGroup->find($request->input('edit_id'));
        }
        else { //新規追加の時
            $status = 'タググループが追加されました！';
        	$groupModel = $this->tagGroup;
        }
        
        $groupModel->fill($data); //モデルにセット
        $groupModel->save(); //モデルからsave
        
        $id = $groupModel->id;

        return redirect('dashboard/taggroups/'.$id)->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = $this->tagGroup->find($id);
        
    	return view('dashboard.tagGroup.form', ['group'=>$group, 'id'=>$id, 'edit'=>1]);
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
