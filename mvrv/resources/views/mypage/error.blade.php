@extends('layouts.appSingle')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-heading">
                	<h3>{{$atcl->title}}</h3>
                    @if($owner_status)
                    <p>この動画のオーナーが他のユーザーに決まりました。<br>他の動画を選択してください。<br><a href="/mypage">戻る</a></p>
                	@endif
                </div>


                <div class="panel-body">

				</div>

	    	</div>
        </div>
    </div>
</div>
@endsection
