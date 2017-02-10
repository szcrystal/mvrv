@extends('layouts.appSingle')

@section('content')
    <div class="row pt-5">
        <div class="col-md-8 mx-auto">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2 class="h2">パスワードをリセット</h2>
                </div>
                <div class="panel-body mt-4">

                	@if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>ご確認ください</strong><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-3 control-label">メールアドレス</label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="text-danger help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 mx-auto mt-5">
                                <button type="submit" class="btn btn-primary col-md-12">
                                    リセット用リンクを送信
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
