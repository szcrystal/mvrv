@extends('layouts.appSingle')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                @if($atcl->owner_id)
					<p>この動画のオーナーが他のユーザーに決まりました。<br>他の動画を選択してください。<br><a href="/mypage">戻る</a></p>
				@else

                <div class="panel-heading">
                	<h3>{{ $atcl->title }} に記事を書く</h3>
                </div>

				@if(session('status'))
                	<div class="alert alert-success">
					{{ session('status') }}
                    </div>
                @endif

                <div class="panel-body">

                    @if($atcl -> movie_url != '')
                        <?php $embed = explode('=', $atcl -> movie_url); ?>

                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$embed[1]}}" frameborder="0" allowfullscreen></iframe>

                    @endif

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
                                <tr>
                                    <th>タグ１</th>
                                    <td><?php if(!$tags[0]->isEmpty()) {
                                        foreach($tags[0] as $tag)
                                            echo '<a href="'. url('/tag/'.$tag->id).'">'.$tag->name .'</a>, ';
                                    } ?></td>
                                </tr>
                                <tr>
                                    <th>タグ２</th>
                                    <td><?php if(!$tags[1]->isEmpty()) {
                                        foreach($tags[1] as $tag)
                                            echo '<a href="'. url('/tag/'.$tag->id).'">'.$tag->name .'</a>, ';
                                    } ?></td>
                                </tr>
                                <tr>
                                    <th>タグ３</th>
                                    <td><?php if(!$tags[2]->isEmpty()) {
                                        foreach($tags[2] as $tag)
                                            echo '<a href="'. url('/tag/'.$tag->id).'">'.$tag->name .'</a>, ';
                                    } ?></td>
                                </tr>
                                

                            </tbody>
                		</table>
                    </div>



					<div style="margin-top: 3em;">
                    <form class="form-horizontal" role="form" method="POST" action="/mypage">
                        {{ csrf_field() }}

                        <input type="hidden" name="user_id" value="{{$userId}}">
                        <input type="hidden" name="base_id" value="{{ $atcl->id }}">

                        <input type="hidden" name="tag_id_1" value="{{ $atcl -> tag_1 }}">
                        <input type="hidden" name="tag_id_2" value="{{ $atcl -> tag_2 }}">
                        <input type="hidden" name="tag_id_3" value="{{ $atcl -> tag_3 }}">


                        <p>ユーザー編集　未実装 ----------</p>
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">サムネイル</label>

                            <div class="col-md-6">
                            	サムネイルUP
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

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">タグ２（俳優）</label>

                            <div class="col-md-6">
                                <input id="tag_2" type="text" class="form-control" name="tag_2" value="{{ old('tag_2') }}" required>

                                @if ($errors->has('tag_2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tag_2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">タグ３（スタッフ）</label>

                            <div class="col-md-6">
                                <input id="tag_3" type="text" class="form-control" name="tag_3" value="{{ old('tag_3') }}" required autofocus>

                                @if ($errors->has('tag_3'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tag_3') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


						{{--
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
                        --}}

						{{--
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
                        --}}

                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="text" class="col-md-4 control-label">コンテンツ</label>

                            <div class="col-md-6">
                                <textarea id="text" type="text" class="form-control" name="content" required>{{ isset($atcl) ? $atcl->content : old('content') }}</textarea>

                                @if ($errors->has('content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

						{{--
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
                        --}}

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
                            <div style="margin-bottom: 1em;" class="col-md-8 col-md-offset-4">
                                <input type="submit" class="btn btn-primary" name="keep" value="保存する">
                            </div>

                            <div class="col-md-8 col-md-offset-4">
                                <input type="submit" class="btn btn-danger" name="open" value="公開する">
                            </div>
                        </div>
                    </form>
                    </div>

                    
                </div>

            @endif

            </div>
        </div>
    </div>
</div>
@endsection
