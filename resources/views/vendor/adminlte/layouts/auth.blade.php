<!DOCTYPE html>
<html>

@include('adminlte::layouts.partials.htmlheader')

<!-- start::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >

    @yield('content')

    @include('adminlte::layouts.partials.scripts_auth')
</body>
</html>