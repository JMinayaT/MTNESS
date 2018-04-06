@include('admin.layouts.head')
<body>
    @include ('admin.layouts.sidebar')
    <div class="main-panel" id="app">
        @include ('admin.layouts.navbar')
        <div class="content">
            <div class="container-fluid">
                <h1 class="mt-3">no tienes permisos para aceder a esta pagina 403</h1>
            </div>
        </div>
    </div>
    @include ('admin.layouts.footer')
</body>
@yield('page-scripts')
@include('admin.layouts.scripts')
</html>