<?php //$s_info = DB::table('siteinfos')->first(); ?>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
{{-- @if($s_info->seo_sw === 1) --}}
	<!-- <meta name="robots" content="index, follow"> -->
{{-- @else --}}
	<meta name="robots" content="noindex, nofollow">
{{-- @endif --}}
{{-- DB::table('pages')->where('url_name',Request::path()) -> first() ->title --}}
	<title><?php
		if(isset($headTitle)) {
        	echo $headTitle . ' | ';
        }
        elseif(isset($top)) {
            echo htmlspecialchars($top->sub_title." | ",ENT_QUOTES);
        }
        elseif(isset($pageObj)) {
           echo $pageObj-> title . ' | ';
        }
        elseif(isset($topicObj)) {
        	echo $topicObj-> title . ' | ';
        }
        elseif(isset($blogObj)) {
        	echo $blogObj-> title . ' | ';
        }
		elseif(isset($atcl)) {
        	echo $atcl->title . ' | ';
        }
        ?>aaaaa{{-- $s_info->site_name --}}</title>
@if(isset($headDesc))
	<meta name="description" content="{{ $headDesc }}">
@endif
	<link href="{{ asset('/bootstrap/fonts/octicons/octicons.css') }}" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Delius' rel='stylesheet' type='text/css'>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
{{-- @if(isAgent('all')) --}}
    <!-- <link href="{{ asset('/css/sp.css') }}" rel="stylesheet"> -->
{{-- @endif --}}
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="{{asset('/js/script.js') }}"></script>
</head>
