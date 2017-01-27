@extends('layouts.appDashBoard')

@section('content')
	
	<h2 class="page-header"><span class="mega-octicon octicon-repo">
    ユーザー編集
    </h2>
    
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
    	@if (isset($status))
            <div class="alert alert-success">
                {{ $status }}
            </div>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/users/{{$user->id}}">
        	{{ method_field('PUT') }}

            {{ csrf_field() }}

			<div class="bs-component">
                <div class="pull-left">
                    <a href="{{ url('/dashboard/users') }}" class="btn btn-success btn-sm"><span class="octicon octicon-triangle-left"></span>一覧へ戻る</a>
                </div>

            </div>

            <div class="panel-body">


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="active" value="1"{{isset($user) && ! $user->active ? ' checked' : '' }}> 無効にする
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category" class="col-md-4 control-label">名前</label>

                            <div class="col-md-6">
                                {{ $user->name}}
                            </div>
                    </div>

                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">メールアドレス</label>

                            <div class="col-md-6">
                                {{ $user->email }}
                            </div>
                        </div>

						<div class="form-group{{ $errors->has('sumbnail') ? ' has-error' : '' }}">
                            <label for="sumbnail" class="col-md-4 control-label">登録日</label>

                            <div class="col-md-6">
								{{ date('Y/n/j H:m', strtotime($user->created_at)) }}
                            </div>
                        </div>



          <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>更　新</button>
            </div>
        </div>

        </form>

    </div>
    
    @if(isset($article))
        <div class="well clearfix">
            <div class="pull-left">
                <a href="{{ url('/dashboard/articles') }}" class="btn btn-success btn-sm"><span class="octicon octicon-triangle-left"></span>一覧へ戻る</a>
            </div>
            <div class="pull-right">{{-- col-md-offset-10 --}}
                <a href="{{ url('/dashboard/article/'.$article->id.'/delete/') }}" class="btn btn-danger btn-sm"><span class="octicon octicon-trashcan"></span>この記事を削除する</a>
            </div>
        </div>
    @endif

@endsection
