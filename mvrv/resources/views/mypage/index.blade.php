@extends('layouts.appSingle')

@section('content')
<div class="container mp-index">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                	{{ $user->name }}さんの記事一覧
					<a href="{{ url('mypage/newmovie/') }}">新着動画一覧</a>
                </div>

                <div class="panel-body">
                    @if(count($posts))

					<div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th class="col-md-1">状態</th>
                          <th class="col-md-1">サムネイル</th>
                          <th class="col-md-2">カテゴリー</th>
                          <th class="col-md-5">タイトル</th>
                          <th class="col-md-3">更新日</th>
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
                                <span class="text-info">公開中</span>
                                @else
                                <span class="text-danger">未公開</span>
                                @endif
                            </td>

                            <td>
								<img src="{{ Storage::url($post->thumbnail) }}" width="70" height="70">
                            </td>

                            <td>
                            @if($cate = $cateModel->find($post->cate_id))
                            {{ $cate->name }}
                            @endif
                            </td>
                                                
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


{{--
ORG
@if(count($atcls))
<div class="panel-heading">新着動画一覧</div>
--}}


        </div><!-- panel -->
    </div>
</div>
@endsection
