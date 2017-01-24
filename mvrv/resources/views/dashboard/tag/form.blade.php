@extends('appDashBoard')

@section('content')
	
	<h2 class="page-header"><span class="mega-octicon octicon-repo">
	@if(isset($edit))
    タグ情報編集
	@else
	タグ新規追加
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

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/tags">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$tagId}}">
            @endif

            {{ csrf_field() }}

			<div class="bs-component clearfix">
                <div class="pull-left">
                    <a href="{{ url('/dashboard/tags') }}" class="btn btn-success btn-sm"><span class="octicon octicon-triangle-left"></span>一覧へ戻る</a>
                </div>
            </div>

            <div class="panel-body">
            	<div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                    <label for="group" class="col-md-4 control-label">グループ</label>

                    <div class="col-md-6">
                        <select class="form-control" name="group_id">

                            @foreach($groups as $group)
                            	@if(old('group_id') !== NULL)
									<option value="{{ $group->id }}"{{ old('group_id') == $group->id ? ' selected' : '' }}>{{ $group->name }}</option>
                                @else
                                	<option value="{{ $group->id }}"{{ isset($tag) && $tag->group_id == $group->id ? ' selected' : '' }}>{{ $group->name }}</option>
                                @endif
                            @endforeach

                        </select>

                        @if ($errors->has('group_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('group_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">タグ名</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') === NULL && isset($tag) ? $tag->name : old('name') }}" required>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                    <label for="slug" class="col-md-4 control-label">スラッグ</label>

                    <div class="col-md-6">
                        <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug') === NULL && isset($tag) ? $tag->slug : old('slug') }}" required>

                        @if ($errors->has('slug'))
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
