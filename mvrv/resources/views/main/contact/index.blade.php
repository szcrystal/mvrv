@extends('layouts.appSingle')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
{{ Ctm::changeDate('2016-12-4 11:30:50') }}
                <div class="panel-heading">
                	<h2>お問い合わせ</h2>
                </div>

                <div class="panel-body">

					<div class="table-responsive">
                    	<table class="table table-bordered">
                            <colgroup>
                                <col class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <tbody>
                            	<form class="form-horizontal" role="form" method="POST" action="/contact">
                        		{{ csrf_field() }}

                                <input type="hidden" name="done_status" value="0">

                                <tr>
                                    <td>
										<div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                            <label for="category" class="col-md-4 control-label">お問い合わせ内容</label>

                                            <div class="col-md-6">
                                            	<select class="form-control" name="category">

                                                    <?php foreach($cate_option as $val) { ?>
                                                    <option value="{{ $val }}"{{ old('category') && old('category') == $val ? ' selected' : '' }}>{{ $val }}</option>
                                                    <?php } ?>
                                                </select>

                                                @if ($errors->has('category'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('category') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                    	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="category" class="col-md-4 control-label">お名前</label>

                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                    				</td>
                                </tr>

                                <tr>
                                    <td>
                                    	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="category" class="col-md-4 control-label">メールアドレス</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
										<div class="form-group{{ $errors->has('context') ? ' has-error' : '' }}">
                                            <label for="context" class="col-md-4 control-label">テキスト</label>

                                            <div class="col-md-6">
                                                <textarea id="context" class="form-control" name="context" required>{{ old('text') }}</textarea>

                                                @if ($errors->has('context'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('context') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
									<td>
										<div class="form-group">
                                            <div class="col-md-8 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary">送信</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                </form>

                            </tbody>
                		</table>
                    </div>


            </div><!-- panel -->

        </div>
    </div>
</div>
@endsection
