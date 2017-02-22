
<?php $item_type = ''; ?>

@if(isset($item))
	<?php $item_type = $item->item_type; ?>
@endif

<ul class="ctrl-nav">
    <li class="edit-sec" data-target="{{$item_type}}">編集</li>
    <li class="del-sec">削除</li>
    <li class="up-sec"><i class="fa fa-arrow-up" aria-hidden="true"></i></li>
    <li class="down-sec"><i class="fa fa-arrow-down" aria-hidden="true"></i></li>
</ul>
