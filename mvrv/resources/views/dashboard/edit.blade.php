@extends('appAdmin')

@section('content')
	<h2 class="sub-header">記事投稿</h2>
    
    	@if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (count($errors)==0)
        	<div class="alert">
        		<p><strong>Save is done</strong></p>
            	<a href="/dashboard">一覧ページへ</a>
            </div>
        @endif
    
    
      {!! Form::open() !!}
          <div class="form-group">
              <label>タイトル</label>
              {!! Form::input('text', 'title', null, ['required', 'class' => 'form-control']) !!}
          </div>
          <div class="form-group">
              <label>金額</label>
              {!! Form::input('text', 'price', null, ['required', 'class' => 'form-control']) !!}
          </div>
          <div class="form-group">
              <label>設備タイプ</label>
              {!! Form::textarea('type', null, ['required', 'class' => 'form-control']) !!}
          </div>
          <div class="form-group">
              <label>プラン</label>
              {!! Form::textarea('plan', null, ['required', 'class' => 'form-control']) !!}
          </div>
          <div class="form-group">
              <label>コンテンツ１</label>
              {!! Form::textarea('cont1', null, ['required', 'class' => 'form-control']) !!}
          </div>
          <div class="form-group">
              <label>コンテンツ２</label>
              {!! Form::textarea('cont2', null, ['required', 'class' => 'form-control']) !!}
          </div>
          <div class="form-group">
              <label>コンテンツ３</label>
              {!! Form::textarea('cont3', null, ['required', 'class' => 'form-control']) !!}
          </div>
          
          <button type="submit" class="btn btn-default">投稿</button>
      {!! Form::close() !!}
	

@endsection