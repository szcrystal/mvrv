@extends('layouts.appSingle')

@section('content')
    <div class="row">
        <div class="col-md-12 py-5 mp-index">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                	<span>{{ $user->name }}さんの記事一覧</span>
					<a href="{{ url('mypage/newmovie') }}">新しい記事を取得</a>
					<a href="{{ url('mypage/create') }}" class="btn btn-primary float-right">新しい記事を作成</a>
                </div>



                <div class="panel-body">
                    @if(count($posts))

					<div class="table-responsive">
                    <table class="table table-bordered table-striped responsive-utilities">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>状態</th>
                          <th>サムネイル</th>
                          <th style="width:8em;">カテゴリー</th>
                          <th>タイトル</th>
                          <th>更新日</th>
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
                                <span class="text-success">公開中</span>
                                @else
                                <span class="text-danger">未公開</span>
                                @endif
                            </td>

                            <td>
                            	@if($post->thumbnail)
								<img src="{{ Storage::url($post->thumbnail) }}" width="70" height="70">
                                @else
                                <span class="no-img">No Image</span>
                                @endif
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
                                <a style="margin:auto;" href="{{url('mypage/'.$post->id.'/edit')}}" class="btn btn-primary btn-md center-block">編集</a>
                            </td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                    </table>
                    </div>

                    @else
					<p>まだ追加された記事がありません。<br>新しい記事を取得して記事を追加して下さい。</p>
                    @endif

            </div>


        </div><!-- panel -->
    </div>
@endsection
