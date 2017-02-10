
<div id="right-bar">
    <div class="panel panel-default">

            <div class="panel-body">
                <div class="adv">

                </div>

                <div>
                <h5>{{ $rankName }} TOP20</h5>
                <ul class="side-rank">
                <?php $n = 1; ?>
                @foreach($rightRanks as $val)
                    <li>
                    	@if($n < 4)
                        <span class="rank-{{ $n }}">{{ $n }}</span>
                        @else
                        <span class="rank-n">{{ $n }}</span>
                        @endif
                        <a href="{{url('m/'.$val->id)}}">{{ Ctm::shortStr($val->title, 25) }}</a>
                    </li>
                    <?php $n++; ?>
                @endforeach

                </ul>
                </div>

            </div>
        </div>

</div>

