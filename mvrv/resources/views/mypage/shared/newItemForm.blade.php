<div class="item-panel">
    <div class="clearfix add-nav">
        <em>ここにアイテムを追加</em>
    </div>

    <div class="item-btn">
        <ul class="clearfix">
            <li class="i-title">タイトル
            <li class="i-text">テキスト
            <li class="i-image">画像
            <li class="i-link">リンク
        </ul>
    </div>

    <div class="item-form" data-type="new">
        <div class="item-title">
            <label>タイトル</label>
            <input class="main-title" type="text" name="main_title[]" value="">
            <select name="title_option[]">
                <option value="1">大見出し</option>
                <option value="2">小見出し</option>
            </select>
            <button class="subm-title">Send</button>
        </div>

        <div class="item-text">
            <label>テキスト</label>
            <textarea class="main-text" name="main_text[]"></textarea>
            <button class="subm-text">send</button>
        </div>

        <div class="item-image">
            <div class="preview"></div>
            <label>画像</label>
            <input class="img-file" type="file" name="image_path[]">
            <label>画像タイトル</label>
            <input class="image-title" type="text" name="image_title[]" value="">
            <label>引用元URL</label>
            <input class="image-orgurl" type="text" name="image_orgurl[]" value="">
            <label>コメント</label>
            <textarea class="image-comment" name="image_comment[]"></textarea>
            <button class="subm-image">Send</button>
        </div>

        <div class="item-link">
            <label>リンク</label>
            <select name="link_option[]">
                <option value="1">通常リンク</option>
                <option value="2">ボタンタイプA</option>
                <option value="3">ボタンタイプB</option>
            </select>
            <input class="link-url" type="text" name="link_url[]" value="http://www.yahoo.co.jp">
            <button class="subm-check">チェック</button>
            <div class="link-frame"></div>
            <button class="subm-link">Send</button>
            <input class="link-title-hidden" type="hidden" name="link_title[]" value="">
            <input class="link-imgurl-hidden" type="hidden" name="link_imgurl[]" value="">
        </div>

        <input class="type-hidden" type="hidden" name="item_type[]" value="">
        <input type="hidden" name="image_path_hidden[]" value="">
        <input class="item-id-hidden" type="hidden" name="item_id[]" value="">
        <input class="delete-hidden" type="hidden" name="delete_key[]" value="">
    </div>
</div>

