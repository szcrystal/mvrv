@extends('layouts.appSingle')

@section('content')

    <div class="row">
        <div class="col-md-10 offset-md-1 py-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2 class="h2">{{ $fix -> title }}</h2>
				</div>

                <div class="row panel-body">
                    <div class="col-md-12 clearfix">
						{!! $fix->contents !!}
                    </div>

				</div><!-- panelbody -->

            </div>
        </div>
    </div>
@endsection
