@extends('layouts.appSingle')

@section('content')
    <div class="row">
        <div class="col-md-12 py-5 mp-index">
            <div class="panel panel-default">


            <div class="panel-heading">
            	<a href="{{ url('mypage') }}">{{ $user->name }}さんの記事一覧</a>
            	<span>新しい記事を取得</span>
                <a href="{{ url('mypage/create') }}" class="btn btn-primary float-right">新しい記事を作成</a>
            </div>

			<div class="panel-body">
            @if(!count($atcls))
                <p>現在、新着の動画はありません。</p>

            @else

            	@if($closeCount > 4)
                    <p class="text-danger">未公開の記事が5件以上ありますので、記事の取得が出来ません。</p>
                @endif

					<div class="table-responsive">
                    <table class="table table-bordered table-striped responsive-utilities">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th style="min-width:7em;">状態</th>
                          <th style="min-width:8em;">カテゴリー</th>
                          <th style="min-width:15em;">タイトル</th>
                          <th>動画元</th>
                          <th>動画URL</th>
                          <th style="min-width:3em;"></th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      
                    <?php //echo "SESSION: " . session('del_key'); ?>
                    
                    @foreach($atcls as $atcl)
                        <tr>
                            <td>{{$atcl->id}}</td>

                            <td>
                            	@if($atcl->open_status)
                                公開中
                                @else
                                未公開
                                @endif
                            </td>

                            <td>{{$cateModel->find($atcl->cate_id)->name}}</td>

                            <td>
                                {{$atcl->title}}
                            </td>

                            <td>
                                {{$atcl->movie_site}}
                            </td>

                            <td>
                                <a href="{{$atcl->movie_url}}">{{$atcl->movie_url}}</a>
                            </td>


                            <td>
								@if($closeCount > 4)
									取得不可
                                @else
                                <a href="{{url('mypage/'.$atcl->id.'/create')}}" class="btn btn-success btn-md center-block m-auto">取得</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                    </table>
                    </div>

                </div>

			@endif


        </div><!-- panel -->
    </div>
@endsection
