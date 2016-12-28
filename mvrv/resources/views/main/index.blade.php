@extends('layouts.app')


@section('content')

    <div id="main" class="row">
		<div class="col-md-12"><!-- col-md-offset-1-->

            <div class="panel panel-default">
                <div class="panel-heading">TOP</div>

                <div class="panel-body">
                    TOP Page
                    <!-- <iframe width="880" height="495" src="https://www.youtube.com/embed/8wWZs3WQyF4" frameborder="0" allowfullscreen></iframe> -->

					<div>
                    <ul class="no-list">
                    <?php foreach($posts as $val) { ?>
                    	<li style="border: 1px solid #aaa;">
							<p><a href="{{url('/single/'.$val->id)}}">{{$val->title}}</a></p>
                            <p>{{$val->text}}</p>
                            <p><a href="{{$val->movie_url}}">{{$val->movie_url}}</a></p>
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

