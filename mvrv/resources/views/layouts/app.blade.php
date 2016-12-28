@include('shared.header')
<body>

    <div id="app">
        @include('shared.headNav')

		<div class="container">

			@yield('leftbar')
	        @yield('content')
			@yield('rightbar')

        </div>

    </div>


    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
