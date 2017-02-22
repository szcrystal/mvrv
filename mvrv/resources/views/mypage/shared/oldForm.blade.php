@foreach(old('item_type') as $key => $type)
    @if($type == 'title')
        <section{!! old('delete_key')[$key] ? ' style="display:none;"' : '' !!}>
            <ul class="ctrl-nav">
                <li class="edit-sec" data-target="{{$type}}">編集</li>
                <li class="del-sec">削除</li>
                <li class="up-sec"><i class="fa fa-arrow-up" aria-hidden="true"></i></li>
                <li class="down-sec"><i class="fa fa-arrow-down" aria-hidden="true"></i></li>
            </ul>

            @if(old('title_option')[$key] == 1)
                <h1>{{ old('main_title')[$key] }}</h1>
            @else
                <h2>{{ old('main_title')[$key] }}</h2>
            @endif

            @include('mypage.shared.oldItemForm')
        </section>

        @if(!old('delete_key')[$key])
        	@include('mypage.shared.newItemForm')
        @endif

    @elseif($type == 'text')
        <section{!! old('delete_key')[$key] ? ' style="display:none;"' : '' !!}>
            <ul class="ctrl-nav">
                <li class="edit-sec" data-target="{{$type}}">編集</li>
                <li class="del-sec">削除</li>
                <li class="up-sec"><i class="fa fa-arrow-up" aria-hidden="true"></i></li>
                <li class="down-sec"><i class="fa fa-arrow-down" aria-hidden="true"></i></li>
            </ul>

            <p>{!! nl2br(old('main_text')[$key]) !!}</p>

            @include('mypage.shared.oldItemForm')
        </section>

        @if(!old('delete_key')[$key])
        	@include('mypage.shared.newItemForm')
        @endif

    @elseif($type == 'image')
        <section{!! old('delete_key')[$key] ? ' style="display:none;"' : '' !!}>
            <ul class="ctrl-nav">
                <li class="edit-sec" data-target="{{$type}}">編集</li>
                <li class="del-sec">削除</li>
                <li class="up-sec"><i class="fa fa-arrow-up" aria-hidden="true"></i></li>
                <li class="down-sec"><i class="fa fa-arrow-down" aria-hidden="true"></i></li>
            </ul>

            <div class="preview float-left">
            @if(old('image_path_hidden')[$key] != '')
            <img src="{{ Storage::url(old('image_path_hidden')[$key]) }}" width="200">
            @elseif(old('image_outurl')[$key])
            <img src="{{ old('image_outurl')[$key] }}" width="200">
            @else
            <span class="no-img">No Image</span>
            @endif
            </div>
            <h4>{{ old('image_title')[$key] }}</h4>
            <p>引用元：{{ old('image_orgurl')[$key] }}</p>
            <p>コメント：<br>{!! nl2br(old('image_comment')[$key]) !!}</p>

            @include('mypage.shared.oldItemForm')
        </section>

        @if(!old('delete_key')[$key])
        	@include('mypage.shared.newItemForm')
        @endif

    @elseif($type == 'link')
        <section{!! old('delete_key')[$key] ? ' style="display:none;"' : '' !!}>
            <ul class="ctrl-nav">
                <li class="edit-sec" data-target="{{$type}}">編集</li>
                <li class="del-sec">削除</li>
                <li class="up-sec"><i class="fa fa-arrow-up" aria-hidden="true"></i></li>
                <li class="down-sec"><i class="fa fa-arrow-down" aria-hidden="true"></i></li>
            </ul>

            <div class="link-box single-link">
            @if(old('link_option')[$key] == 2)
                <a href="{{ old('link_url')[$key] }}" class="type-a">{{ old('link_title')[$key] }}<i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            @elseif(old('link_option')[$key] == 3)
                <a href="{{ old('link_url')[$key] }}" class="type-b">{{ old('link_title')[$key] }}<i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            @elseif(old('link_imgurl')[$key])
            	<a href="{{ old('link_url')[$key] }}" title="{{ old('link_title')[$key] }}"><img src="{{ old('link_imgurl')[$key] }}"></a>
            @elseif(old('link_imgpath')[$key])
            	<a href="{{ old('link_url')[$key] }}" title="{{ old('link_title')[$key] }}"><img src="{{ Storage::url(old('link_imgpath')[$key]) }}"></a>
            @else
            	<a href="{{ old('link_url')[$key] }}">{{ old('link_title')[$key] }}</a>
            @endif
            </div>

            @include('mypage.shared.oldItemForm')
        </section>

        @if(!old('delete_key')[$key])
            @include('mypage.shared.newItemForm')
        @endif

    @endif


    {{-- @include('mypage.shared.newItemForm') --}}

@endforeach

