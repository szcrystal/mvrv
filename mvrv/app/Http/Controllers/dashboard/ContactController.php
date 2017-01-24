<?php

namespace App\Http\Controllers\dashboard;

use App\Admin;
use App\Article;
use App\Tag;
use App\User;
use App\Contact;
use App\ContactCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
	public function __construct(Admin $admin, Article $article, Tag $tag, User $user, Contact $contact, ContactCategory $category)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> article = $article;
        $this->user = $user;
        $this->contact = $contact;
        $this->category = $category;
        
        // URLの生成
		//$url = route('dashboard');
        
	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = //Article::where('active', 1)
           Contact::orderBy('id', 'desc')
           //->take(10)
           ->get();
        
        $atcl = $this->article;
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.contact.index', ['contacts'=>$contacts, 'atcl'=>$atcl]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    //cate一覧
    public function create()
    {
        $cates = $this->category->all();
        
        return view('dashboard.contact.addCate', ['cates'=>$cates]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    //cate追加（Post）
    public function store(Request $request)
    {
        $rules = [
//            'admin_name' => 'required|max:255',
//            'admin_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
//            'admin_password' => 'required|min:6',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        $this->category->fill($data);
        $this->category->save();
        
        return redirect('dashboard/contacts/create')->with('status', 'お問合せカテゴリーが追加されました');
    }
    
    //cate編集
    public function getEditCate($cateId)
    {
    	$cate = $this->category->find($cateId);
        
        return view('dashboard.contact.editCate', ['cate'=>$cate, 'cateId'=>$cateId]);
    }
    
    //cate編集（Post）
    public function postEditCate(Request $request, $cateId)
    {
    	$cate = $this->category->find($cateId);
        $cate->category = $request->input('category');
        $cate->save();
        
        
        return view('dashboard.contact.editCate', ['cate'=>$cate, 'cateId'=>$cateId, 'status'=>'カテゴリーが更新されました']);
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
        $contact = $this->contact->find($id);
        $atcl = $this->article;
        
    	return view('dashboard.contact.form', ['contact'=>$contact, 'id'=>$id, 'atcl'=>$atcl]);
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
        
        //$data = $request->all(); //requestから配列として$dataにする
        
        if(! isset($request->done_status)) {
        	$status = 0;
        }
        else {
        	$status = 1;
        }
        
        $contactModel = $this->contact->find($id);
        
        $contactModel->done_status = $status;
        $contactModel->save();
        
        return redirect('dashboard/contacts/'.$id.'/edit')->with('status', '対応状況が更新されました！');
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
