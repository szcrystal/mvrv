@extends('appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <h3>記事一覧</h3>
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-2">カテゴリー</th>
              <th class="col-md-4">タイトル</th>
              <th class="col-md-2">公開状態</th>
              <th class="col-md-2">公開日</th>
              <th class="col-md-3">オーナー名</th>
              <th class="col-md-3">View数</th>
              <th></th>
              
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($atclObjs as $obj)
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>

				<td>
	        		{{ $cateModel->find($obj->cate_id)->name }}
                </td>
                                    
                <td>
                	{{ $obj->title }}
                </td>

                <td>
					<?php //$post = $posts->where(['base_id'=>$obj->id])->first(); ?>

                    @if($obj->owner_id)
                    	@if($obj->open_status)
                    	<span class="text-success">公開中</span>
                        @else
						<span class="text-warning">未公開（保存済）</span>
                        @endif
                    @else
                    	<span class="text-danger">未公開</span>
                    @endif

                </td>

                <td>
					@if($obj->open_date)
						{{ $obj->open_date }}
                    @else
						--
                    @endif
                </td>
                <td>
                	@if($obj->owner_id)
                	{{ $users->find($obj->owner_id)->name }}

                    @endif
                </td>

                <td>
                	{{ $obj->view_count }}
                </td>




                <td>
                	<a style="margin:auto;" href="{{url('dashboard/articles/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    <?php //echo $objs->render(); ?>
        
@endsection

