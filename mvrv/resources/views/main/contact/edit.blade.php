@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        	<a href="/mypage">戻る</a>
            <div class="panel panel-default">
                <div class="panel-heading"><h3>{{ $atcl->title }} に記事を書く</h3></div>
				@if(session('status'))
					<p>{{ session('status') }}</p>
                @endif
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/mypage{{isset($post) ? '/'.$post->id : ''}}">
                        {{ csrf_field() }}

                        @if(isset($post))
                        {{ method_field('PUT') }}
                        @else
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="base_id" value="{{ $atcl->id }}">
                        @endif

                        <p>記事内容 ----------</p>

						<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">タイトル</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ isset($post) ? $post->title : old('title') }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('sub_title') ? ' has-error' : '' }}">
                            <label for="sub_title" class="col-md-4 control-label">オプション（サブタイトル？）</label>

                            <div class="col-md-6">
                                <input id="sub_title" type="text" class="form-control" name="sub_title" value="{{ isset($post) ? $post->sub_title :old('sub_title') }}" required autofocus>

                                @if ($errors->has('sub_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sub_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                            <label for="text" class="col-md-4 control-label">テキスト</label>

                            <div class="col-md-6">
                                <textarea id="text" type="text" class="form-control" name="text" required>{{ isset($post) ? $post->text : old('text') }}</textarea>

                                @if ($errors->has('text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <p>画像 -----------</p>
                        <div class="form-group{{ $errors->has('image_title') ? ' has-error' : '' }}">
                            <label for="image_title" class="col-md-4 control-label">画像タイトル</label>

                            <div class="col-md-6">
                                <input id="image_title" type="text" class="form-control" name="image_title" value="{{ isset($post) ? $post->image_title : old('image_title') }}" required autofocus>

                                @if ($errors->has('image_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image_path') ? ' has-error' : '' }}">
                            <label for="image_path" class="col-md-4 control-label">画像パス</label>

                            <div class="col-md-6">
                                <input id="image_path" type="text" class="form-control" name="image_path" value="{{ isset($post) ? $post->image_path : old('image_path') }}" required autofocus>

                                @if ($errors->has('image_path'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image_path') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image_url') ? ' has-error' : '' }}">
                            <label for="image_url" class="col-md-4 control-label">引用元URL</label>

                            <div class="col-md-6">
                                <input id="image_url" type="text" class="form-control" name="image_url" value="{{ isset($post) ? $post->image_url : old('image_url') }}" required autofocus>

                                @if ($errors->has('image_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image_comment') ? ' has-error' : '' }}">
                            <label for="image_comment" class="col-md-4 control-label">コメント</label>

                            <div class="col-md-6">
                                <textarea id="image_comment" type="text" class="form-control" name="image_comment" value="" required>{{ isset($post) ? $post->image_comment : old('image_comment') }}</textarea>

                                @if ($errors->has('image_comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image_comment') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <p>リンク -----------</p>
                        <div class="form-group{{ $errors->has('link_title') ? ' has-error' : '' }}">
                            <label for="link_title" class="col-md-4 control-label">リンクタイトル</label>

                            <div class="col-md-6">
                                <input id="link_title" type="text" class="form-control" name="link_title" value="{{ isset($post) ? $post->link_title : old('link_title') }}" required autofocus>

                                @if ($errors->has('link_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('link_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('link_url') ? ' has-error' : '' }}">
                            <label for="link_url" class="col-md-4 control-label">リンクURL</label>

                            <div class="col-md-6">
                                <input id="link_url" type="text" class="form-control" name="link_url" value="{{ isset($post) ? $post->link_url : old('link_url') }}" required autofocus>

                                @if ($errors->has('link_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('link_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('link_image_url') ? ' has-error' : '' }}">
                            <label for="link_image_url" class="col-md-4 control-label">画像URL</label>

                            <div class="col-md-6">
                                <input id="link_image_url" type="text" class="form-control" name="link_image_url" value="{{ isset($post) ? $post->link_image_url : old('link_image_url') }}" required autofocus>

                                @if ($errors->has('link_image_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('link_image_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('link_option') ? ' has-error' : '' }}">
                                <label for="link_option" class="col-md-4 control-label">オプション</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="link_option">
                                        <option value="通常リンク">通常リンク</option>
                                        <option value="タイプA">ボタンタイプA</option>
                                        <option value="タイプB">ボタンタイプB</option>
                                    </select>

                                    @if ($errors->has('link_option'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('link_option') }}</strong>
                                    </span>
                                	@endif
                                </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="open_status" value="1" {{isset($post) && $post->open_status ? 'checked' : '' }}> 公開する
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
