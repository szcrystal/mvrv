@extends('layouts.appSingle')

@section('content')

    <div class="row">
        <div class="col-md-12 py-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>{{ $atcl -> title }}のレビュー</h2>
					<div class="movie-frame py-4 text-center">
                    	@include('main.shared.movie')
                    </div>
				</div>

                <div class="panel-body">

					<div class="clearfix">
                    	@if(Auth::check() && Auth::user()->id == $atcl->owner_id)
                            <div class="float-left">
                                <a href="{{ url('mypage/'.$atcl->id.'/edit') }}" class="btn btn-info center-block">この記事を編集</a>
                            </div>
                        @endif
                        <div class="float-right">
                            <a href="{{ url('contact/'. $atcl->id) }}" class="btn btn-danger center-block">削除を依頼</a>
                        </div>
                    </div>

                    <div class="table-responsive py-3">
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
											<a href="{{ url($group->slug.'/'. $tag['slug']) }}">{{ $tag['name'] }}</a>&nbsp;&nbsp;
                                        @endforeach
									@endif
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                		</table>
                    </div>

                    <div>
                    	<div class="row clearfix">
                            <div class="col-md-3 float-left">
                            	{{-- @if (App::environment('local')) --}}
                                @if($atcl -> thumbnail)
                            	<img src="{{ Storage::url($atcl->thumbnail) }}" class="img-fluid">
                                @else
                                <span class="no-img">No Image</span>
                                @endif
                                {{-- @else Storage::disk('s3')->url($atcl -> thumbnail) --}}
                            </div>
                            <div class="col-md-6 float-left">
                                <p>サムネイル引用元：{{ $atcl -> thumbnail_org }}</p>
                                <p>公開日時：{{ Ctm::changeDate($atcl->open_date, 'notime') }}</p>
                                <p>レビューオーナー：{{ $user->name }}</p>
                            </div>
                        </div>

                        <div class="rv-content mt-5">
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

                            {{ $items->links() }}
                        </div>







                	</div>

				</div><!-- panelbody -->

            </div>
        </div>
    </div>
@endsection
