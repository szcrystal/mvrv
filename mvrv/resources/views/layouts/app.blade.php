@include('shared.header')
<body>

    <div id="app">
        @include('shared.headNav')

		<div class="container wrap-all">
			<div class="row">
            <?php $className = isset($className) ? $className : ''; ?>
    		<div class="col-md-12 py-4 {{ $className }}"><!-- offset-md-1-->
                @yield('leftbar')
                @yield('content')
                @yield('rightbar')
            </div>
            </div>

        </div>

    </div>

@include('shared.footer')

</body>
</html>
