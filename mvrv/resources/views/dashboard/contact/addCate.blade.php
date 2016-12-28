@extends('appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <div class="panel-heading">
    	<h3>問合せ：カテゴリー一覧</h3>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="panel-body">
        
    <div class="table-responsive col-md-6">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th class="col-md-1">ID</th>
            	<th class="col-md-4">カテゴリー</th>
              <th class="col-md-3">追加日</th>

              <th class="col-md-1"></th>
              
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
	        		<strong>{{$cate->category}}</strong>
                </td>
                                    
                <td>
                	{{ date('Y/n/j H:i', strtotime($cate->created_at)) }}
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/contacts/cate/'.$cate->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>

		<div class="col-md-6">
		<form class="form-horizontal" role="form" method="POST" action="/dashboard/contacts">

            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="category" class="col-md-4 control-label">カテゴリー追加</label>
                    <div class="col-md-8">
                        <input id="category" type="text" class="form-control" name="category" value="{{ old('category') }}" required autofocus>

                        @if ($errors->has('category'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>

            <div class="form-group">
                <div class="col-md-11">
                    <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>追加</button>
                </div>
            </div>
        </form>
        </div>

    </div>
    
    <?php //echo $objs->render(); ?>
        
@endsection

