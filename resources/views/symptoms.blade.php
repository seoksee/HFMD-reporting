@extends('layouts.user_home')

@section('content')
    @if(Session::has('alert'))
        <script type="text/javascript">
            alert("{{ Session::get('alert') }}");
        </script>
    @endif

    <div class="container container-fluid p-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h3 class="m-0 font-weight-bold text-primary">Occurence of Symptoms</h3>
                <div class="">
                    {{-- <label><strong>Select Year :</strong></label><br/> --}}
                    <select id="year" name="year" class="custom-select animated--fade-in dynamic">
                        <option value="">All Year</option>
                        @for($i = Carbon::now(); $i > Carbon::now()->subYear(5); $i= $i->subYear())
                            <option value="{{$i->year}}">{{$i->year}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div style="overflow-x: scroll">
                    <div class="chart-container" style="position: relative;  width:900px;">
                    {{-- <canvas id="myAreaChart"></canvas> --}}
                        <canvas id="symptomsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script>
    $(document).ready(function() {
        // $('#year').multiselect({
        //     nonSelectedText: 'Select Year',
        //     enableFiltering: true,
        //     enableCaseInsensitiveFiltering: true,
        //     buttonWidth:'400px'
        // });
        var symptomsName = <?php echo json_encode($symptomsName); ?>;
        var symptomsCount = <?php echo json_encode($symptomsCount); ?>;
        display_chart(symptomsName, symptomsCount);
    });

    $('.dynamic').change(function(){
        console.log("change detected");
        if($(this).text() != '') {
            // var select = "state_id";
            var value = $(this).val();
            console.log("value: " + value);
            // var dependent = $(this).data('dependent');
            var _token = "{{csrf_token()}}";
            $.ajax({
                url: "/symptoms-chart/fetch",
                method: "POST",
                data: {
                    value: value,
                    _token: _token,
                },
                success: function(result){
                    display_chart(result.symptomsName, result.symptomsCount);
                }
            })
        }
    });



    function display_chart(symptomsName, symptomsCount) {
        var ctx = document.getElementById('symptomsChart').getContext('2d');
    var randomColourPlugin = {

        beforeUpdate: function(chart){
            var backgroundColor = [];
            var borderColor = [];
            for(var i=0; i<symptomsCount.length; i++){
                var colour = "rgba(" + Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 255) + ",";
                backgroundColor.push(colour + "0.2)");
                borderColor.push(colour + "1)");
            }

            chart.config.data.datasets[0].backgroundColor = backgroundColor;
            chart.config.data.datasets[0].borderColor = borderColor;
        }

    }

    Chart.pluginService.register(randomColourPlugin);

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: symptomsName,
            // labels: ['Fever', 'Sore Throat', 'Poor Appetite', 'Malaise', 'Red spots on Mouth', 'Red spots on Hand/Wrist', 'Red spots on Feet'],
            datasets: [{
                label: 'Occurence of symptoms',
                // data: [10, 2, 1, 3, 9, 10, 8],
                data: symptomsCount,
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
    }

    </script>
@endsection
