<!DOCTYPE html>
<html lang="en">
{{-- @include('includes.header') --}}
@include('includes.admin_header')


<body>
    @include('includes.admin_navbar')

    @include('includes.admin_sidebar')

    @yield('content')

    @include('includes.admin_footer')
</body>

</html>
