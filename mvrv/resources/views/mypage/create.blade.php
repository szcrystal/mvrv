@extends('layouts.appSingle')

@section('content')

    <div class="row">
        <div class="col-md-12 py-4 mp-create">
        	<a href="{{url('/mypage/newmovie')}}" class="back-btn"><i class="fa fa-angle-double-left" aria-hidden="true"></i> マイページへ戻る</a>
            <div class="panel panel-default mt-4">

                @if($atcl->owner_id)
					<p class="mb-4">この動画のオーナーが他のユーザーに決まりました。<br>マイページへ戻り、他の動画を取得してください。</p>
				@else

                <div class="panel-heading clearfix mb-3">
                	<h2 class="h2">{{ $atcl->title }} に記事を書く</h2>
                    <ul class="list-group col-md-5 float-left">
						<li class="list-group-item"><b>公開状態：</b>
							@if($atcl->open_status)
                            <span class="text-success">公開中</span>
                            @else
                            <span class="text-danger">非公開</span>
                            @endif
                        </li>
                        <li class="list-group-item"><b>更新日時：</b>
							@if($atcl->open_date)
                            {{ Ctm::changeDate($atcl->open_date) }}
                            @else
                            {{ Ctm::changeDate($atcl->created_at) }}
                            @endif
                        </li>
                    </ul>

                    <div class="float-right">
                    	@include('main.shared.movie')
                    </div>
                </div>

				@if(session('status'))
                	<div class="alert alert-success">
					{{ session('status') }}
                    </div>
                @endif

                <div class="panel-body mt-4">
                    <h3 class="h3"><i class="fa fa-square" aria-hidden="true"></i> 基本情報</h3>
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

                    <div class="clearfix pb-5">
						<a href="{{ url('/mypage/base/'.$atcl->id) }}" class="btn btn-info float-right">基本情報を編集 <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                    </div>

					<hr>
					<h3 class="h3"><i class="fa fa-square" aria-hidden="true"></i> 詳細情報</h3>
                    <form class="form-horizontal" role="form" method="POST" action="/mypage" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="user_id" value="{{$userId}}">
                        <input type="hidden" name="atcl_id" value="{{ $atcl->id }}">

						<div class="clearfix">
                            <div class="float-right">
                            	<div class="form-group float-left">
                                <div>
                                    <input type="submit" class="btn btn-primary" name="keep" value="保存する">
                                </div>
                                </div>

								<div class="form-group float-left">
                                <div class="ml-2">
                                    <input type="submit" class="btn btn-danger" name="open" value="公開する">
                                </div>
                                </div>
                            </div>
                        </div>


                        @include('mypage.shared.thumbnailForm')
                        

						<div class="clearfix tag-wrap">
                        @foreach($tagGroupAll as $group)
                        	<?php $allNames = array(); ?>

							@if(isset($tags[$group->id]))
                                @foreach($tags[$group->id] as $tag)
                                    <?php $allNames[] = $tag['name']; ?>
                                @endforeach
                            @endif

                        	<div class="tag-group form-group{{ $errors->has($group->slug) ? ' has-error' : '' }}">
                                <label for="title" class="control-label">{{ $group->name }}</label>
                                <div class="clearfix">
                                    <input id="{{ $group->slug }}" type="text" class="form-control tag-control" name="input-{{ $group->slug }}" value="{{ old($group->slug) }}" autocomplete="off">

                                    <div class="add-btn" tabindex="0">追加</div>

                                    <span style="display:none;">{{ implode(',', $allNames) }}</span>

                                    <div class="tag-area"></div>

                                </div>

                            </div>

                        @endforeach
                        </div><?php //tagwrap ?>

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


                    <div class="add-item">
                        <div class="visible-none">
                            @include('mypage.shared.itemCtrlNav')

                            @include('mypage.shared.newItemForm')
                        </div>

                        @include('mypage.shared.newItemForm')


                    </div><?php /*addItem*/ ?>


                    </form>

                    
                </div>

            @endif

            </div>
        </div>
    </div>
@endsection
