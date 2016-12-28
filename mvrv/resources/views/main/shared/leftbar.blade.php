
<div id="left-bar" class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">Left-bar</div>

            <div class="panel-body">
                <div>
                <h4>カテゴリ</h4>
                <ul class="no-list">
                <?php foreach($cates as $val) { ?>
                    <li style="border: 1px solid #aaa;">
                        <a href="{{url('/category/'.$val->slug)}}">{{$val->name}}</a>
                    </li>
                <?php } ?>

                </ul>
                </div>

                <div>
                <h4>人気タグ</h4>
                <ul class="no-list">
                <?php foreach($tagRanks as $val) { ?>
                    <li style="border: 1px solid #aaa;">
                        <p><a href="{{url('/tag/'.$val->slug)}}">{{$val->name}}</a></p>

                    </li>
                <?php } ?>

                </ul>
                </div>

                <div class="adv">
                    <h4>広告枠</h4>

                </div>

            </div>
        </div>

    </div>
</div>

