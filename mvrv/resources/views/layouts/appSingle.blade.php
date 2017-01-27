@include('shared.header')
<body>

    <div id="app">
        @include('shared.headNav')


        @yield('content')


    </div>


@include('shared.footer')

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
