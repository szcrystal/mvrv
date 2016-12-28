@extends('appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <h3>問合せ一覧</h3>
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
            	<th class="col-md-2">問合わせ日</th>
              <th class="col-md-2">カテゴリー</th>
              <th class="col-md-2">名前</th>
              <th class="col-md-2">メール</th>
              <th class="col-md-3">テキスト</th>
              <th class="col-md-3">対応状況</th>
              <th></th>
              
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($contacts as $contact)
        	<tr>
            	<td>
                	{{$contact->id}}
                </td>

                <td>
                	{{ date('Y/n/j H:i', strtotime($contact->created_at)) }}
                </td>

				<td>
	        		<strong>{{$contact->category}}</strong>
                </td>
                                    
                <td>
                	{{ $contact->name }}
                </td>

                <td>
                	{{ $contact->email }}
                </td>

                <td>
                	@if(strlen($contact->context) > 100)
					{{ substr($contact->context, 0, 100) . "..." }}
                    @else
					{{ $contact->context }}
                    @endif
                </td>
                <td>
                	@if($contact->done_status)
					対応済
                    @else
					<span class="text-danger">未対応</span>
                    @endif
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/contacts/'.$contact->id. '/edit')}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    <?php //echo $objs->render(); ?>
        
@endsection

