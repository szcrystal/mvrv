@include('shared.header')
<body>

    <div id="app">
        @include('shared.headNav')

		<div class="container wrap-all single">
        @yield('content')
        </div>


    </div>


@include('shared.footer')

</body>
</html>
