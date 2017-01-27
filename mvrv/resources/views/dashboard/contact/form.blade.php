@extends('layouts.appDashBoard')

@section('content')
	
	<h2 class="page-header">問い合わせ編集</h2>
    
    	@if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!!</strong> 追加できません<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        

        
    <div class="well">{{-- col-lg-8 --}}
    	@if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/contacts/{{$id}}">

            {{ csrf_field() }}

            {{ method_field('PUT') }}

			<div class="bs-component clearfix">
                <div class="pull-left">
                    <a href="{{ url('/dashboard/contacts') }}" class="btn btn-success btn-sm"><span class="octicon octicon-triangle-left"></span>一覧へ戻る</a>
                </div>
            </div>

            <div class="panel-body">

            	<div class="table-responsive">
                    	<table class="table table-bordered">
                            <colgroup>
                                <col class="cth">
                                <col style="background: #fefefe;" class="ctd">
                            </colgroup>
                            
                            <tbody>
                                <tr>
                                    <th>問合わせ日</th>
                                    <td>{{-- date('Y/n/d H:i', strtotime($contact->created_at)) --}}
										{{ Ctm::changeDate($contact->created_at) }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>カテゴリー</th>
                                    <td>{{ $contact->ask_category }}</td>
                                </tr>
                                <tr>
                                    <th>削除記事ID</th>
                                    <td>{{ $contact->delete_id }}</td>
                                </tr>
                                <tr>
                                    <th>削除記事タイトル</th>
                                    <td>
                                    @if($contact->delete_id)
                                    {{ $atcl->find($contact->delete_id)->title }}
                                    @endif
                                    </td>
                                </tr>
                                <tr>
									<th>名前</th>
                                    <td>{{ $contact->user_name }}</td>
                                </tr>
                                <tr>
                                    <th>メールアドレス</th>
                                    <td>{{ $contact->user_email }}</td>
                                </tr>
                                <tr>
                                    <th>テキスト</th>
                                    <td>{{ $contact->context }}</td>
                                </tr>
                                <tr>
                                    <th>対応状況</th>
                                    <td>
										<div class="form-group{{ $errors->has('done_status') ? ' has-error' : '' }}">
                                            <div class="col-md-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="done_status" value="1"{{isset($contact) && $contact->done_status ? ' checked' : '' }}> 対応済みにする
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>

                                </tr>
                                

                            </tbody>
                		</table>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary center-block w-btn">更　新</button>
                        </div>
                    </div>


        	</div>

        </form>


    </div>

@endsection
