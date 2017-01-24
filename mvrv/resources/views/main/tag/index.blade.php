@extends('layouts.app')


@section('content')

    <div id="main" class="row">
		<div class="col-md-12">

            <div class="panel panel-default">
            	@if($atcls->isEmpty())
                <div class="panel-heading">{{ $groupName }}の記事がありません</div>
				@else
				<div class="panel-heading">{{ $groupName }}の記事</div>
                @endif

                <div class="panel-body">
					<div>
                        <ul class="no-list">
                        <?php foreach($atcls as $val) { ?>
                            <li style="border: 1px solid #aaa;">
                                <p><a href="{{url('/single/'.$val->id)}}">{{$val->title}}</a></p>
                            </li>
                        <?php } ?>

                        </ul>

                        {{ $atcls->links() }}
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

