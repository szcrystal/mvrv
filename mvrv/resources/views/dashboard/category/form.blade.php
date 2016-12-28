@extends('appDashBoard')

@section('content')
	
	<h2 class="page-header"><span class="mega-octicon octicon-repo">
	@if(isset($edit))
    カテゴリー編集
	@else
	カテゴリー新規追加
    @endif
    </span></h2>
    
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

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/categories">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

			<div class="bs-component clearfix">
                <div class="pull-left">
                    <a href="{{ url('/dashboard/categories') }}" class="btn btn-success btn-sm"><span class="octicon octicon-triangle-left"></span>一覧へ戻る</a>
                </div>
            </div>

            <div class="panel-body">

                <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="category" class="col-md-4 control-label">カテゴリー名</label>

                    <div class="col-md-6">
                        <input id="category" type="text" class="form-control" name="name" value="{{ isset($cate) ? $cate->name : old('name') }}" required autofocus>

                        @if ($errors->has('category'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                    <label for="title" class="col-md-4 control-label">スラッグ</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control" name="slug" value="{{ isset($cate) ? $cate->slug : old('slug') }}" required>

                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                        

        
            {{-- @include('dbd_shared.introContent') --}}
                      
            {{-- @include('dbd_shared.mainContent') --}}

        	{{-- @include('dbd_shared.image') --}}

          <div class="form-group">
            <div class="col-md-8 col-md-offset-2">
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