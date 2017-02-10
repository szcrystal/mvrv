<div class="item-panel border-dash">
    <div class="item-form" data-type="edit">
        <div class="item-title">
            <label>タイトル</label>
            <input class="main-title" type="text" name="main_title[]" value="{{$item->main_title}}">

            <label>オプション</label>
            <select name="title_option[]">
                <option value="1"{{$item->title_option==1 ? ' selected' : ''}}>大見出し</option>
                <option value="2"{{$item->title_option==2 ? ' selected' : ''}}>小見出し</option>
            </select>
            <button class="subm-title">変更</button>
        </div>
        <div class="item-text">
            <label>テキスト</label>
            <textarea class="main-text" name="main_text[]">{{$item->main_text}}</textarea>
            <button class="subm-text">変更</button>
        </div>
        <div class="item-image clearfix">
            <div class="preview float-left">
				@if($item->image_path == '')
                <span class="no-img">No Image</span>
                @else
                <img src="{{ Storage::url($item->image_path) }}" width="200">
                @endif
            </div>
            <div class="float-left">
                <label>アップロード</label>
                <input class="img-file" type="file" name="image_path[]">
                <label>URL入力</label>
                <input class="img-outurl" type="text" name="image_outurl[]">
                <button class="img-check">チェック</button>

                <label>タイトル</label>
                <input class="image-title" type="text" name="image_title[]" value="{{$item->image_title}}">
                <label>参照元URL</label>
                <input class="image-orgurl" type="text" name="image_orgurl[]" value="{{$item->image_orgurl}}">
                <label>コメント</label>
                <textarea class="image-comment" name="image_comment[]">{{$item->image_comment}}</textarea>
                <button class="subm-image">変更</button>

                <input class="image-choice-hidden" type="hidden" name="image_choice[]" value="0">
                <input class="image-success-hidden" type="hidden" name="image_success[]" value="0">
            </div>
        </div>
        <div class="item-link">
            <label>リンクボタンオプション</label>
            <select name="link_option[]">
                <option value="1"{{$item->link_option==1 ? ' selected' : ''}}>通常リンク</option>
                <option value="2"{{$item->link_option==2 ? ' selected' : ''}}>ボタンタイプA</option>
                <option value="3"{{$item->link_option==3 ? ' selected' : ''}}>ボタンタイプB</option>
            </select>
            <label>リンクURL</label>
            <input class="link-url" type="text" name="link_url[]" value="{{$item->link_url}}">
            <button class="subm-check">チェック</button>
            <div class="link-frame">
                <span>タイトル： </span><div>{{ $item->link_title }}</div>
                <span>URL： </span><div>{{$item->link_url}}</div>
                <div class="linkimg-wrap">
				@if($item->link_imgurl)
                	<img src="{{$item->link_imgurl}}">
                @endif
                </div>
            </div>
            <button class="subm-link">変更</button>
            <input class="link-title-hidden" type="hidden" name="link_title[]" value="{{ $item->link_title }}">
            <input class="link-imgurl-hidden" type="hidden" name="link_imgurl[]" value="{{$item->link_imgurl}}">
        </div>

        <input type="hidden" name="item_type[]" value="{{$item->item_type}}">
        <input type="hidden" name="image_path_hidden[]" value="{{$item->image_path}}">
        <input class="item-id-hidden" type="hidden" name="item_id[]" value="{{ $item->id }}">
        <input class="delete-hidden" type="hidden" name="delete_key[]" value="">
    </div>
</div>
