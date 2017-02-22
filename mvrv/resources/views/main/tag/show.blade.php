@extends('layouts.app')


@section('content')

    <div id="main">

            <div class="panel panel-default">
            	<div class="panel-heading">
                <h2 class="h2">
            	@if($atcls->isEmpty())
                {{ $groupName}}：{{ $tagName}}の記事がありません
				@else
				{{ $groupName}}：{{ $tagName}}
                @endif
                </h2>
                </div>

                <div class="panel-body">
					@include('main.shared.main')

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

