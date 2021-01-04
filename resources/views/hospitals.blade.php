@extends('layouts.user_home')

@section('content')
    @if(Session::has('alert'))
        <script type="text/javascript">
            alert("{{ Session::get('alert') }}");
        </script>
    @endif

    <div class="row report-container" style="margin-top: 0%">
        <div class="col-12 col-md-2 container m-auto" style="vertical-align: middle">
            <select name="state" id="state" class="custom-select animated--fade-in dynamic">
                <option value="">by State</option>
                <option value="1">Johor</option>
                <option value="2">Kedah</option>
                <option value="3">Kelantan</option>
                <option value="4">Melaka</option>
                <option value="5">Negeri Sembilan</option>
                <option value="6">Pahang</option>
                <option value="7">Pulau Pinang</option>
                <option value="8">Perak</option>
                <option value="9">Perlis</option>
                <option value="10">Selangor</option>
                <option value="11">Terengganu</option>
                <option value="12">Sabah</option>
                <option value="13">Sarawak</option>
                <option value="14">W.P. (KL)</option>
                <option value="15">W.P. (Labuan)</option>
                <option value="16">W.P. (Putrajaya)</option>
            </select>
        </div>
        <div class="col-12 col-md-10 p-0">
            <div class="map">
                <iframe src="https://www.google.com/maps/d/u/1/embed?mid=1IBeOLOeXvLV2-NVdi5rKAcK73tsMtMKj" width="100%" height="800em"></iframe>
            </div>

        </div>

    </div>

@endsection

@section('scripts')
    <script>
        $('.dynamic').change(function(){
        console.log("change detected");
        if($(this).text() != '') {
            var value = $(this).val();
            if(value == ""){
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1IBeOLOeXvLV2-NVdi5rKAcK73tsMtMKj" width="100%" height="800em"></iframe></div>');
            } else if(value == "1"){
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1WTP9XWHEGcAWPA5EnnW6-yfV5tBdSHVV" width="100%" height="800em"></iframe></div>')
            } else if(value == "2") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1eUUfwNNgpXtKs7aEdMUWLSphc_ikoT-M" width="100%" height="800em"></iframe></div>')
            } else if(value == "3") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1jgYyl0IqkHnLP_4tTlcygPqCcmnxW7_M" width="100%" height="800em"></iframe></div>')
            } else if(value == "4") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1jKFZMtr7DgeEuwKpvzJ5xrofA9_WgndY" width="100%" height="800em"></iframe></div>')
            } else if(value == "5") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1qFjtd8r14zp1fyHEiKkNMmXRktj4GM5s" width="100%" height="800em"></iframe></div>')
            } else if(value == "6") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=18GHVsrYg4tz4JN-LWX4WWKgHTaoI9fe-" width="100%" height="800em"></iframe></div>')
            } else if(value == "7") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1bAFQwPkKE1vv8oavD6S4KEIN2aRy5frQ" width="100%" height="800em"></iframe></div>')
            } else if(value == "8") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1xsSIbWbIbDT6gAwhY5nk8FOpDhUKvbSX" width="100%" height="800em"></iframe></div>')
            } else if(value == "9") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1q-h1tlfOqIsKMsi6fQyTKiFKd9zsUIS-" width="100%" height="800em"></iframe></div>')
            } else if(value == "10"){
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1I6kZoI9wP35bEPCSNAu_KOG_2LfwQGVE" width="100%" height="800em"></iframe></div>')
            } else if(value == "11") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1w-WHlSti9C7cN-SoMA1d5QP-_FdIK1IM" width="100%" height="800em"></iframe></div>')
            } else if(value == "12") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1-vWhHeMHT8MKXB-kvNirDcuO4j280HJ5" width="100%" height="800em"></iframe></div>')
            } else if(value == "13") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=13L3lxabXYb8ipAgTUbyEcpCVzrZrbvxR" width="100%" height="800em"></iframe></div>')
            } else if(value == "14") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1hR1kklDzJg_cr_Z_IEJk4-I3ZTC9KOYD" width="100%" height="800em"></iframe></div>')
            } else if(value == "15") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1XyFu_5CizgLanNgzTgUecBvu0M-BPWa1" width="100%" height="800em"></iframe></div>')
            } else if(value == "16") {
                $(".map").replaceWith('<div class="map"><iframe src="https://www.google.com/maps/d/u/1/embed?mid=1PPZ53pIq9PXhxFat4l8Ryw0bhcaOKkgI" width="100%" height="800em"></iframe></div>')
            }
        }
    });
    </script>
@endsection
