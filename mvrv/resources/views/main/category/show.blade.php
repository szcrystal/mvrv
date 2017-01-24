@extends('layouts.app')


@section('content')

    <div id="main" class="row">
		<div class="col-md-12">

            <div class="panel panel-default">
            	@if($posts->isEmpty())
                <div class="panel-heading">カテゴリー：{{ $cateName }}の記事がありません</div>
				@else
				<div class="panel-heading">カテゴリー：{{ $cateName }}</div>
                @endif

                <div class="panel-body">

                        <ul class="no-list">
                        <?php foreach($posts as $val) { ?>
                            <li style="border: 1px solid #aaa;">
                                <p><a href="{{url('/single/'.$val->id)}}">{{$val->title}}</a></p>

                            </li>
                        <?php } ?>

                        </ul>

                    {{ $posts->links() }}

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

