@extends('layouts.appSingle')

@section('content')

<?php //print_r($_SERVER); ?>

<div class="container mp-create">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        	<a href="{{url('mypage/newmovie')}}">戻る</a>
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

                            </tbody>
                		</table>
                    </div>


					<div style="margin-top: 3em;">
                    <form class="form-horizontal" role="form" method="POST" action="/mypage" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="user_id" value="{{$userId}}">
                        <input type="hidden" name="atcl_id" value="{{ $atcl->id }}">


                        <div style="margin-bottom: 2em;" class="clear">
                            <div style="width: 170px; height:170px; border: 1px solid #ccc;" class="pull-left col-md-3">
                                No Image
                            </div>

                            <div class="pull-left col-md-9">
                                <div class="form-group{{ $errors->has('thumbnail') ? ' has-error' : '' }}">
                                    <label for="thumbnail" class="col-md-4 control-label">サムネイル</label>

                                    <div class="col-md-8">
                                        <input id="thumbnail" type="file" name="thumbnail">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('thumbnail_org') ? ' has-error' : '' }}">
                                    <label for="thumbnail_org" class="col-md-4 control-label">サムネイル引用元URL</label>
                                    <div class="col-md-8">
                                        <input id="thumbnail_org" type="text" class="form-control" name="thumbnail_org" value="{{old('thumbnail_org') }}">

                                        @if ($errors->has('thumbnail_org'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('thumbnail_org') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>



                        @foreach($tagGroupAll as $group)
                        	<?php $allNames = array(); ?>

                            @foreach($tags[$group->id] as $tag)
                                <?php $allNames[] = $tag['name']; ?>
                            @endforeach


                        	<div class="tag-group form-group{{ $errors->has($group->slug) ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">{{ $group->name }}</label>
                                <div class="col-md-4 clearfix">
                                    <input id="{{ $group->slug }}" type="text" class="form-control tag-control" name="input-{{ $group->slug }}" value="{{ old($group->slug) }}" autocomplete="off">

                                    <div class="add-btn" tabindex="0">追加</div>

                                    <span style="display:none;">{{ implode(',', $allNames) }}</span>

                                    <div class="tag-area"></div>

                                </div>

                            </div>

                        @endforeach

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
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="open_status" value="1" {{isset($post) && $post->open_status ? 'checked' : '' }}> 公開する
                                    </label>
                                </div>
                            </div>
                        </div>
                        --}}

                        <div class="col-md-offset-4 clearfix">
                            <div style="margin-bottom: 1em;" class="col-md-3 pull-left">
                                <input type="submit" class="btn btn-primary" name="keep" value="保存する">
                            </div>

                            <div class="col-md-2 pull-left">
                                <input type="submit" class="btn btn-danger" name="open" value="公開する">
                            </div>
                        </div>


                <div class="add-item">
                	<div class="visible-none">
                        @include('mypage.shared.itemCtrlNav')

                        @include('mypage.shared.newItemForm')
                    </div>

                    @include('mypage.shared.newItemForm')
                    {{-- <div class="item-panel first-panel"> --}}



                </div><?php /*addItem*/ ?>



                    </form>
                    </div>

                    
                </div>

            @endif

            </div>
        </div>
    </div>
</div>
@endsection
