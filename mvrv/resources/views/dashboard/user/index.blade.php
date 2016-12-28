@extends('appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <h3>会員一覧</h3>
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-2">名前</th>
              <th class="col-md-4">メールアドレス</th>
              <th class="col-md-2">状態</th>
              <th class="col-md-2">登録日</th>
              <th></th>
              
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($users as $obj)
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>

				<td>
	        		<strong>{{$obj->name}}</strong>
                </td>
                                    
                <td>
                	{{ $obj->email }}
                </td>

                <td>
					@if($obj->active)
						有効
                    @else
						<span class="text-danger">無効</span>
                    @endif
                </td>

                <td>
                	{{ date('Y/n/j H:m', strtotime($obj->created_at)) }}
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/users/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    <?php //echo $objs->render(); ?>
        
@endsection

