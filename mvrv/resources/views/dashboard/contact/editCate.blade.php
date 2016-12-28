@extends('appDashBoard')

@section('content')
	
	<h2 class="page-header">問合せ:カテゴリー編集</h2>
    
    	@if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!!</strong> 追加できません<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        

        
    <div class="well">{{-- col-lg-8 --}}
    	@if (isset($status))
            <div class="alert alert-success">
                {{ $status }}
            </div>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="/dashboard/contacts/cate/{{$cateId}}">

            {{ csrf_field() }}

			<div class="bs-component clearfix">
                <div class="pull-left">
                    <a href="{{ url('/dashboard/contacts/create') }}" class="btn btn-success btn-sm"><span class="octicon octicon-triangle-left"></span>一覧へ戻る</a>
                </div>

            </div>

            <div class="panel-body">

            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="category" class="col-md-3 control-label">カテゴリー編集</label>
                    <div class="col-md-7">
                        <input id="category" type="text" class="form-control" name="category" value="{{ isset($cate) ? $cate->category : old('category') }}" required>

                        @if ($errors->has('category'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>

            <div class="form-group">
                <div class="col-md-10">
                    <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>更　新</button>
                </div>
            </div>
        </form>


        	</div>

        </form>


    
   
    </div>

@endsection
