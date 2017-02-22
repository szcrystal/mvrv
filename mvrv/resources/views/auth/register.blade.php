@extends('layouts.appSingle')

@section('content')

<div class="row pt-5">
    <div class="col-md-9 mx-auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="h2">新規ユーザー登録</h2>
            </div>

            <div class="panel-body mt-4">
                @if(session('errorStatus'))
                    <div class="alert alert-danger">
                        {{ session('errorStatus') }}
                    </div>
                @else

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>登録出来ません</strong><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!session('sended'))
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {{ csrf_field() }}

                            <div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-3 control-label">ユーザー名</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>

                                    @if ($errors->has('name'))
                                        <span class="text-danger help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-3 control-label">メールアドレス</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="text-danger help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-3 control-label">パスワード</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="8文字以上" required>

                                    @if ($errors->has('password'))
                                        <span class="text-danger help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="password-confirm" class="col-md-3 control-label">パスワード（確認用）</label>

                                <div class="col-md-8">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 mx-auto mt-5">
                                    <button type="submit" class="btn btn-primary col-md-12">
                                        登録する
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif

                @endif

            </div>
        </div>
    </div>
</div>

@endsection
