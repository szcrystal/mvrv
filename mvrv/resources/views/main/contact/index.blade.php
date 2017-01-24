@extends('layouts.appSingle')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">



                <div class="panel-heading">
                	<h2>お問い合わせ</h2>
                </div>

                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Error!!</strong> 追加できません<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

					<div class="table-responsive">
                    	<form class="form-horizontal" role="form" method="POST" action="/contact">
                            {{ csrf_field() }}

                            <input type="hidden" name="done_status" value="0">

                        <table class="table table-bordered">
                            <colgroup>
                                <col style="width:30%;" class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <tbody>
                                <tr>
                                	<th>お問い合わせ内容</th>
                                    <td>
										<div class="form-group{{ $errors->has('ask_category') ? ' has-error' : '' }}">

                                            <div class="col-md-10">
                                            	@if($select)
													{{ $select }}
                                                    <input type="hidden" name="ask_category" value="{{$select}}">
                                                @else
                                                    <select class="form-control" name="ask_category">
                                                        @foreach($cate_option as $val)
                                                            <option value="{{ $val }}"{{ old('ask_category') && old('ask_category') == $val ? ' selected' : '' }}>{{ $val }}</option>
                                                        @endforeach
                                                    </select>

                                                    @if ($errors->has('ask_category'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('ask_category') }}</strong>
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                @if($atclObj)

                                    <tr>
										<th>削除依頼記事タイトル</th>
                                        <td>{{$atclObj->title}}</td>
                                        <input type="hidden" name="delete_id" value="{{$atclObj->id}}">
                                    </tr>
                                @endif

                                <tr>
                                	<th>お名前</th>
                                    <td>
                                    	<div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                                            {{-- <label for="user_name" class="col-md-4 control-label">お名前</label> --}}

                                            <div class="col-md-10">
                                                <input id="user_name" type="text" class="form-control" name="user_name" value="{{ old('user_name') }}" required>

                                                @if ($errors->has('user_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('user_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                    				</td>
                                </tr>

                                <tr>
                                	<th>メールアドレス</th>
                                    <td>
                                    	<div class="form-group{{ $errors->has('user_email') ? ' has-error' : '' }}">
                                            <div class="col-md-10">
                                                <input id="user_email" type="user_email" class="form-control" name="user_email" value="{{ old('user_email') }}" required>

                                                @if ($errors->has('user_email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('user_email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                                    </td>
                                </tr>
                                <tr>
                                	<th>コメント</th>
                                    <td>
										<div class="form-group{{ $errors->has('context') ? ' has-error' : '' }}">
                                            <div class="col-md-10">
                                                <textarea id="context" class="form-control" name="context" required>{{ old('context') }}</textarea>

                                                @if ($errors->has('context'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('context') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>



                            </tbody>
                		</table>
                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-5">
                                <button type="submit" class="btn btn-primary">送信</button>
                            </div>
                        </div>
                    </form>
                    </div>


            </div><!-- panel -->

        </div>
    </div>
</div>
@endsection
