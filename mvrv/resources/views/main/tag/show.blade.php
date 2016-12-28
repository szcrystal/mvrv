@extends('layouts.app')


@section('content')

    <div id="main" class="row">
		<div class="col-md-12">

            <div class="panel panel-default">
            	@if($tagPosts->isEmpty())
                <div class="panel-heading">タグ：{{ $tagName}}の記事がありません</div>
				@else
				<div class="panel-heading">タグ：{{ $tagName}}</div>
                @endif

                <div class="panel-body">
					<div>
                        <ul class="no-list">
                        <?php foreach($tagPosts as $val) { ?>
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

