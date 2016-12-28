@extends('appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <h3>タググループ一覧</h3>
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-2">カテゴリー</th>
              <th class="col-md-4">タイトル</th>
              <th class="col-md-2">公開状態</th>
              <th class="col-md-2">公開日</th>
              <th class="col-md-3">状態</th>
              <th class="col-md-3">View数</th>
              <th></th>
              
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($groups as $group)
        	<tr>
            	<td>
                	{{$group->id}}
                </td>

				<td>
	        		<strong>{{$group->name}}</strong>
                </td>
                                    
                <td>
                	{{ $group->slug }}
                </td>

                <td>
                	@if($group->open_status)
					有効
                    @else
					<span class="text-danger">無効</span>
                    @endif
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/taggroups/'.$group->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    <?php //echo $objs->render(); ?>
        
@endsection

