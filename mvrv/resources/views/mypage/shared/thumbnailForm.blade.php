<div class="row clearfix thumb-wrap">
    <input class="thumb-success-hidden" type="hidden" name="thumb_success" value="{{ old('thumb_success') }}">
    <input class="thumb-choice-hidden" type="hidden" name="thumb_choice" value="{{ old('thumb_choice') }}">

    <div class="float-left col-md-3 thumb-prev">
    	@if(count(old()) > 0)
            @if(old('thumbnail_outurl') != '' && old('thumb_choice'))
			<img src="{{ Storage::url(old('thumbnail_outurl')) }}" class="img-fluid">
			@elseif(isset($atcl) && $atcl->thumbnail)
            <img src="{{ Storage::url($atcl->thumbnail) }}" class="img-fluid">
            @else
            <span class="no-img">No Image</span>
            @endif
        @elseif(isset($atcl) && $atcl->thumbnail)
        <img src="{{ Storage::url($atcl->thumbnail) }}" class="img-fluid">
        @else
        <span class="no-img">No Image</span>
        @endif
    </div>

    <div class="float-left col-md-9">
        <div class="form-group{{ $errors->has('thumbnail') ? ' has-error' : '' }}">
            <label for="thumbnail" class="col-md-10 control-label">サムネイル アップロード</label>
            <div class="col-md-10">
                <input id="thumbnail" class="thumb-file" type="file" name="thumbnail">
            </div>
        </div>

        <div class="form-group{{ $errors->has('thumbnail_outurl') ? ' has-error' : '' }}">
            <label for="thumbnail_outurl" class="col-md-10 control-label">URL入力</label>
            <div class="col-md-10">
                <input id="thumbnail_outurl" type="text" class="form-control" name="thumbnail_outurl" value="{{ count(old()) >0 ? old('thumbnail_outurl') : (isset($atcl) ? $atcl->thumbnail_org : '') }}">

                @if ($errors->has('thumbnail_outurl'))
                    <span class="help-block">
                        <strong>{{ $errors->first('thumbnail_outurl') }}</strong>
                    </span>
                @endif
                <button class="thumb-check">チェック</button>
            </div>

        </div>

        <div class="form-group{{ $errors->has('thumbnail_org') ? ' has-error' : '' }}">
            <label for="thumbnail_org" class="col-md-10 control-label">サムネイル参照元URL</label>
            <div class="col-md-10">
                <input id="thumbnail_org" type="text" class="form-control" name="thumbnail_org" value="{{ count(old()) >0 ? old('thumbnail_org') : (isset($atcl) ? $atcl->thumbnail_org : '') }}">

                @if ($errors->has('thumbnail_org'))
                    <span class="help-block">
                        <strong>{{ $errors->first('thumbnail_org') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('thumbnail_comment') ? ' has-error' : '' }}">
            <label for="thumbnail_comment" class="col-md-10 control-label">コメント</label>
            <div class="col-md-10">
                <textarea id="thumbnail_comment" class="form-control" name="thumbnail_comment">{{ count(old()) >0 ? old('thumbnail_comment') : (isset($atcl) ? $atcl->thumbnail_comment : '') }}</textarea>

                @if ($errors->has('thumbnail_comment'))
                    <span class="help-block">
                        <strong>{{ $errors->first('thumbnail_comment') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
