@extends('layouts.app')


@section('content')

    <div id="main">

            <div class="panel panel-default">
            	<div class="panel-heading">
                	<h2 class="h2">
                    @if($atcls->isEmpty())
                    カテゴリー：{{ $cateName }}の記事がありません</h2></div>
                    @else
                    カテゴリー：{{ $cateName }}
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

