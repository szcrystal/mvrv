@extends('layouts.app')


@section('content')

    <div id="main" class="row">
		<div class="col-md-12">

            <div class="panel panel-default">

            	@if(!count($atcls))
                <div class="panel-heading">検索ワード：{{ $searchStr }}の記事がありません</div>
				@else
				<div class="panel-heading">検索ワード：{{ $searchStr }}</div>
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

