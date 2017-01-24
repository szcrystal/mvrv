@extends('layouts.app')


@section('content')

    	<article class="error404">
        	<header>
        		<h1 class="main-title"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> ページがありません</h1>
            </header>

            <div style="text-align:center;">
                <p>お探しのページがありませんでした。<br><a href="{{ url('/') }}">TOPページ</a>に戻り、再度リンクより入り直して下さい。</p>
                <a href="{{ url('/') }}" class="edit-btn"><span class="octicon octicon-mail-reply"></span> TOPへ</a>
            </div>
        </article>

@endsection
