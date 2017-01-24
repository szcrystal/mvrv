@extends('layouts.app')


@section('content')

    <div id="main" class="row">
		<div class="col-md-12">

            <div class="panel panel-default">

            	@if(!count($pages))
                <div class="panel-heading">検索ワード：{{ $searchStr }}の記事がありません</div>
				@else
				<div class="panel-heading">検索ワード：{{ $searchStr }}</div>
                @endif


                <div class="panel-body">
					<div>
                        <ul class="no-list">
                        @foreach($pages as $val)
                            <li style="border: 1px solid #aaa;">
                                <p><a href="{{url('/single/'.$val->id)}}">{{ $val->title }}</a></p>
                                <p>{{-- $val->text --}}</p>
                            </li>
                        @endforeach

                        </ul>
                    </div>

                    {{-- $pages->render() --}}
                    {{ $pages->links() }}

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

