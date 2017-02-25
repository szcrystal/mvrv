<div class="item-panel border-dash">
    <div class="add-nav">
        <span><i class="fa fa-plus-circle" aria-hidden="true"></i>ここにアイテムを追加</span>
        <span><i class="fa fa-window-close" aria-hidden="true"></i>閉じる</span>
    </div>

    <div class="item-btn">
        <ul class="clearfix">
            <li class="i-title"><i class="fa fa-th-large" aria-hidden="true"></i>タイトル
            <li class="i-text"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>テキスト
            <li class="i-image"><i class="fa fa-picture-o" aria-hidden="true"></i>画像
            <li class="i-link"><i class="fa fa-link" aria-hidden="true"></i>リンク
        </ul>
    </div>

    <div class="item-form" data-type="new">
        <div class="item-title">
            <label>タイトル</label>
            <input class="main-title" type="text" name="main_title[]" value="">

            <label>オプション</label>
            <select name="title_option[]">
                <option value="1">大見出し</option>
                <option value="2">小見出し</option>
            </select>
            <button class="subm-title">追加</button>
        </div>

        <div class="item-text">
            <label>テキスト</label>
            <textarea class="main-text" name="main_text[]"></textarea>
            <button class="subm-text">追加</button>
        </div>

        <div class="item-image clearfix">
            <div class="preview float-left">
				<span class="no-img">No Image</span>
            </div>
            <div class="float-left">
                <label>アップロード</label>
                <input class="img-file" type="file" name="image_path[]">
                <label>URL入力</label>
                <input class="img-outurl" type="text" name="image_outurl[]">
                <button class="img-check">チェック</button>

                <label>タイトル</label>
                <input class="image-title" type="text" name="image_title[]" value="">
                <label>参照元URL</label>
                <input class="image-orgurl" type="text" name="image_orgurl[]" value="">
                <label>コメント</label>
                <textarea class="image-comment" name="image_comment[]"></textarea>
                <button class="subm-image">追加</button>

                <input class="image-choice-hidden" type="hidden" name="image_choice[]" value="0">
                <input class="image-success-hidden" type="hidden" name="image_success[]" value="0">
            </div>
        </div>

        <div class="item-link">
            <label>リンクボタンオプション</label>
            <select name="link_option[]">
                <option value="1">通常リンク</option>
                <option value="2">ボタンタイプA</option>
                <option value="3">ボタンタイプB</option>
            </select>
            <label>リンクURL</label>
            <input class="link-url" type="text" name="link_url[]" value="">
            <button class="subm-check">チェック</button>
            <div class="link-frame"></div>
            <button class="subm-link">追加</button>
            <input class="link-title-hidden" type="hidden" name="link_title[]" value="">
            <input class="link-imgurl-hidden" type="hidden" name="link_imgurl[]" value="">
            <input class="link-imgpath-hidden" type="hidden" name="link_imgpath[]" value="">
        </div>

        <input class="type-hidden" type="hidden" name="item_type[]" value="">
        <input type="hidden" name="image_path_hidden[]" value="">
        <input class="item-id-hidden" type="hidden" name="item_id[]" value="">
        <input class="delete-hidden" type="hidden" name="delete_key[]" value="">
    </div>
</div>

