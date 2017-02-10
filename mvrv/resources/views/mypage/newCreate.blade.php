@extends('layouts.appSingle')

@section('content')

    <div class="row">
        <div class="col-md-12 py-4 mp-create">

            <a href="{{url()->previous()}}" class="back-btn"><i class="fa fa-angle-double-left" aria-hidden="true"></i>
			@if(isset($atcl))
            編集ページへ戻る
            @else
			マイページへ戻る
            @endif
            </a>

            <div class="panel panel-default mt-4">

                <div class="panel-heading">
                	@if(isset($atcl))
					<h2 class="h2">{{$atcl->title}} 基本情報を編集</h2>
                    @else
                	<h2 class="h2">新しい記事を作成</h2>
                    <p>最初に基本情報から入力して下さい。</p>
                    @endif
                </div>

                <div class="panel-body col-md-11 mx-auto">

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

				@if(session('status'))
                	<div class="alert alert-success">
					{{ session('status') }}
                    </div>
                @endif

                    <form class="form-horizontal" role="form" method="POST" action="/mypage/base" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="user_id" value="{{$userId}}">
                        <input type="hidden" name="atcl_id" value="{{ isset($atcl) ? $atcl->id : 0 }}">

						<div class="clearfix">
                            <div class="float-right">
                            	<div class="form-group float-left">
                                <div>
                                    <input type="submit" class="btn btn-primary px-5 py-2" name="keep" value="保存する">
                                </div>
                                </div>

                            </div>
                        </div>


                        <div class="row clearfix mt-3 mb-5 base-wrap">
                            <div class="form-group col-md-10{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="">動画タイトル</label>
                                    <input id="title" type="text" class="form-control" name="title" value="{{ isset($atcl) ? $atcl->title : old('title') }}">

                                    @if ($errors->has('title'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('movie_site') ? ' has-error' : '' }}">
                                <label for="movie_site" class="control-label">動画サイト</label>
                                <input id="movie_site" type="text" class="form-control" name="movie_site" value="{{ isset($atcl) ? $atcl->movie_site : old('movie_site') }}" placeholder="youtubeやniconico、vimeoなど">

                                @if ($errors->has('movie_site'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('movie_site') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-md-10{{ $errors->has('movie_url') ? ' has-error' : '' }}">
                                <label for="movie_url" class="control-label">動画URL</label>
                                    <input id="movie_url" type="text" class="form-control" name="movie_url" value="{{ isset($atcl) ? $atcl->movie_url : old('movie_url') }}">

                                    @if ($errors->has('movie_url'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('movie_url') }}</strong>
                                        </span>
                                    @endif
                            </div>

                            <div class="form-group col-md-5{{ $errors->has('cate_id') ? ' has-error' : '' }}">
                                <label for="cate_id" class="control-label">カテゴリー</label>
                                    <select class="form-control" name="cate_id">
                                        <option disabled selected>選択</option>
                                        @foreach($cates as $cat)
                                            <option value="{{ $cat->id }}"{{ isset($atcl) && $atcl->cate_id == $cat->id ? ' selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('cate_id'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('cate_id') }}</strong>
                                        </span>
                                    @endif
                            </div>

                        </div>


                    </form>

                </div>


            </div>
        </div>
    </div>
@endsection
