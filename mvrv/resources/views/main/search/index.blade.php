@extends('layouts.app')


@section('content')

    <div id="main" class="row">
		<div class="col-md-12">

            <div class="panel panel-default">
				<div class="panel-heading">
                <h2 class="h2">
            	@if(!count($atcls))
                検索ワード：{{ $searchStr }}の記事がありません
				@else
				検索ワード：{{ $searchStr }}
                @endif
                </h2>
                </div>

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

