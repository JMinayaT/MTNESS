@include('admin.layouts.head')
<body>
    @include ('admin.layouts.navbar')
    @include ('admin.layouts.sidebar')
    <div class="main-panel" id="app">
        @yield('content')
    </div>
    @include ('admin.layouts.footer')
</body>
@yield('page-scripts')
@include('admin.layouts.scripts')
</html>