@extends('layouts.appSingle')

@section('content')
<div class="container single">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>{{ $atcl -> title }}のレビュー</h2>

                    @if($atcl -> movie_url != '')
                    	<?php $embed = explode('=', $atcl -> movie_url);
                        //echo $embed[1];
                        //https://youtu.be/1oeN1gmLzvM
                    	?>

                		<iframe width="560" height="315" src="https://www.youtube.com/embed/{{$embed[1]}}" frameborder="0" allowfullscreen></iframe>
                    @endif
				</div>

                <div class="panel-body">

					<div class="clearfix">
                    	@if(session('fromMp'))
                            <div class="pull-left">
                                <a href="{{ url(session('fromMp')) }}" class="btn btn-warning center-block">編集画面へ戻る</a>
                            </div>
                        @endif
                        <div class="pull-right">
                            <a href="{{ url('contact/'. $atcl->id) }}" class="btn btn-danger center-block">削除を依頼</a>
                        </div>
                    </div>

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
                                    <td><a href="{{ url('category/' . $cate->slug) }}">{{ $cate->name }}</a></td>
                                </tr>

                                @foreach($tagGroupAll as $group)
                                <tr>
                                    <th>{{ $group->name }}</th>
                                    <td>
                                    @if(isset($tagGroups[$group->id]))
                                    	@foreach($tagGroups[$group->id] as $tag)
											<a href="{{ url('tag/'. $tag['slug']) }}">{{ $tag['name'] }}</a>&nbsp;&nbsp;
                                        @endforeach
									@endif
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                		</table>
                    </div>

                    <div>
                    	<div class="well clearfix">
                            <div class="col-md-3 pull-left">
                            	<img style="border:8px solid #fff; width:100%;" src="{{ Storage::url($atcl -> thumbnail) }}">
                            </div>
                            <div class="col-md-6 pull-left">
                                <p>サムネイル引用元：{{ $atcl -> thumbnail_org }}</p>
                                <p>公開日時：{{ Ctm::changeDate($atcl->open_date, 'notime') }}</p>
                                <p>レビューオーナー：{{ $user->name }}</p>
                            </div>
                        </div>

                        <div style="margin-top: 3em;" class="rv-content">
							@foreach($items as $item)
								@if($item->item_type == 'title')
									@if($item->title_option == 1)
										<h1>{{ $item->main_title }}</h1>
                                    @else
										<h2>{{ $item->main_title }}</h2>
                                    @endif
                                @elseif($item->item_type == 'text')
									<p>{!! nl2br($item->main_text) !!}</p>
                                @elseif($item->item_type == 'image')
                                    <img src="{{ Storage::url($item->image_path) }}">
                                	<h4>{{$item->image_title}}</h4>
                                	<p>引用元：{{$item->image_orgurl}}</p>
                                	<p>コメント：<br>{!! nl2br($item->image_comment) !!}</p>

                                @elseif($item->item_type == 'link')
                                	<p>{{ $item->link_title }} Option:{{ $item->link_option }}</p>
                                	<a href="{{ $item->link_url}}"><img src="{{ $item->link_imgurl }}"></a>

                                @endif
                            @endforeach
                        </div>







                	</div>

				</div><!-- panelbody -->

            </div>
        </div>
    </div>
</div>
@endsection
