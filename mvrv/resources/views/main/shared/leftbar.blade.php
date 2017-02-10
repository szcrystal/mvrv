
<div id="left-bar">
        <div class="panel panel-default">

            <div class="panel-body">
                <div>
                <h5>カテゴリ</h5>
                <ul class="no-list">
                <?php foreach($cateLeft as $val) { ?>
                    <li>
                        <i class="fa fa-crosshairs" aria-hidden="true"></i>
                        <a href="{{url('/category/'.$val->slug)}}">{{$val->name}}</a>
                    </li>
                <?php } ?>

                </ul>
                </div>

                <div>
                <h5>人気タグ</h5>
                <ul class="no-list">
                <?php foreach($tagLeftRanks as $val) { ?>
                    <li class="rank-tag">
                        <i class="fa fa-tag" aria-hidden="true"></i><a href="{{url($groupModel->find($val->group_id)->slug.'/'.$val->slug)}}">{{$val->name}}</a>

                    </li>
                <?php } ?>

                </ul>
                </div>

                <div class="adv">


                </div>

            </div>
        </div>

</div>


