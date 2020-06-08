<!DOCTYPE html>
<html lang="en">

@include('includes.header')

<body>

    @include('includes.navbar')

    @yield('content')

    @yield('scripts')
    
    @include('includes.footer')
</body>
</html>
