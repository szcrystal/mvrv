@extends('layouts.app')


@section('content')

    <div id="main" class="row top">
		<div class="col-md-12"><!-- col-md-offset-1-->

            <div class="panel panel-default">
                <div class="panel-heading">TOP Page</div>

                <div class="panel-body">
                    <!-- <iframe width="880" height="495" src="https://www.youtube.com/embed/8wWZs3WQyF4" frameborder="0" allowfullscreen></iframe> -->

					<div>
                    <ul class="no-list">
                    <?php foreach($posts as $val) { ?>
                    	<li class="clearfix">
							<a href="{{url('/single/'.$val->id)}}">
                            	<div class="pull-left">
                                <img src="{{Storage::url($val->thumbnail)}}">
                                </div>
                                <h2 class="pull-right">{{$val->title}}</h2></a>

						</li>
                    <?php } ?>

                    </ul>
                    </div>

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

