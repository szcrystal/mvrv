@extends('layouts.app')


@section('content')

    <div id="main" class="row">
		<div class="col-md-12">

            <div class="panel panel-default">
            	@if($atcls->isEmpty())
                <div class="panel-heading">{{ $groupName }}の記事がありません</div>
				@else
				<div class="panel-heading">{{ $groupName }}の記事</div>
                @endif

                <div class="panel-body">
                	@include('main.shared.main')
                </div>
            </div>

	    </div>
	</div>

@endsection

@section('leftbar')
    @include('main.shared.leftbar')
@endsection


@section('rightbar')
	@include('main.shared.rightbar')
@endsection

