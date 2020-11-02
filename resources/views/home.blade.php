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
            <div class="col-xl-3 col-md-6 mb-5">
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
            <div class="col-xl-3 col-md-6 mb-5">
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
          <div class="col-xl-3 col-md-6 mb-5">
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

        <div class="">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">This month HFMD Cases Overview</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body row">
                  <div class="col-md-10">
                    {{-- <canvas id="myAreaChart"></canvas> --}}
                    <canvas id="line-chart"></canvas>
                  </div>
                  <div class="col-md-2">
                    <button class="btn btn-outline-primary dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          by Month
                    </button>
                        <div class="dropdown-menu dropdown-menu-right animated--fade-in" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="#">by Day</a>
                          <a class="dropdown-item" href="#">by Week</a>
                          <a class="dropdown-item" href="#">by Month</a>
                          <a class="dropdown-item" href="#">by Year</a>

                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="card shadow mb-5">
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
var month = <?php echo $monthlyReports; ?>;
var i;
var str="";
for(i=0; i<12; i++){
    month[i]=month[i+1];
    if(month[i]==null){
        month[i]=0;
    }
    if(i==11){
        str += month[i];
    }else{
        str= str+month[i]+",";
    }
};
var data_month = str.split(",");
var lineChartData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
        label: 'number of cases',
        backgroundColor:  [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
        data: data_month
    }]
};
// console.log(month);
// console.log(data_month);
// console.log(lineChartData);
var ctx = $('#line-chart');
    var myChart = new Chart(ctx, {
        type: 'line',
        data:
        // lineChartData,
        {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: 'Number of Cases',
                data:
                data_month
                // 1,2,3,4,5,6,7,8,9,1,2
            ,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
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
</script>

<script>
    var cases_in_states = <?php echo $cases_in_states; ?>;
    var cases_object = {

    };

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
    console.log(cases_object);
</script>

<script type="text/javascript" src="js/mapdata.js"></script>
<script  type="text/javascript" src="js/countrymap.js"></script>
@endsection
