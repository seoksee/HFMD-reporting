@extends('layouts.user_home')

@section('content')
    @if(Session::has('alert'))
        <script type="text/javascript">
            alert("{{ Session::get('alert') }}");
        </script>
    @endif

    <div class="">
        <iframe src="https://www.google.com/maps/d/u/1/embed?mid=1IBeOLOeXvLV2-NVdi5rKAcK73tsMtMKj" width="100%" height="800em"></iframe>
    </div>

@endsection
