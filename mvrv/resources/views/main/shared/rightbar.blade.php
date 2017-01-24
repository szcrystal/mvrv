
<div id="right-bar" class="row">
    <div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">right-bar</div>

            <div class="panel-body">
                <div class="adv">
                    <h4>広告枠</h4>
                </div>

                <div>
                <h4>{{ $rankName }} TOP20</h4>
                <ul class="no-list">
                <?php foreach($rightRanks as $val) { ?>
                    <li style="border: 1px solid #aaa;">
                        <a href="{{url('/single/'.$val->id)}}">{{$val->title}}</a>
                    </li>
                <?php } ?>

                </ul>
                </div>

            </div>
        </div>

    </div>
</div>

