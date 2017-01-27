@extends('layouts.app')


@section('content')

    <div id="main" class="row top">
		<div class="col-md-12"><!-- col-md-offset-1-->

            <div class="panel panel-default">
                <div class="panel-heading">TOP Page</div>

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

