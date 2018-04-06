@include('admin.layouts.head')
<body>
    @include ('admin.layouts.sidebar')
    <div class="main-panel" id="app">
        @include ('admin.layouts.navbar')
        <div class="page-top d-flex justify-content-between ">
            <div class="page-title">@yield('page-title')</div>
            <nav class="d-none d-md-block" aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    @yield('page-breadcrumb')
                </ol>
            </nav>
        </div>
        <div class="content main-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    @include ('admin.layouts.footer')
</body>
@yield('page-scripts')
@include('admin.layouts.scripts')
</html>