@extends('layouts.appSingle')

@section('content')

    <div class="row">
        <div class="col-md-12 py-4 mp-edit">
        	<a href="{{url('mypage')}}" class="back-btn"><i class="fa fa-angle-double-left" aria-hidden="true"></i> マイページへ戻る</a>
            <div class="panel panel-default mt-4">
                <div class="panel-heading clearfix mb-3">
                	<h2 class="h2">{{ $atcl->title }} の記事を編集</h2>
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
                    {{--
                    @foreach($tagGroups as $key => $tagArr)
                    <tr>
                        <th>タグ: {{ $tagGroupModel->find($key)->name }}</th>
                        <td>
                        @foreach($tagArr as $tag)
                            <a href="{{ url('tag/'. $tag['slug']) }}">{{ $tag['name'] }}</a>
                        @endforeach
                        </td>
                    </tr>
                    @endforeach
                    --}}

                    <?php //$groupAll = $tagGroupModel->all(); ?>

                    {{--
                    @foreach($tagGroupAll as $group)
                    <tr>
                        <th>{{ $group->name }}</th>
                        <td>
                        @if(isset($tagGroups[$group->id]))
                            @foreach($tagGroups[$group->id] as $tag)
                                <a href="{{ url($group->slug .'/'. $tag['slug']) }}">{{ $tag['name'] }}</a>&nbsp;&nbsp;
                            @endforeach
                        @endif
                        </td>
                    </tr>

                    @endforeach
                    --}}

                    <form class="form-horizontal" role="form" method="POST" action="/mypage/{{ $atcl->id }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

						<div class="clearfix mb-5">
                            @if($atcl->open_history)
                                <div class="form-group text-right">
                                    <div class="">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="not_newdate" value="1" {{isset($atcl) && $atcl->not_newdate ? 'checked' : '' }}> 更新日時を変更しない
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="clearfix float-right">
                                <div class="form-group float-left">
                                    <div>
                                        <input id="preview" type="submit" class="btn btn-warning" name="preview" value="保存してプレビュー">
                                    </div>
                                </div>
                                <div class="form-group float-left">
                                    <div class="ml-2">
                                        <input id="keep" type="submit" class="btn btn-primary" name="keep" value="保存する">
                                    </div>
                                </div>
                                @if($atcl->open_status)
                                <div class="form-group float-left">
                                    <div class="ml-2">
                                        <input id="drop" type="submit" class="btn btn-info" name="drop" value="公開を取り下げ">
                                    </div>
                                </div>
                                @else
                                <div class="form-group float-left">
                                    <div class="ml-2">
                                        <input id="open" type="submit" class="btn btn-danger" name="open" value="公開する">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <?php //base ------------------------- ?>

                        @include('mypage.shared.baseForm')

						<?php //thumbnail --------------------- ?>

                        @include('mypage.shared.thumbnailForm')
                        

                        <div class="clearfix tag-wrap">

						@foreach($tagGroupAll as $group)
                        	<?php
                            	$names = array();
                            	$allNames = array();
                            ?>

                            @if(isset($tagGroups[$group->id]))
								@foreach($tagGroups[$group->id] as $tag)
									<?php $names[] = $tag['name']; ?>
                                @endforeach
                            @endif

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
                                    	<?php
                                        	if(count(old()) > 0) {
                                        		$names = old($group->slug);
                                        	}
                                        ?>

                                        @if(isset($names))
										@foreach($names as $name)
											<span><em>{{ $name }}</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>
           									<input type="hidden" name="{{ $group->slug }}[]" value="{{ $name }}">
                                        @endforeach
                                        @endif

                                    </div>
                                </div>
                            </div>

                        @endforeach

                        </div><?php //tagwrap ?>


                        {{--
                        	@foreach($tagGroups as $key => $tagArr)
                                    //$groupSlug = $tagGroupModel->find($key)->slug;
                            
                                @foreach($tagArr as $tag)
                                        //$tagNames[$groupSlug][] = $tag['name'];
                            
                                @endforeach

                            @endforeach
                            <div class="form-group{{ $errors->has($key) ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">タグ：{{ $tagGroupModel->find($key)->name }}</label>
                                <div class="col-md-6">
                                    <input id="keyword" type="text" class="form-control" name="{{ $tagGroupModel->find($key)->slug }}" value="{{ implode(' ', $tagNames) }}" required>
                                </div>
                            </div>
                        --}}


				<?php //print_r(old()); ?>


                <div class="add-item">
                	<div class="visible-none">
                        @include('mypage.shared.itemCtrlNav')

                        @include('mypage.shared.newItemForm')
                    </div>

                    @include('mypage.shared.newItemForm')
                    {{-- <div class="item-panel first-panel"> --}}

					<?php //print_r(old('item_type')); ?>

                    @if(count(old()) > 0)
                        @include('mypage.shared.oldForm')
                    @else


                    @foreach($items as $item)
                        @if($item->item_type == 'title')
                            <section>
								@include('mypage.shared.itemCtrlNav')

                                @if($item->title_option == 1)
                                    <h1>{{ $item->main_title }}</h1>
                                @else
                                    <h2>{{ $item->main_title }}</h2>
                                @endif

                                @include('mypage.shared.editItemForm')
                            </section>

                        @elseif($item->item_type == 'text')
                            <section>
                                @include('mypage.shared.itemCtrlNav')

                                <p>{!! nl2br($item->main_text) !!}</p>

                                @include('mypage.shared.editItemForm')
                            </section>

                        @elseif($item->item_type == 'image')
                            <section>
                                @include('mypage.shared.itemCtrlNav')

                                <div class="preview float-left">
                                @if($item->image_path == '')
								<span class="no-img">No Image</span>
                                @else
                                <img src="{{ Storage::url($item->image_path) }}" width="200">
                                @endif
								</div>
                                <h4>{{$item->image_title}}</h4>
                                <p>引用元：{{$item->image_orgurl}}</p>
                                <p>コメント：<br>{!! nl2br($item->image_comment) !!}</p>

                                @include('mypage.shared.editItemForm')
                            </section>

                        @elseif($item->item_type == 'link')
                            <section>
                                @include('mypage.shared.itemCtrlNav')

                                <div class="link-box single-link">
                                @if($item->link_option == 2)
                                    <a href="{{ $item->link_url }}" class="type-a">{{ $item->link_title }}<i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                                @elseif($item->link_option == 3)
                                    <a href="{{ $item->link_url }}" class="type-b">{{ $item->link_title }}<i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                                @elseif($item->link_imgpath != '')
                                	<a href="{{ $item->link_url}}" title="{{ $item->link_title }}"><img src="{{ Storage::url($item->link_imgpath) }}"></a>
                                @else
                                    <a href="{{ $item->link_url }}" class="type-n">{{ $item->link_title }}<i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                                @endif
                                </div>

                            	@include('mypage.shared.editItemForm')
                            </section>

                        @endif


						@include('mypage.shared.newItemForm')

                    @endforeach

                    @endif


                </div><?php /*addItem*/ ?>




					</form>

                    
                </div>
            </div>
        </div>
    </div>
@endsection
