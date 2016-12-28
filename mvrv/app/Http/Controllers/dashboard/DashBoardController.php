<?php

namespace App\Http\Controllers;

use App\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashBoardController extends Controller
{

	public function __construct(Admin $admin)
    {
    	
        //$this -> middleware('admin');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('user.profile', ['user' => User::findOrFail($id)]);
    }
    
    
    
    public function getRegist () {
    	return view('dashboard.register');
    }
    
    public function postRegist(Request $request) {
        
    	//$admin = new Admin;
        
    	$rules = [
            'admin_name' => 'required|max:255',
            'admin_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
            'admin_password' => 'required|min:6',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        //$admin->fill($data); //モデルにセット
        //$admin->save(); //モデルからsave
        
        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
		$admin = Admin::create([
            'admin_name' => $data['admin_name'],
			'admin_email' => $data['admin_email'],
			'admin_password' => bcrypt($data['admin_password']),
            //'admin' => 99,
		]);
        
        return view('dashboard.register', ['status'=>'管理者:'.$data['admin_name'].'さんが追加されました。']);
    	
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
