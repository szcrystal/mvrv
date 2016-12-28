@extends('layouts.appSingle')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        	<a href="/mypage">戻る</a>
            <div class="panel panel-default">
                <div class="panel-heading"><h3>{{ $atcl->title }} の記事を編集</h3></div>
				@if(session('status'))
					<div class="alert alert-success">
                    {{ session('status') }}
                    </div>
                @endif
                <div class="panel-body">
					<div class="table-responsive">
                    	<table class="table table-striped table-bordered">
                            <colgroup>
                                <col class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <tbody>
                                <tr>
                                    <th>動画タイトル</th>
                                    <td>{{ $atcl -> title }}</td>
                                </tr>
                                <tr>
                                    <th>カテゴリー</th>
                                    <td>{{ $cate->name }}</td>
                                </tr>
                                <tr>
									<th>動画サイト</th>
                                    <td>{{ $atcl -> movie_site }}</td>
                                </tr>
                                <tr>
									<th>動画URL</th>
                                    <td><a href="{{ $atcl -> movie_url }}">{{ $atcl -> movie_url }}</a></td>
                                </tr>

                                

                            </tbody>
                		</table>
                    </div>



                    <form class="form-horizontal" role="form" method="POST" action="/mypage/{{ $atcl->id }}">
                        {{ csrf_field() }}

                        {{ method_field('PUT') }}

						<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">サムネイル</label>

                            <div class="col-md-6">
                                サムネイルアップ
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tag_1') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">タグ１（キーワード）</label>

                            <div class="col-md-6">
                                <input id="tag_1" type="text" class="form-control" name="tag_1" value="{{ old('title') }}" required>

                                @if ($errors->has('tag_1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tag_1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="text" class="col-md-4 control-label">テキスト</label>

                            <div class="col-md-6">
                                <textarea id="text" type="text" class="form-control" name="content" required>{{ isset($atcl) ? $atcl->content : old('content') }}</textarea>

                                @if ($errors->has('content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>




                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="open_status" value="1" {{isset($atcl) && $atcl->open_status ? 'checked' : '' }}> 公開する
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    保存
                                </button>

                            </div>
                        </div>
                    </form>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
