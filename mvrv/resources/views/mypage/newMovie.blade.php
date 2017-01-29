@extends('layouts.appSingle')

@section('content')

<div class="container mp-index">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

        @if(count($atcls))
            <div class="panel-heading">
            	<a href="{{ url('mypage') }}">{{ $user->name }}さんの記事一覧</a>
            	新着動画一覧
            </div>

            <div class="panel-body">
            	@if($closeCount > 4)
                    <p class="text-danger">未公開の記事が5件以上ありますので、記事の取得が出来ません。</p>
                @endif

					<div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th class="col-md-1">状態</th>
                          <th class="col-md-2">カテゴリー</th>
                          <th class="col-md-3">タイトル</th>
                          <th class="col-md-1">動画元</th>
                          <th class="col-md-3">動画URL</th>
                          <th class="col-md-3"></th>
                          
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
                                <a href="{{$atcl->movie_url}}">{{$atcl->movie_url}}</a>
                            </td>


                            <td>
								@if($closeCount > 4)
									取得不可
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
