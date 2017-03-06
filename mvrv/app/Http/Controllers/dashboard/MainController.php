<?php

namespace App\Http\Controllers\dashboard;

use App\Admin;
use App\Tag;
use App\Article;
use App\Totalize;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use Illuminate\Pagination\LengthAwarePaginator;

class MainController extends Controller
{
	//protected $redirectTo = 'dashboard/login';
    
	public function __construct(Admin $admin, Tag $tag, Article $article, Totalize $totalize)
    {
    	
        $this -> middleware('adminauth'/*, ['except' => ['getRegister','postRegister']]*/);
        //$this->middleware('auth:admin', ['except' => 'getLogout']);
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> article = $article;
        $this -> totalize = $totalize;
        
        $this->perPage = 20;
        
        // URLの生成
		//$url = route('dashboard');

	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$adminUser = Auth::guard('admin')->user();
        
        $date = date('Y-m-d', time());
        $week = date('Y-m-d', strtotime('-1 week'));
        
        $dayTotal = $this->totalize->where(['view_date' => $date])->get();
        $count = $this->totalize->where(['view_date' => $date])->get()->sum('view_count');
        
        $group = $dayTotal->groupBy('atcl_id')->toArray();
        
        $obj = array();
        foreach($group as $key => $val) {
        	$ct = count($val);
            $obj[] = array('atcl_id'=>$key, 'view_date'=>$date, 'view_count'=>$ct);
        }
        
        $sort = array();
        foreach($obj as $k => $v) {
            $sort[$k] = $v['view_count'];
        }
        array_multisort($sort, SORT_DESC, $obj);
        
		//Custom Pagination
        $perPage = $this->perPage;
        $total = count($obj);
        $chunked = array();
        
        if($total) {
            $chunked = array_chunk($obj, $perPage);
            $current_page = $request->page ? $request->page : 1;
            $chunked = $chunked[$current_page - 1]; //現在のページに該当する配列を$chunkedに入れる
        }
        
        $obj = new LengthAwarePaginator($chunked, $total, $perPage); //pagination インスタンス作成
        $obj -> setPath('/dashboard'); //url pathセット
        //Custom pagination END
        
        $atcl = $this->article;
        
        return view('dashboard.index', ['name'=>$adminUser->name, 'dayTotal'=>$dayTotal, 'date'=>$date, 'count'=>$count, 'obj'=>$obj, 'atcl'=> $atcl]);
    }
    
    public function getWeekly(Request $request)
    {
        $date = date('Y-m-d', time());
        $week = date('Y-m-d', strtotime('-1 week'));
        
        $weekTotal = $this->totalize->whereBetween('view_date', [$week, $date])->orderBy('view_date','desc')->get();
        $dateGroup = $weekTotal->groupBy('view_date')->toArray();
        
        $ids = array();
        $allArr = array();
        $obj = array();
        
        foreach($dateGroup as $key => $value) {
        	$ids[$key] = array();
            $allArr[$key] = array();
            
            foreach($value as $val) {
                if(! in_array($val['atcl_id'], $ids[$key])) {
                	$allArr[$key][] = $val;
                    $ids[$key][] = $val['atcl_id'];
                }
                else {
                	foreach($allArr[$key] as $k => $v) {
                    	if($v['atcl_id'] == $val['atcl_id']) {
                        	$allArr[$key][$k]['view_count'] = $v['view_count'] + 1;
                        }
                    }
                }
            }
        }
        
        foreach($allArr as $value) {
        	$sort = array();
        	foreach($value as $k => $v) {
            	$sort[$k] = $v['view_count'];
            }
            array_multisort($sort, SORT_DESC, $value);
            $obj = array_merge($obj, $value);
        }
        
        //Custom Pagination
        $perPage = $this->perPage;
        $total = count($obj);
        $chunked = array();
        
        if($total) {
            $chunked = array_chunk($obj, $perPage);
            $current_page = $request->page ? $request->page : 1;
            $chunked = $chunked[$current_page - 1]; //現在のページに該当する配列を$chunkedに入れる
        }
        
        $obj = new LengthAwarePaginator($chunked, $total, $perPage); //pagination インスタンス作成
        $obj -> setPath('weekly'); //url pathセット
        //Custom pagination END
        

        $count = $this->totalize->whereBetween('view_date', [$week, $date])->get()->sum('view_count');
        $span = $week . ' 〜 ' . $date;
        
        $atcl = $this->article;
        
        return view('dashboard.weekly', ['atcl'=> $atcl, 'weekTotal'=>$weekTotal, 'dateGroup'=>$dateGroup, 'span'=>$span, 'count'=>$count, 'obj'=>$obj]);
    }
    
    
    public function getRegister ($id='')
    {
    	$editId = 0;
        $admin = NULL;
        
    	if($id) {
        	$editId = $id;
            $admin = $this->admin->find($id);
        }
        
    	$admins = $this->admin->paginate($this->perPage);
        
    	return view('dashboard.register', ['admins'=>$admins, 'admin'=>$admin, 'editId'=>$editId]);
    }
    
    public function postRegister(Request $request)
    {
    	$editId = $request->input('edit_id');
        $valueId = '';
        if($editId) {
        	$valueId = ','. $editId;
        }
        
    	$rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email'.$valueId, /* |unique:admins 注意:unique */
            'password' => 'required|min:8',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        if($data['edit_id']) {
        	$adminModel = $this->admin->find($data['edit_id']);
        }
        else {
        	$adminModel = $this->admin;
        }
        
        $data['password'] = bcrypt($data['password']);
        
        $adminModel->fill($data);
        $adminModel->save();
        
        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
//		$admin = Admin::create([
//            'name' => $data['name'],
//			'email' => $data['email'],
//			'password' => bcrypt($data['password']),
//            //'admin' => 99,
//		]);
        
        if($editId)
        	$status = '管理者情報を更新しました！';
        else
	        $status = '管理者:'.$data['name'].'さんが追加されました。';
        
        return redirect('dashboard/register')->with('status', $status);
    }
    
    
    public function getLogout(Request $request) {
    	//$request->session()->pull('admin');
        Auth::guard('admin')->logout();
        return redirect('dashboard/login'); //->intended('/')
    }
    
    
    public function getTags() {
    	$n = 0;
        $tags = array();
        
    	while($n < 3) { //tag取得
            $tags[] = Tag::where(['open_status'=>1, 'group'=>$n+1])
                   ->orderBy('created_at', 'id')
                   ->get();
            
            $n++;
        }
        
        return $tags;
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
