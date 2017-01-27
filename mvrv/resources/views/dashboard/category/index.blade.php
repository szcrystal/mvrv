@extends('layouts.appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <h3>カテゴリー一覧</h3>
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-2">名前</th>
              <th class="col-md-4">スラッグ</th>
              <th class="col-md-3">View数</th>
              <th></th>
              
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($cates as $cate)
        	<tr>
            	<td>
                	{{$cate->id}}
                </td>

				<td>
	        		<strong>{{$cate->name}}</strong>
                </td>
                                    
                <td>
                	{{ $cate->slug }}
                </td>

                {{--
                <td>
                	@if($cate->open_status)
					有効
                    @else
					<span class="text-danger">無効</span>
                    @endif
                </td>
                --}}
                <td>
					{{ $cate->view_count }}
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/categories/'.$cate->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    {{ $cates->links() }}
        
@endsection

