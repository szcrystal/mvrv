<div>
    <ul class="main-list">
    	@foreach($atcls as $atcl)
        <li class="clearfix">
            <a href="{{url('/single/'.$atcl->id)}}">
                <div class="pull-left">
                	<img src="{{Storage::url($atcl->thumbnail)}}">
                </div>
                <h2 class="pull-right">{{$atcl->title}}</h2></a>

        </li>
    	@endforeach

</ul>
{{ $atcls->links() }}
</div>

