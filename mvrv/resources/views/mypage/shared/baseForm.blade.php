<div class="row clearfix mt-3 mb-5 base-wrap">
    <div class="form-group col-md-10{{ $errors->has('title') ? ' has-error' : '' }}">
        <label for="title" class="">動画タイトル</label>
            <input id="title" type="text" class="form-control" name="title" value="{{ Ctm::isOld() ? old('title') : (isset($atcl) ? $atcl->title : '') }}">
            <span class="help-block text-danger">
                <strong>{{ $errors->first('title') }}</strong>
            </span>

			{{--
            @if ($errors->has('title'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
            --}}
    </div>

    <div class="form-group col-md-10{{ $errors->has('movie_site') ? ' has-error' : '' }}">
        <label for="movie_site" class="control-label">動画サイト</label>
        <input id="movie_site" type="text" class="form-control" name="movie_site" value="{{ Ctm::isOld() ? old('movie_site') : (isset($atcl) ? $atcl->movie_site : '') }}" placeholder="youtubeやniconico、vimeoなど">
        <span class="help-block text-danger">
            <strong>{{ $errors->first('movie_site') }}</strong>
        </span>
    </div>

    <div class="form-group col-md-10{{ $errors->has('movie_url') ? ' has-error' : '' }}">
        <label for="movie_url" class="control-label">動画URL</label>
        <input id="movie_url" type="text" class="form-control" name="movie_url" value="{{ Ctm::isOld() ? old('movie_url') : (isset($atcl) ? $atcl->movie_url : '') }}">
        <span class="help-block text-danger">
            <strong>{{ $errors->first('movie_url') }}</strong>
        </span>
        <div style="display:none;" class="movie-url">
			{{ implode(',', $movieUrl) }}
        </div>
    </div>

    <div class="form-group col-md-5{{ $errors->has('cate_id') ? ' has-error' : '' }}">
        <label for="cate_id" class="control-label">カテゴリー</label>
            <select id="cate_id" class="form-control" name="cate_id">
                <option disabled selected>選択</option>
                @foreach($cates as $cat)
                    <?php
                        $selected = '';
                        if(Ctm::isOld()) {
                            if(old('cate_id') == $cat->id) {
                                $selected = 'selected';
                            }
                        }
                        else{
                            if(isset($atcl) && $atcl->cate_id == $cat->id) {
                                $selected = 'selected';
                            }
                        }
                    ?>
                    <option value="{{ $cat->id }}" {{ $selected }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <span class="help-block text-danger">
                <strong>{{ $errors->first('cate_id') }}</strong>
            </span>
    </div>
</div>

