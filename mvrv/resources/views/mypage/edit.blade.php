@extends('layouts.appSingle')

@section('content')
<?php
//$url = 'https://minhana.net/wikidata/A0001/picture_normal/A0001_picture_normal_thumb.jp';
//
//if($file = fopen($url, 'r'))
//echo 'aaa';
//else
//echo 'bbb';

?>
    <div class="row">
        <div class="col-md-12 py-4 mp-edit">
        	<a href="{{url('mypage')}}" class="back-btn"><i class="fa fa-angle-double-left" aria-hidden="true"></i> マイページへ戻る</a>
            <div class="panel panel-default mt-4">
                <div class="panel-heading clearfix mb-3">
                	<h2 class="h2">{{ $atcl->title }} の記事を編集</h2>
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
									<th>動画サイト</th>
                                    <td>{{ $atcl -> movie_site }}</td>
                                </tr>
                                <tr>
									<th>動画URL</th>
                                    <td><a href="{{ $atcl -> movie_url }}">{{ $atcl -> movie_url }}</a></td>
                                </tr>
                                <tr>
                                    <th>カテゴリー</th>
                                    <td>{{ $cate->name }}</td>
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

								{{--
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
								--}}

                            </tbody>
                		</table>
                    </div>

                    <div class="clearfix pb-5">
						<a href="{{ url('/mypage/base/'.$atcl->id) }}" class="btn btn-info btn-cus float-right">基本情報を編集 <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                    </div>

					<hr>
					<h3 class="h3"><i class="fa fa-square" aria-hidden="true"></i> 詳細情報</h3>
                    <form class="form-horizontal" role="form" method="POST" action="/mypage/{{ $atcl->id }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        {{ method_field('PUT') }}

						<div class="clearfix mb-5">
                            @if($atcl->open_history)
                                <div class="form-group text-right">
                                    <div class="">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="not_newdate" value="1" {{isset($atcl) && $atcl->not_newdate ? 'checked' : '' }}> 更新日時を変更しない
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="clearfix float-right">
                                <div class="form-group float-left">
                                    <div>
                                        <input type="submit" class="btn btn-warning" name="preview" value="保存してプレビュー">
                                    </div>
                                </div>
                                <div class="form-group float-left">
                                    <div class="ml-2">
                                        <input type="submit" class="btn btn-primary" name="keep" value="保存する">
                                    </div>
                                </div>
                                @if($atcl->open_status)
                                <div class="form-group float-left">
                                    <div class="ml-2">
                                        <input type="submit" class="btn btn-info" name="drop" value="公開を取り下げ">
                                    </div>
                                </div>
                                @else
                                <div class="form-group float-left">
                                    <div class="ml-2">
                                        <input type="submit" class="btn btn-danger" name="open" value="公開する">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>


                        @include('mypage.shared.thumbnailForm')


                        <div class="clearfix tag-wrap">

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
                                <label for="title" class="control-label">{{ $group->name }}</label>
                                <div class="clearfix">
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

                                <div class="preview float-left">
                                @if($item->image_path == '')
								<span class="no-img">No Image</span>
                                @else
                                <img src="{{ Storage::url($item->image_path) }}" width="200">
                                @endif
								</div>
                                <h4>{{$item->image_title}}</h4>
                                <p>引用元：{{$item->image_orgurl}}</p>
                                <p>コメント：<br>{!! nl2br($item->image_comment) !!}</p>

                                @include('mypage.shared.editItemForm')
                            </section>

                        @elseif($item->item_type == 'link')
                            <section>
                                @include('mypage.shared.itemCtrlNav')

                                <div class="link-box">
                                @if($item->link_imgurl)
                                <a href="{{ $item->link_url}}" title="{{ $item->link_title }}"><img src="{{ $item->link_imgurl }}"></a>
                                @else
                                <a href="{{ $item->link_url}}">{{ $item->link_title }}</a>
                                @endif
                                </div>

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
@endsection
