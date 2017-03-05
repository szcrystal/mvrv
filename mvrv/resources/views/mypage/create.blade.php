@extends('layouts.appSingle')

@section('content')

    <div class="row">
        <div class="col-md-12 py-4 mp-create">
        	<a href="{{url('/mypage/newmovie')}}" class="back-btn"><i class="fa fa-angle-double-left" aria-hidden="true"></i> マイページへ戻る</a>
            <div class="panel panel-default mt-4">
                @if(isset($atcl) && $atcl->owner_id && Auth::user()->id != $atcl->owner_id)
					<p class="mb-4">この動画のオーナーが他のユーザーに決まりました。<br>マイページへ戻り、他の動画を取得してください。</p>
				@else


                <div class="panel-heading clearfix mb-3">
                	<h2 class="h2">{{ isset($atcl) ? $atcl->title.'に記事を書く' : '記事を新規作成' }}</h2>
                @if(isset($atcl))
                    <ul class="list-group col-md-5 float-left">
						<li class="list-group-item"><b>公開状態：</b>
							@if($atcl->open_status)
                            <span class="text-success">公開中</span>
                            @else
                            <span class="text-danger">非公開</span>
                            @endif
                        </li>
                        <li class="list-group-item"><b>更新日時：</b>
							@if($atcl->open_date)
                            {{ Ctm::changeDate($atcl->open_date) }}
                            @else
                            {{ Ctm::changeDate($atcl->created_at) }}
                            @endif
                        </li>
                    </ul>

                    <div class="float-right">
                    	@include('main.shared.movie')
                    </div>
                @endif
                </div>


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

				@if(session('status'))
                	<div class="alert alert-success">
					{{ session('status') }}
                    </div>
                @endif

                <div class="panel-body mt-4">

                    <form class="form-horizontal" role="form" method="POST" action="/mypage" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="user_id" value="{{$userId}}">
                        @if(isset($atcl))
                        <input type="hidden" name="atcl_id" value="{{ $atcl->id }}">
                        @endif

						<div class="clearfix float-right btn-wrap">
                            <div class="form-group float-left">
                                <div>
                                    <input id="keep" type="submit" class="btn btn-primary" name="keep" value="保存する">
                                </div>
                            </div>

                            <div class="form-group float-left">
                                <div class="ml-2">
                                    <input id="open" type="submit" class="btn btn-danger" name="open" value="公開する">
                                </div>
                            </div>
                        </div>


                        <?php //base ------------------------- ?>

                        @include('mypage.shared.baseForm')

						<?php //base END ?>


                        @include('mypage.shared.thumbnailForm')
                        

						<div class="clearfix tag-wrap">
                        @foreach($tagGroupAll as $group)
                        	<?php $allNames = array(); ?>

							@if(isset($tags[$group->id]))
                                @foreach($tags[$group->id] as $tag)
                                    <?php $allNames[] = $tag['name']; ?>
                                @endforeach
                            @endif

                        	<div class="tag-group form-group{{ $errors->has($group->slug) ? ' has-error' : '' }}">
                                <label for="title" class="control-label">{{ $group->name }}</label>
                                <div class="clearfix">
                                    <input id="{{ $group->slug }}" type="text" class="form-control tag-control" name="input-{{ $group->slug }}" value="" autocomplete="off">

                                    <div class="add-btn" tabindex="0">追加</div>

                                    <span style="display:none;">{{ implode(',', $allNames) }}</span>

                                    <div class="tag-area">
										@if(count(old()) > 0)
                                            <?php $names = old($group->slug); ?>
											@if(isset($names))
                                                @foreach($names as $name)
                                                <span><em>{{ $name }}</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>
                                                <input type="hidden" name="{{ $group->slug }}[]" value="{{ $name }}">
                                                @endforeach
                                            @endif
										@endif
                                    </div>

                                </div>

                            </div>

                        @endforeach
                        </div><?php //tagwrap ?>

						{{--
						<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">タイトル</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ isset($post) ? $post->title : old('title') }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        --}}


                    <div class="add-item">
                        <div class="visible-none">
                            @include('mypage.shared.itemCtrlNav')

                            @include('mypage.shared.newItemForm')
                        </div>

                        @include('mypage.shared.newItemForm')

                        @if(count(old()) > 0)
                        	@include('mypage.shared.oldForm')
                    	@endif

                    </div><?php /*addItem*/ ?>


                    </form>

                    
                </div>

            @endif

            </div>
        </div>
    </div>
@endsection
