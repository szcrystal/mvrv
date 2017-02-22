<div class="item-panel border-dash">
    <div class="item-form" data-type="edit">
        <div class="item-title">
            <label>タイトル</label>
            <input class="main-title" type="text" name="main_title[]" value="{{old('main_title')[$key]}}">

            <label>オプション</label>
            <select name="title_option[]">
                <option value="1"{{old('title_option')[$key]==1 ? ' selected' : ''}}>大見出し</option>
                <option value="2"{{old('title_option')[$key]==2 ? ' selected' : ''}}>小見出し</option>
            </select>
            <button class="subm-title">変更</button>
        </div>
        <div class="item-text">
            <label>テキスト</label>
            <textarea class="main-text" name="main_text[]">{{ old('main_text')[$key] }}</textarea>
            <button class="subm-text">変更</button>
        </div>


        <div class="item-image clearfix">
            <div class="preview float-left">
				@if(old('image_path_hidden')[$key])
				<img src="{{ Storage::url(old('image_path_hidden')[$key]) }}" width="200">
                @elseif(old('image_outurl')[$key])
				<img src="{{ old('image_outurl')[$key] }}" width="200">
                @else
                <span class="no-img">No Image</span>
                @endif
            </div>
            <div class="float-left">
                <label>アップロード</label>
                <input class="img-file" type="file" name="image_path[]">
                <label>URL入力</label>
                <input class="img-outurl" type="text" name="image_outurl[]" value="{{ old('image_outurl')[$key] }}">
                <button class="img-check">チェック</button>

                <label>タイトル</label>
                <input class="image-title" type="text" name="image_title[]" value="{{old('image_title')[$key]}}">
                <label>参照元URL</label>
                <input class="image-orgurl" type="text" name="image_orgurl[]" value="{{old('image_orgurl')[$key]}}">
                <label>コメント</label>
                <textarea class="image-comment" name="image_comment[]">{{old('image_comment')[$key]}}</textarea>
                <button class="subm-image">変更</button>

                <input class="image-choice-hidden" type="hidden" name="image_choice[]" value="{{ old('image_choice')[$key] }}">
                <input class="image-success-hidden" type="hidden" name="image_success[]" value="{{ old('image_success')[$key] }}">
            </div>
        </div>


        <div class="item-link">
            <label>リンクボタンオプション</label>
            <select name="link_option[]">
                <option value="1"{{old('link_option')[$key]==1 ? ' selected' : ''}}>通常リンク</option>
                <option value="2"{{old('link_option')[$key]==2 ? ' selected' : ''}}>ボタンタイプA</option>
                <option value="3"{{old('link_option')[$key]==3 ? ' selected' : ''}}>ボタンタイプB</option>
            </select>
            <label>リンクURL</label>
            <input class="link-url" type="text" name="link_url[]" value="{{ old('link_url')[$key] }}">
            <button class="subm-check">チェック</button>
            <div class="link-frame">
                <span data-success="1">タイトル： </span><div>{{ old('link_title')[$key] }}</div>
                <span>URL： </span><div>{{ old('link_url')[$key] }}</div>
                <div class="linkimg-wrap">
				@if(old('link_imgurl')[$key])
                	<img src="{{ old('link_imgurl')[$key] }}">
                @elseif(old('link_imgpath')[$key])
                	<img src="{{ Storage::url(old('link_imgpath')[$key]) }}" data-linkimg="0">
                @endif
                </div>
            </div>
            <button class="subm-link">変更</button>
            <input class="link-title-hidden" type="hidden" name="link_title[]" value="{{ old('link_title')[$key] }}">
            <input class="link-imgurl-hidden" type="hidden" name="link_imgurl[]" value="{{ old('link_imgurl')[$key] }}">
            <input class="link-imgpath-hidden" type="hidden" name="link_imgpath[]" value="{{ old('link_imgpath')[$key] }}">
        </div>

        <input type="hidden" name="item_type[]" value="{{ old('item_type')[$key] }}">
        <input type="hidden" name="image_path_hidden[]" value="{{old('image_path_hidden')[$key]}}">
        <input class="item-id-hidden" type="hidden" name="item_id[]" value="{{ old('item_id')[$key] }}">
        <input class="delete-hidden" type="hidden" name="delete_key[]" value="">

    </div>
</div>
