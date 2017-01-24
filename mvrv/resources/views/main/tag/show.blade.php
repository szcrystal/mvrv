@extends('layouts.app')


@section('content')

    <div id="main" class="row">
		<div class="col-md-12">

            <div class="panel panel-default">
            	@if($tagPosts->isEmpty())
                <div class="panel-heading">{{ $groupName}}：{{ $tagName}}の記事がありません</div>
				@else
				<div class="panel-heading">{{ $groupName}}：{{ $tagName}}</div>
                @endif

                <div class="panel-body">
					<div>
                        <ul class="no-list">
                        <?php foreach($tagPosts as $val) { ?>
                            <li style="border: 1px solid #aaa;">
                                <a href="{{url('/single/'.$val->id)}}">{{$val->title}}</a>
                            </li>
                        <?php } ?>

                        </ul>

                        {{ $tagPosts->links() }}
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

