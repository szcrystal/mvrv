@extends('layouts.appSingle')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<h2>{{ $atcl -> title }}のレビュー</h2>

                    @if($atcl -> movie_url != '')
                    	<?php $embed = explode('=', $atcl -> movie_url);
                        //echo $embed[1];
                        //https://youtu.be/1oeN1gmLzvM
                    	?>

                		<iframe width="560" height="315" src="https://www.youtube.com/embed/{{$embed[1]}}" frameborder="0" allowfullscreen></iframe>
                    @endif
				</div>

                <div class="panel-body">

					<div class="clear">
                    <div class="pull-right">
						<a href="{{ url('contact') }}" class="btn btn-danger center-block">削除を依頼</a>
                    </div>
                    </div>

                    <div class="table-responsive">
                    	<table class="table table-striped table-bordered">
                            <colgroup>
                                <col class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <tbody>
                                <tr>
                                    <th>動画タイトル</th>
                                    <td>{{ $atcl -> title }}</td>
                                </tr>
                                <tr>
									<th>動画サイト</th>
                                    <td><a href="{{ $atcl -> movie_url }}">{{ $atcl -> movie_url }}</a></td>
                                </tr>
                                <tr>
                                    <th>カテゴリー</th>
                                    <td>{{ $atcl -> category }}</td>
                                </tr>
                                <tr>
                                    <th>タグ１</th>
                                    <td><?php if(!$tags[0]->isEmpty()) {
                                        foreach($tags[0] as $tag)
                                            echo '<a href="'. url('/tag/'.$tag->id).'">'.$tag->name .'</a>, ';
                                    } ?></td>
                                </tr>
                                <tr>
                                    <th>タグ２</th>
                                    <td><?php if(!$tags[1]->isEmpty()) {
                                        foreach($tags[1] as $tag)
                                            echo '<a href="'. url('/tag/'.$tag->id).'">'.$tag->name .'</a>, ';
                                    } ?></td>
                                </tr>
                                <tr>
                                    <th>タグ３</th>
                                    <td><?php if(!$tags[2]->isEmpty()) {
                                        foreach($tags[2] as $tag)
                                            echo '<a href="'. url('/tag/'.$tag->id).'">'.$tag->name .'</a>, ';
                                    } ?></td>
                                </tr>
                                

                            </tbody>
                		</table>
                    </div>

                    <div>
                    	サムネイル：{{ $atcl -> sumbnail }}
                        引用元：{{ $atcl -> sumbnail_url }}

                        <div class="meta">
                        	<small>公開日時：{{ date('Y年n月j日', strtotime($atcl -> open_date)) }}</small><br>
                            <small>レビューオーナー：{{ $user->name }}</small>
                        </div>

                        <div>
							<p>{!! nl2br($atcl->content) !!}</p>
                        </div>







                	</div>

				</div><!-- panelbody -->

            </div>
        </div>
    </div>
</div>
@endsection
