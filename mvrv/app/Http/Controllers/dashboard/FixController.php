<?php

namespace App\Http\Controllers\dashboard;

use App\Fix;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FixController extends Controller
{
	public function __construct(Fix $fix)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> fix = $fix;
        
        
        $this->perPage = 20;
        
	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fixes = Fix::orderBy('id', 'desc')->paginate($this->perPage);
        
        return view('dashboard.fix.index', ['fixes'=>$fixes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.fix.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$edit_id = $request->input('edit_id') !== FALSE ? $request->input('edit_id') : 0;
    	
        $exceptId = $edit_id ? ','.$edit_id : '';
        $rules = [
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:fixes,slug'.$exceptId,
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする

        if(! isset($data['not_open'])) { //checkbox
        	$data['not_open'] = 0;
        }
        
        //$data['up_date'] = $request->input('up_year'). '-' .$request->input('up_month') . '-' . $request->input('up_day');
//        $data['up_date'] = '2017-01-01 11:11:11';
//        $data['sumbnail'] = '/images/abc.jpg';
//        $data['sumbnail_url'] = 'http://example.com';
        
//        foreach($data as $key=>$val) { //checkboxの複数選択をカンマ区切りにする
//        	if(is_array($val))
//            	$data[$key] = implode(',', $val);
//        }
        
        //tagのチェックが一つもされていない時、Undefinedになるので空をセットする
//        $n = 0;
//        while ($n < 3) {
//        	$name = 'tag_'.($n+1);
//        	if(!isset($data[$name]))
//            	$data[$name] = '';
//            
//            $n++;
//        }

        if($request->input('edit_id') !== NULL ) { //update（編集）の時
            $fixModel = $this->fix->find($request->input('edit_id'));
            $status = '静的ページが更新されました！';
        }
        else { //新規追加の時
            $status = '静的ページが追加されました！';
        	$fixModel = $this->fix;
        }
        
        $fixModel->fill($data); //モデルにセット
        $fixModel->save(); //モデルからsave
        
        $id = $fixModel->id;
    	//return view('dashboard.article.form', ['thisClass'=>$this, 'tags'=>$tags, 'status'=>'記事が更新されました。']);
        return redirect('dashboard/fixes/'.$id)->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fix = $this->fix->find($id);
        
        return view('dashboard.fix.form', ['fix'=>$fix, 'id'=>$id, 'edit'=>1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	
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
        $name = $this->fix->find($id)->title;
        $rel = $this->fix->destroy($id);
        $status = $rel ? '静的ページ「'.$name.'」が削除されました' : '静的ページ「'.$name.'」が削除出来ませんでした';
        
        return redirect('dashboard/fixes')->with('status', $status);
    }
}
