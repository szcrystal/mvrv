@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div id="main" class="panel-body">
            @include('main.shared.main')
        </div>
    </div>

@endsection


@section('leftbar')
    @include('main.shared.leftbar')
@endsection


@section('rightbar')
	@include('main.shared.rightbar')
@endsection



