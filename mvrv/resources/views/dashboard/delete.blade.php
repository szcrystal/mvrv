@extends('appDashBoard')

@section('content')
	
    <h1 class="page-header">
    @if($p_type== 'pages')
    	<span class="octicon octicon-book"></span>固定ページ
    @elseif($p_type== 'jobs')
    	<span class="octicon octicon-file-directory"></span>案件情報
    @elseif($p_type== 'topics')
    	<span class="octicon octicon-megaphone"></span>トピックス
    @elseif($p_type == 'irohas')
    	<span class="octicon octicon-repo"></span>監査役いろは
    @elseif($p_type== 'study')
    	<span class="octicon octicon-repo"></span>勉強会
    @elseif($p_type== 'blog')
    	<span class="octicon octicon-file-text"></span>ブログ
    @endif
    </h1>

	<h2 style="margin-top:1.5em;" class="sub-header">
    @if($p_type == 'jobs')
    {{$article->company_name}}
    @else
    {{$article->title}}
    @endif</h2>
    
    <p>{!! nb(str_limit(trim(strip_tags($article->main_content)), 170)) !!}</p>
    
	<div style="margin: 3em 0;">
        <p>この操作を元に戻すことはできません。<br>この記事を削除してもよろしいですか？</p>
    
        {!! Form::open() !!}
            {!! Form::hidden('del_key', session('del_key')) !!}
            {!! Form::hidden('t', $p_type) !!}
            
            <button type="submit" class="btn btn-danger">削　除</button>
            <a href="{{ getUrl('/dashboard/'.$p_type .'-edit/'. $article->id) }}" style="margin-left: 1.5em;" class="btn btn-default">キャンセル</a>
        {!! Form::close() !!}
    
    </div>

@endsection
