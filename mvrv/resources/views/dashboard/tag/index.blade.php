@extends('appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <h3>タグ一覧</h3>
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-2">名前</th>
              <th class="col-md-4">スラッグ</th>
              <th class="col-md-2">グループ</th>
              <th class="col-md-3">View数</th>
              <th></th>
              
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($tags as $tag)
        	<tr>
            	<td>
                	{{$tag->id}}
                </td>

				<td>
	        		<strong>{{$tag->name}}</strong>
                </td>
                                    
                <td>
                	{{ $tag->slug }}
                </td>

                <td>
					{{ $groupModel->find($tag->group_id)->name }}
                </td>
                {{--
                <td>
                	@if($tag->open_status)
					有効
                    @else
					<span class="text-danger">無効</span>
                    @endif
                </td>
                --}}
                <td>
					{{ $tag->view_count }}
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/tags/'.$tag->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    <?php //echo $objs->render(); ?>
        
@endsection

