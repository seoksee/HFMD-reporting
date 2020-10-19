@extends('layouts.admin')

@section('content')
    @if(Session::has('alert'))
        <script type="text/javascript">
            alert("{{ Session::get('alert') }}");
        </script>
    @endif

    <div class="content-wrapper">
    <div class="content-header container-fluid mb-2">

        <h1 class="m-0 text-dark">Reports</h1>
    </div>


    <table class="table" id="report-table">
        <thead>
            <th>ID</th>
            <th></th>
            {{-- <th></th> --}}
            <th>Reporter</th>
            <th>Age</th>
            <th>Relationship</th>
            <th>Symptoms</th>
            <th>Residential Area</th>
            <th>Date of Diagnosis</th>
            <th>Admission to Hospital</th>
            <th>Attending Nursery School</th>
            {{-- <th>Location of Institution</th>
            <th>Number of Infected Children in the Institution</th> --}}
            {{-- <th>Document Proof</th> --}}
            <th>Created At</th>
            <th>Status</th>
            <th>Deceased</th>
        </thead>
        <tbody>
            @if($reports)
            @foreach($reports as $report)
                <tr>
                    <td>{{$report->id}}</td>
                    <td><a href="{{route('admin.report.show', $report->id)}}"><i class="fas fa-eye"></i></a></td>
                    {{-- {!! Form::open(['method'=>'DELETE', 'action'=>['AdminReportsController@destroy', $report->id]]) !!}
                        {!! Form::button('<i class="fas fa-trash-alt" style="color:red "></i>', ['type' => 'submit']) !!}<tr>
                    {!! Form::close() !!} --}}
                    {{-- <td><form id="reportForm" class="form-horizontal">
                            <input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="report_id" id="{{$report->id}}">
                        <a href="" class="deleteReport"><i class="fas fa-trash-alt" style="color:red "></i></a>
                        </form>
                    </td> --}}

                    <td>{{$report->user->name}}</td>
                    <td>{{$report->age}}</td>
                    <td>{{ucfirst(trans($report->relationship))}}</td>
                    {{-- <td>{{$report->symptoms.",".$report->other_symptoms}}</td> --}}
                    <td>
                        @foreach(explode(',', $report->symptoms) as $symptom)
                            {{App\Symptom::find((int)$symptom)->name}},
                        @endforeach
                        @if($report->other_symptoms)
                            <strong>{{$report->other_symptoms}}</strong>
                        @endif
                    </td>
                    <td>{{App\State::find($report->residential_state_id)->name}}</td>
                    <td>{{$report->diagnosis}}</td>
                    <td>{{$report->hospital_admission==1 ? "Yes" : "No"}}</td>
                    <td>{{$report->attend_kindergarten==1 ? "Yes" : "No"}}</td>
                    {{-- <td>{{$report->kindergarten_location}}</td>
                    <td>{{$report->children_in_kindergarten_infected}}</td> --}}
                    {{-- <td>{{$report->file}}</td> --}}
                    <td>{{$report->created_at}}</td>
                    <td>
                        <input data-id="{{$report->id}}" class="status-class" type="checkbox"
                        data-onstyle="info" data-offstyle="" data-toggle="toggle" data-on="Verified" data-off="Unverified" {{ $report->is_approve ? 'checked' : '' }}>
                    </td>
                    <td>
                        <input data-id="{{$report->id}}" class="toggle-class" type="checkbox"
                        data-onstyle="danger" data-offstyle="success" data-toggle="toggle" data-on="Deceased" data-off="Alive" {{ $report->fatal ? 'checked' : '' }}>
                    </td>
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="offset-6">
        {{$reports->render()}}
    </div>
    </div>
@endsection

@section('scripts')
    <script>
    $('.status-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var report_id = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeVerify',
            data: {'is_approve': status, 'id': report_id},
            success: function(data){
              alert(data.success)
            },
        });
    });

    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var report_id = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeFatal',
            data: {'fatal': status, 'id': report_id},
            success: function(data){
              alert(data.success)
            },
        });
    });

    $('#report-table').on('click', '.deleteReport', function () {
        var report_id = $(this).data("id");
        confirm("Are You sure want to delete !");

        $.ajax({
            data: {
                _token: $("._token").val(),
                report_id: report_id,
            },
            type: "POST",
            url: "/admin/reports/deleteData",
            dataType: 'json',
            success: function (data) {
                console.log(data);
                // table.draw();
                // location.reload();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    </script>
@endsection
