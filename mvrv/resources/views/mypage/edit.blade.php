@extends('layouts.appSingle')

@section('content')

<div class="container mp-edit">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        	<a href="{{url('mypage')}}">戻る</a>
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


								{{--
                                @foreach($tagGroups as $key => $tagArr)
                                <tr>
                                    <th>タグ: {{ $tagGroupModel->find($key)->name }}</th>
                                    <td>
                                    @foreach($tagArr as $tag)
                                        <a href="{{ url('tag/'. $tag['slug']) }}">{{ $tag['name'] }}</a>
                                    @endforeach
                                    </td>
                                </tr>
                                @endforeach
								--}}

                                <?php //$groupAll = $tagGroupModel->all(); ?>

								@foreach($tagGroupAll as $group)
                                <tr>
                                    <th>{{ $group->name }}</th>
                                    <td>
                                    @if(isset($tagGroups[$group->id]))
                                    	@foreach($tagGroups[$group->id] as $tag)
											<a href="{{ url($group->slug .'/'. $tag['slug']) }}">{{ $tag['name'] }}</a>&nbsp;&nbsp;
                                        @endforeach
									@endif
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                		</table>
                    </div>


                    <form class="form-horizontal" role="form" method="POST" action="/mypage/{{ $atcl->id }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        {{ method_field('PUT') }}

						<div class="well">
                            @if($atcl->open_history)
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-7">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="open_status" value="1" {{isset($atcl) && $atcl->open_status ? 'checked' : '' }}> 公開する
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="clearfix col-md-offset-7">

                                <div class="form-group pull-left">
                                    <div class="col-md-3">
                                        <input type="submit" class="btn btn-warning" name="preview" value="保存してプレビュー">
                                    </div>
                                </div>
                                <div class="form-group pull-left">
                                    <div class="col-md-3 col-md-offset-1">
                                        <input type="submit" class="btn btn-primary" name="keep" value="保存する">
                                    </div>
                                </div>
                                @if(! $atcl->open_history)
                                <div class="form-group pull-left">
                                    <div class="col-md-3 col-md-offset-3">
                                        <input type="submit" class="btn btn-danger" name="open" value="公開する">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>


						<div class="clearfix thumb-wrap">
                            <div style="width:170px; height:170px; overflow:hidden;" class="pull-left">
                                @if($atcl->thumbnail)
                                <img style="width: 120%;" src="{{ Storage::url($atcl->thumbnail) }}">
                                @else
                                <div style="width:100%; height:100%; border:1px solid #ccc;">No Image</div>
                                @endif
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
                                        <input id="thumbnail_org" type="text" class="form-control" name="thumbnail_org" value="{{ isset($atcl) ? $atcl->thumbnail_org : old('thumbnail_org') }}">

                                        @if ($errors->has('thumbnail_org'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('thumbnail_org') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                        	</div>
                        </div>

                        <div class="tag-wrap">

						@foreach($tagGroupAll as $group)
                        	<?php
                            	$names = array();
                            	$allNames = array();
                            ?>

                            @if(isset($tagGroups[$group->id]))
								@foreach($tagGroups[$group->id] as $tag)
									<?php $names[] = $tag['name']; ?>
                                @endforeach
                            @endif

							@if(isset($tags[$group->id]))
                                @foreach($tags[$group->id] as $tag)
                                    <?php $allNames[] = $tag['name']; ?>
                                @endforeach
                            @endif


                        	<div class="tag-group form-group{{ $errors->has($group->slug) ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">{{ $group->name }}</label>
                                <div class="col-md-4 clearfix">
                                    <input id="{{ $group->slug }}" type="text" class="form-control tag-control" name="input-{{ $group->slug }}" value="{{ old($group->slug) }}" autocomplete="off">

                                    <div class="add-btn" tabindex="0">追加</div>

                                    <span style="display:none;">{{ implode(',', $allNames) }}</span>

                                    <div class="tag-area">
										@foreach($names as $name)
											<span><em>{{ $name }}</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>
           									<input type="hidden" name="{{ $group->slug }}[]" value="{{ $name }}">
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        @endforeach

                        </div><?php //tagwrap ?>


                        {{--
                        	@foreach($tagGroups as $key => $tagArr)
                                    //$groupSlug = $tagGroupModel->find($key)->slug;
                            
                                @foreach($tagArr as $tag)
                                        //$tagNames[$groupSlug][] = $tag['name'];
                            
                                @endforeach

                            @endforeach
                            <div class="form-group{{ $errors->has($key) ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">タグ：{{ $tagGroupModel->find($key)->name }}</label>
                                <div class="col-md-6">
                                    <input id="keyword" type="text" class="form-control" name="{{ $tagGroupModel->find($key)->slug }}" value="{{ implode(' ', $tagNames) }}" required>
                                </div>
                            </div>
                        --}}





<p>http://www.msn.com/ja-jp?rd=1</p>
<p>https://www.google.co.jp/?gws_rd=ssl</p>
<p>http://www.yahoo.co.jp</p>


                <div class="add-item">
                	<div class="visible-none">
                        @include('mypage.shared.itemCtrlNav')

                        @include('mypage.shared.newItemForm')
                    </div>

                    @include('mypage.shared.newItemForm')
                    {{-- <div class="item-panel first-panel"> --}}


                    @foreach($items as $item)
                        @if($item->item_type == 'title')
                            <section>
								@include('mypage.shared.itemCtrlNav')

                                @if($item->title_option == 1)
                                    <h1>{{ $item->main_title }}</h1>
                                @else
                                    <h2>{{ $item->main_title }}</h2>
                                @endif

                                @include('mypage.shared.editItemForm')
                            </section>

                        @elseif($item->item_type == 'text')
                            <section>
                                @include('mypage.shared.itemCtrlNav')

                                <p>{!! nl2br($item->main_text) !!}</p>

                                @include('mypage.shared.editItemForm')
                            </section>

                        @elseif($item->item_type == 'image')
                            <section>
                                @include('mypage.shared.itemCtrlNav')

                                <img src="{{ Storage::url($item->image_path) }}" width="120" height="120">
                                <h4>{{$item->image_title}}</h4>
                                <p>引用元：{{$item->image_orgurl}}</p>
                                <p>コメント：<br>{!! nl2br($item->image_comment) !!}</p>

                                @include('mypage.shared.editItemForm')
                            </section>

                        @elseif($item->item_type == 'link')
                            <section>
                                @include('mypage.shared.itemCtrlNav')

                                <p><a href="{{ $item->link_url}}">{{ $item->link_title }} Option:{{ $item->link_option }}<br>
                                <img src="{{ $item->link_imgurl }}"></a></p>

                            	@include('mypage.shared.editItemForm')
                            </section>

                        @endif


						@include('mypage.shared.newItemForm')


                    @endforeach

                </div><?php /*addItem*/ ?>




					</form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
