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


    <table class="table" id="report-table" data-order='[[0, "desc"]]'>
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
            <th>Attending School</th>
            {{-- <th>Location of Institution</th>
            <th>Number of Infected Children in the Institution</th> --}}
            {{-- <th>Document Proof</th> --}}
            <th>Created At</th>
            <th>Status</th>
            <th>Deceased</th>
        </thead>
        <tbody>
            {{-- start of 1/4
                @if($reports)
            @foreach($reports as $report)
                <tr>
                    <td>{{$report->id}}</td>
                    <td><a href="/admin/reports/show/{{$report->id}}"><i class="fas fa-eye"></i></a></td>
        end of 1/4
                    --}}

                    {{-- {!! Form::open(['method'=>'DELETE', 'action'=>['AdminReportsController@destroy', $report->id]]) !!}
                        {!! Form::button('<i class="fas fa-trash-alt" style="color:red "></i>', ['type' => 'submit']) !!}<tr>
                    {!! Form::close() !!} --}}
                    {{-- <td><form id="reportForm" class="form-horizontal">
                            <input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="report_id" id="{{$report->id}}">
                        <a href="" class="deleteReport"><i class="fas fa-trash-alt" style="color:red "></i></a>
                        </form>
                    </td> --}}

        {{-- start of 2/4
                        <td>{{$report->user->name}}</td>
                    <td>{{$report->age}}</td>
                    <td>{{ucfirst(trans($report->relationship))}}</td>
        end of 2/4 --}}

                    {{-- <td>{{$report->symptoms.",".$report->other_symptoms}}</td> --}}

        {{-- start of 3/4
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
        end of 3/4 --}}

                    {{-- <td>{{$report->kindergarten_location}}</td>
                    <td>{{$report->children_in_kindergarten_infected}}</td> --}}
                    {{-- <td>{{$report->file}}</td> --}}

        {{-- start of 4/4
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
        end of 4/4--}}

        </tbody>
    </table>
    {{-- <div class="offset-6">
        {{$reports->render()}}
    </div> --}}
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
    <script>
        var table = $('#report-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/admin/reports/getTableData",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    // _token: $("._token").val(),
                }
            },
            pageLength: 6,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'id',
                    render: function(data, type, row) {
                        return '<a href="/admin/reports/show/' + row.id + '"><i class="fas fa-eye">';
                    }, orderable: false, searchable: false
                },
                {data: 'user', name: 'user'},
                {data: 'age', name: 'age'},
                {data: 'relationship',
                    render: function(data) {
                        return data.charAt(0).toUpperCase() + data.substring(1);
                    }
                },
                {data: 'symptoms', name: 'symptoms'},
                {data: 'resident', name: 'resident'},
                {data: 'diagnosis',
                    render: function(data) {
                        if(data == null)
                            return '-';
                        return data;
                    }
                },
                {data: 'hospital_admission',
                    render: function(data) {
                        if(data == 1)
                            return 'Yes';
                        return 'No';
                    }
                },
                {data: 'attend_kindergarten',
                    render: function(data) {
                        if(data == 1)
                            return 'Yes';
                        return 'No';
                    }
                },
                {data: 'created_at',
                    render: function(data, type, row) {
                        var time_to_string = new Date(Date.parse(data)).toLocaleString()
                        return '<span>'+ time_to_string +'</span>';
                }},
                {data: 'is_approve',
                    render: function(data, type, row) {
                        if(data == 1 ) {
                            return '<input data-id=' + row.id + ' class="status-class" type="checkbox" data-onstyle="info" data-on="Verified" data-off="Unverified"'  + ' checked>';
                        }
                        return '<input data-id=' + row.id + ' class="status-class" type="checkbox" data-onstyle="info" data-on="Verified" data-off="Unverified"'  + '>';
                    }
                },
                {data: 'fatal',
                    render: function(data, type, row) {
                        if(data == 1 ) {
                            return '<input data-id=' + row.id + ' class="deceased-class" type="checkbox" data-onstyle="danger" data-offstyle="success" data-on="Deceased" data-off="Alive"'  + ' checked>';
                        }
                        return '<input data-id=' + row.id + ' class="deceased-class" type="checkbox" data-onstyle="danger" data-offstyle="success" data-on="Deceased" data-off="Alive"'  + '>';
                    }
                }
            ],
            rowCallback: function ( row, data ) {
            $('input.status-class', row).prop( 'data-toggle="toggle" checked', data.role_id == 1 ).bootstrapToggle({width: "120px"});
            $('input.deceased-class', row).prop( 'data-toggle="toggle" checked', data.role_id == 1 ).bootstrapToggle({width: "100px"});
            }
        });

    $('#report-table').on('change', '.status-class', function (event, state) {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var report_id = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeVerify',
            data: {'is_approve': status, 'id': report_id},
            success: function(data){
            //   alert(data.success)
            swal({
                    icon: 'success',
                    title: 'Status changed successfully!\n',
                    button: false,
                    timer: 1500
                });
            },
        });
    });

    $('#report-table').on('change', '.deceased-class', function (event, state) {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var report_id = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeFatal',
            data: {'fatal': status, 'id': report_id},
            success: function(data){
            //   alert(data.success)
            swal({
                    icon: 'success',
                    title: 'Fatality changed successfully!\n',
                    button: false,
                    timer: 1500
                });
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
