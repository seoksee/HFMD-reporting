@extends('layouts.admin')

@section('content')

    <div class="content-wrapper">
    <div class="content-header container-fluid mb-2">

        <h1 class="m-0 text-dark">Reports</h1>
    </div>


    <table class="table" id="report-table">
        <thead>
            <th>ID</th>
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
            <th>Document Proof</th>
            <th>Created At</th>
            <th>Status</th>
            <th>Deceased</th>
        </thead>
        <tbody>
            @if($reports)
            @foreach($reports as $report)
                <tr>
                    <td>{{$report->id}}</td>
                    <td>{{$report->user->name}}</td>
                    <td>{{Carbon\Carbon::parse($report->DOB)->age}}</td>
                    <td>{{$report->relationship}}</td>
                    <td>{{$report->symptoms.",".$report->other_symptoms}}</td>
                    <td>{{$report->residential}}</td>
                    <td>{{$report->diagnosis}}</td>
                    <td>{{$report->hospital_admission==1 ? "Yes" : "No"}}</td>
                    <td>{{$report->attend_kindergarten==1 ? "Yes" : "No"}}</td>
                    {{-- <td>{{$report->kindergarten_location}}</td>
                    <td>{{$report->children_in_kindergarten_infected}}</td> --}}
                    <td>{{$report->file}}</td>
                    <td>{{$report->created_at}}</td>
                    <td>
                        @if($report->is_approve == 1)
                            Verified
                            {!! Form::open(['method'=>'PATCH', 'action'=>['AdminReportsController@update', $report->id]]) !!}
                                <input type="hidden" name="is_approve" value="0">
                                <div class="">
                                    {!! Form::submit('Unverify', ['class'=>'btn btn-block btn-outline-info']) !!}
                                </div>
                            {!! Form::close() !!}
                        @else
                            Not verified
                            {!! Form::open(['method'=>'PATCH', 'action'=>['AdminReportsController@update', $report->id]]) !!}
                                <input type="hidden" name="is_approve" value="1">
                                <div class="">
                                    {!! Form::submit('Verify', ['class'=>'btn btn-block btn-outline-warning']) !!}
                                </div>
                            {!! Form::close() !!}
                        @endif
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
    </div>
@endsection

@section('scripts')
    <script>

    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var report_id = $(this).data('id');
        console.log(report_id);
        console.log("fdsaf");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeFatal',
            data: {'fatal': status, 'id': report_id},
            success: function(data){
              console.log(data.success)
            },
        });
    })

    </script>
@endsection
