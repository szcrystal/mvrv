@extends('layouts.appSingle')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user->name }}さんの記事一覧</div>

                <div class="panel-body">
                    @if(count($posts))

					<div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th class="col-md-1">状態</th>
                          <th class="col-md-2">カテゴリー</th>
                          <th class="col-md-3">タイトル</th>
                          <th class="col-md-5">コンテンツ</th>
                          <th class="col-md-5">更新日</th>
                          <th></th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      
                    <?php //echo "SESSION: " . session('del_key'); ?>
                    
                    @foreach($posts as $post)
                        <tr>
                            <td>{{$post->id}}</td>

                            <td>
                            	@if($post->open_status)
                                公開中
                                @else
                                未公開
                                @endif
                            </td>

                            <td>{{$cateModel->find($post->cate_id)->name}}</td>
                            <td>{{$post->title}}</td>

                                                
                            <td>{{ $post->title }}</td>

                            <td>
                                {{ date('Y/m/d H:i', strtotime($post->updated_at)) }}
                            </td>

                            <td>
                                <a style="margin:auto;" href="{{url('mypage/'.$post->id.'/edit')}}" class="btn btn-primary btn-sm center-block">編集</a>
                            </td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                    </table>
                    </div>

                    @else
					<p class="text-success">まだ追加された記事がありません。<br>新着動画を取得して記事を追加して下さい。</p>
                    @endif

            </div>

{{-- $posts->where('open_status', 0)->count() --}}



        @if(count($atcls))
            <div class="panel-heading">新着動画一覧</div>
            @if($closeCount > 4)
                <p class="text-danger">未公開の記事が5件以上ありますので、記事の取得が出来ません。</p>
            @endif

                <div class="panel-body">

					<div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th class="col-md-2">状態</th>
                          <th>カテゴリー</th>
                          <th class="col-md-3">タイトル</th>
                          <th class="col-md-2">動画元</th>
                          <th class="col-md-5">コンテンツ</th>
                          <th class="col-md-5">コンテンツ</th>
                          <th></th>
                          
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
                                <strong>{{$atcl->movie_site}}</strong>
                            </td>

                            <td>
                                {{$atcl->title}}
                            </td>

                            <td>
                                <strong>{{$atcl->movie_site}}</strong>
                            </td>

                            <td>
								@if($closeCount > 4)
									取得できません
                                @else
                                <a style="margin:auto;" href="{{url('mypage/'.$atcl->id.'/create')}}" class="btn btn-success btn-sm center-block">取得</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                    </table>
                    </div>

                </div>
            @else
				<div class="panel-heading">現在、新着の動画はありません。</div>
			@endif


        </div><!-- panel -->
    </div>
</div>
@endsection
