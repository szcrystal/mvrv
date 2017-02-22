<?php

namespace App\Http\Controllers\dashboard;

use App\Admin;
use App\User;
use App\Article;
use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	public function __construct(Admin $admin, User $user, Article $article)
    {
        $this -> middleware('adminauth');
        //$this->middleware('auth:admin', ['except' => 'index']);
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this->user = $user;
        $this->article = $article;
        
        $this->perPage = 20;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate($this->perPage);
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.user.index', ['users'=>$users]);
    }
    
    public function userLogin($userId)
    {
    	Auth::loginUsingId($userId);
        return redirect('/');
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
        $user = $this->user->find($id);
        
//        echo $article->tag_1. "aaaaa";
//        foreach($tags[0] as $tag)
//        	echo $tag-> id."<br>";
//        exit();
        
    	return view('dashboard.user.form', ['user'=>$user]);
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
    	$user = $this->user->find($id);
        $data = $request->all(); //requestから配列として$dataにする
        
        if(! isset($data['active'])) {
        	$data['active'] = 1;
        }
        else {
        	$data['active'] = 0;
        }
        
        $user->active = $data['active'];
        $user->save();
        
        //$active = $user->active;
        
        return view('dashboard.user.form', ['user'=>$user, 'status'=>'ユーザー情報が更新されました']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$user = $this->user->find($id);
        $userId = $user->id;
        
        $atcls = $this->article->where('owner_id', $user->id)->get()->map(function($atcl){
        	$atcl->owner_id = 1;
            $atcl->save();
        });
        
        
        $userDel = $this->user->destroy($id); //article del
        
        $status = $userDel ? '記事「'. $user->name.'」が削除されました' : '記事「'.$user->name.'」が削除出来ませんでした';
        
        return redirect('dashboard/users')->with('status', $status);
    }
}
