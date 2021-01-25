@extends('layouts.user_home')

@section('content')
@if(Session::has('alert'))
        <script type="text/javascript">
            alert("{{ Session::get('alert') }}");
        </script>
    @endif
<div class="container container-fluid p-5">
    <div class="row justify-content-center">
            <!-- Confirmed cases -->
            <div class="col-md-3 col-12 mb-5">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-md font-weight-bold text-primary text-uppercase mb-1">Confirmed Cases</div>
                      <div class="h1 mb-0 font-weight-bold text-gray-800">{{count($reports)}}</div>
                    </div>
                    {{-- <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div> --}}
                  </div>
                </div>
              </div>
            </div>

            <!-- Fatal -->
            <div class="col-md-3 col-12 mb-5">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-md font-weight-bold text-danger text-uppercase mb-1">Fatal</div>
                      <div class="h1 mb-0 font-weight-bold text-gray-800">{{count($fatal)}}</div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

          <!-- Total -->
          <div class="col-md-3 col-12 mb-5">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-md font-weight-bold text-warning text-uppercase mb-1">Total</div>
                      <div class="h1 mb-0 font-weight-bold text-gray-800">{{count($reports)+count($fatal)}}</div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

    </div>

@if($outbreak != "")
    <div class="row justify-content-center mb-5">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="card border-bottom-danger">
                <div class="card-body">
                    <marquee behavior="scroll" direction="left" scrollamount="8">
                        Outbreak detected! There are more than 3 verified cases at <strong>{{$outbreak}}</strong> in the past 14 days.
                    </marquee>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
@endif

    <div class="">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">This month HFMD Cases Overview</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body row">
                <div class="col-md-10">
                    <div style="overflow-x: scroll">
                    <div class="chart-container" style="position: relative;  width:900px;">
                    {{-- <canvas id="myAreaChart"></canvas> --}}
                    <canvas id="line-chart"></canvas>
                    </div>
                    </div>
                </div>
                <div class="col-md-2 chart-view">
                    <div class="">
                        <button class="btn btn-outline-primary dropdown-toggle" href="#" id="caseDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="selection"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right animated--fade-in" aria-labelledby="caseDropdown" id="case1">
                            <li><a class="dropdown-item" href="#" data-value="day">by Day</a></li>
                            <li><a class="dropdown-item" href="#" data-value="week">by Week</a></li>
                            <li><a class="dropdown-item" href="#" data-value="month">by Month</a></li>
                            <li><a class="dropdown-item" href="#" data-value="year">by Year</a></li>
                        </ul>
                    </div>
                    <div>
                        <br>
                    </div>
                    <form action="#" class="form-group" enctype="multipart/form-data">
                        {{-- <button class="btn btn-outline-primary dropdown-toggle" href="#" id="locationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span id="location_select">by State</span>
                        </button> --}}
                        <select name="state" id="state" data-dependent="district" class="custom-select animated--fade-in dynamic">
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
                        <div><br></div>
                        <div id="district">

                        </div>
                    </form>

                </div>
            </div>
        </div>
        <br>
        <div class="card shadow">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">This month HFMD Cases Overview</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body row">
                <div class="map-area col-md-9">
                    <div height="100%" id="map"></div>
                    {{-- <iframe style="border: 0ch" src="https://upload.wikimedia.org/wikipedia/commons/d/dc/Blank_malaysia_map.svg" height="100%" width="90%" alt=""></iframe> --}}
                </div>
                <div class="col-md-3">
                    <svg width="100" height="250">
                        <circle cx="10" cy="100" r="10" fill="#c8c8c8" /><text fill="#9FA2B4" font-size="20"  x="30" y="108">0</text>
                        <circle cx="10" cy="130" r="10" fill="#FAEBD2" /><text fill="#9FA2B4" font-size="20"  x="30" y="138">1-5</text>
                        <circle cx="10" cy="160" r="10" fill="#E9A188" /><text fill="#9FA2B4" font-size="20"  x="30" y="168">6-10</text>
                        <circle cx="10" cy="190" r="10" fill="#BB3937" /><text fill="#9FA2B4" font-size="20"  x="30" y="198">11-15</text>
                        <circle cx="10" cy="220" r="10" fill="#772526" /><text fill="#9FA2B4" font-size="20"  x="30" y="228">>15</text>
                    </svg>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

<script>
    console.log("outbreak: " + "{{$outbreak}}");
    $('#selection').html("by Month");
    display_chart("by Month", '');

    $('#case1 a').click(function() {
        console.log("clicked");
        $('.dynamic').prop('selected', false).find('option:first').prop('selected', true);
        $('#district').html("");
        $('.district-selection').prop('selected', false).find('option:first').prop('selected', true);
        var selText = $(this).text();
        $('#selection').html(selText);
        // if($('.district-selection').val() != '') {
        //     console.log("im here");
        //     display_chart(selText, report_cases);
        // }
        display_chart(selText, '');
    });

    $('.dynamic').change(function(){
        console.log("change detected");
        if($(this).text() != '') {
            var select = "state_id";
            var value = $(this).val();
            console.log("value: " + value);
            var dependent = $(this).data('dependent');
            var _token = "{{csrf_token()}}";
            var type = $('#selection').html();
            $.ajax({
                url: "/district-chart/fetch",
                method: "POST",
                data: {
                    select: select,
                    value: value,
                    _token: _token,
                    dependent: dependent,
                    type: type.substring(3)
                },
                success: function(result){
                    $('#district').html(result.district);
                    var report_cases = result.report_cases;
                    display_chart($('#selection').html(), report_cases);
                }
            })
        }
    });

    $('#district').on('change','.district-selection',function(){
        console.log("change in district");
        if($(this).text() != '') {
            var select = "id";
            var value = $(this).val();
            console.log("value: " + value);
            var _token = "{{csrf_token()}}";
            var type = $('#selection').html();
            $.ajax({
                url: "/district-chart/fetch",
                method: "POST",
                data: {
                    select: select,
                    value: value,
                    _token: _token,
                    type: type.substring(3)
                },
                success: function(result){
                    var report_cases = result.report_cases;
                    display_chart($('#selection').html(), report_cases);
                }
            })
        }
    });

    function display_chart(value, data) {
        if (value == "by Day"){
            if (data == '') {
                var day = <?php echo $dailyReports; ?>;
            } else {
                var day = data['dailyReports'];
            }
            var i;
            var str="";
            for(i=0; i<31; i++) {
                day[i] = day[i+1];
                if(day[i] == null){
                    day[i] = 0;
                }
                if(i == 30) {
                    str += day[i];
                } else {
                    str= str+day[i]+",";
                }
            };
            var data_day = str.split(",");

            var ctx = $('#line-chart');
            var myChart = new Chart(ctx, {
                type: 'line',
                data:
                {
                    labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"],
                    datasets: [{
                        label: 'Number of Cases',
                        data:
                        data_day
                    ,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        } else if (value == "by Week") {
            if (data == '') {
                var week = <?php echo $weeklyReports; ?>;
            } else {
                var week = data['weeklyReports'];
            }
            var i;
            var str="";
            for(i=0; i<53; i++) {
                week[i] = week[i+1];
                if(week[i] == null){
                    week[i] = 0;
                }
                if(i == 52) {
                    str += week[i];
                } else {
                    str= str+week[i]+",";
                }
            };
            var data_week = str.split(",");

            var ctx = $('#line-chart');
            var myChart = new Chart(ctx, {
                type: 'line',
                data:
                {
                    labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31",
                            "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53"],
                    datasets: [{
                        label: 'Number of Cases',
                        data:
                        data_week
                    ,
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        } else if (value == "by Month") {
            if (data == '') {
                console.log("value is null");
                var month = <?php echo $monthlyReports; ?>;
                var label = <?php echo $month_labels; ?>;
            } else {
                var month = data['monthlyReports'];
                var label = data['month_labels'];
            }
            // var i;
            // var str="";
            // for(i=0; i<12; i++) {
            //     month[i] = month[i+1];
            //     if(month[i] == null){
            //         month[i] = 0;
            //     }
            //     if(i == 11) {
            //         str += month[i];
            //     } else {
            //         str= str+month[i]+",";
            //     }
            // };
            // var data_month = str.split(",");

            var ctx = $('#line-chart');
            var myChart = new Chart(ctx, {
                type: 'line',
                data:
                {
                    labels: label,
                    datasets: [{
                        label: 'Number of Cases',
                        data:
                        month
                    ,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        } else if (value =="by Year") {
            if (data == '') {
                var year = <?php echo $yearlyReports; ?>;
            } else {
                var year = data['yearlyReports'];
            }
            var i;
            var str="";
            for(i={{Carbon::now()->subYear(10)->format('Y')}}; i<{{Carbon::now()->format('Y')}}; i++) {
                year[i] = year[i+1];
                if(year[i] == null){
                    year[i] = 0;
                }
                if(i == {{Carbon::now()->subYear()->year}}) {
                    str += year[i];
                } else {
                    str= str+year[i]+",";
                }
            };
            var data_year = str.split(",");

            var ctx = $('#line-chart');
            var myChart = new Chart(ctx, {
                type: 'line',
                data:
                {
                    labels: ["2012", "2013", "2014", "2015", "2016", "2017", "2018", "2019", "2020", "2021"],
                    datasets: [{
                        label: 'Number of Cases',
                        data:
                        data_year
                    ,
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.2)',
                        ],
                        borderColor: [
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }

    }

</script>

<script>
    var cases_in_states = <?php echo $cases_in_states; ?>

    function check_color (value){
        if(value > 15){
            return "#772526";
        } else if(value > 10){
            return "#BB3937";
        } else if(value > 5){
            return "#E9A188";
        } else if(value > 0){
            return "#FAEBD2";
        } else {
            return "#c8c8c8";
        }
    }

</script>

<script type="text/javascript" src="js/mapdata.js"></script>
<script  type="text/javascript" src="js/countrymap.js"></script>
@endsection
