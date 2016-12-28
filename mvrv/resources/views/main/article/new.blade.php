@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">記事情報の追加</div>
				@if(isset($status))
					<p>{{ $status }}</p>
                @endif
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="">
                        {{ csrf_field() }}

						<input type="hidden" name="user_id" value="{{ $userId }}">

						<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="open_status" value="1"> 公開する
                                    </label>
                                </div>
                            </div>
                        </div>


                        <p>記事内容 ----------</p>

						<div class="form-group{{ $errors->has('story_title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">タイトル</label>

                            <div class="col-md-6">
                                <input id="story_title" type="text" class="form-control" name="story_title" value="{{ old('story_title') }}" required autofocus>

                                @if ($errors->has('story_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('story_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('story_sub_title') ? ' has-error' : '' }}">
                            <label for="story_sub_title" class="col-md-4 control-label">オプション（サブタイトル？）</label>

                            <div class="col-md-6">
                                <input id="story_sub_title" type="text" class="form-control" name="story_sub_title" value="{{ old('story_sub_title') }}" required autofocus>

                                @if ($errors->has('story_sub_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('story_sub_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('story_text') ? ' has-error' : '' }}">
                            <label for="story_text" class="col-md-4 control-label">テキスト</label>

                            <div class="col-md-6">
                                <textarea id="story_text" type="text" class="form-control" name="story_text" value="{{ old('story_text') }}" required></textarea>

                                @if ($errors->has('story_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('story_text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <p>画像 -----------</p>
                        <div class="form-group{{ $errors->has('image_title') ? ' has-error' : '' }}">
                            <label for="image_title" class="col-md-4 control-label">画像タイトル</label>

                            <div class="col-md-6">
                                <input id="image_title" type="text" class="form-control" name="image_title" value="{{ old('image_title') }}" required autofocus>

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
                                <input id="image_path" type="text" class="form-control" name="image_path" value="{{ old('image_path') }}" required autofocus>

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
                                <input id="image_url" type="text" class="form-control" name="image_url" value="{{ old('image_url') }}" required autofocus>

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
                                <textarea id="image_comment" type="text" class="form-control" name="image_comment" value="{{ old('image_comment') }}" required></textarea>

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
                                <input id="link_title" type="text" class="form-control" name="link_title" value="{{ old('link_title') }}" required autofocus>

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
                                <input id="link_url" type="text" class="form-control" name="link_url" value="{{ old('link_url') }}" required autofocus>

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
                                <input id="link_image_url" type="text" class="form-control" name="link_image_url" value="{{ old('link_image_url') }}" required autofocus>

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
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    送信
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
