@extends('layouts.admin')

@section('content')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> --}}
    {{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
    <div class="content-wrapper">
        <div class="content-header container-fluid mb-2">
            <h1 class="m-0 text-dark">Symptoms</h1>
        </div>

        {{-- <a class="btn btn-info float-right" href="{{route('admin.symptoms.create')}}">Create new Symptom</a><br> --}}
        <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewSymptom"> Create New Symptom</a>
        <table class="table" id="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name of Symptoms</th>
                    <th>Action</th>
                    <th>Hide Status</th>
                </tr>
            </thead>
            <tbody>
                {{-- @if($symptoms)
                    @foreach($symptoms as $symptom)
                        <tr>
                            <td>{{$symptom->id}}</td>
                            <td>{{$symptom->name}}</td>
                            <td>
                                <a id="edit-button">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                            <td>
                                <i class="fas fa-trash-alt"></i>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <p>No Symptoms currently.</p>
                @endif --}}
            </tbody>
        </table>

        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="symptomForm" class="form-horizontal">
                            <input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="symptom_id" id="symptom_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required>
                                </div>
                            </div>

                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
<script>
    var table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/admin/symptoms/getTableData",
            dataType: "json",
            type: "POST",
            data: {
                _token: $("._token").val(),
            },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'hide',
                render: function(data, type, row) {
                    if(data == 1 ) {
                        return '<input data-id=' + row.id + ' class="hide-class" type="checkbox" data-onstyle="danger" data-offstyle="success" data-on="Hide" data-off="Show"'  + ' checked>';
                    }
                    return '<input data-id=' + row.id + ' class="hide-class" type="checkbox" data-onstyle="danger" data-offstyle="success" data-on="Hide" data-off="Show"'  + '>';
                }
            }
        ],
        rowCallback: function ( row, data ) {
        $('input.hide-class', row).prop( 'data-toggle="toggle" checked', data.role_id == 1 ).bootstrapToggle({width: "100px"});
        }
    });

    // console.log(table);

    $('#createNewSymptom').click(function () {
        $('#saveBtn').val("create-symptom");
        $('#symptom_id').val('');
        $('#symptomForm').trigger("reset");
        $('#modelHeading').html("Create New Symptom");
        $('#ajaxModel').modal('show');
    });

    $('#data-table').on('click', '.editSymptom', function () {
        var symptom_id = $(this).data('id');
        $.ajax({
            data: {
                _token: $("._token").val(),
                symptom_id: symptom_id,
            },
            url: "/admin/symptoms/editData",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#modelHeading').html("Edit Symptom");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#symptom_id').val(data.name.id);
                $('#name').val(data.name.name);
            console.log(data);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        console.log(e);
        $(this).html('Sending..');

        $.ajax({
            data: $('#symptomForm').serialize(),
            url: "{{ route('admin.symptoms.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#symptomForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                $('#saveBtn').html('Save Changes');
                swal({
                    icon: 'success',
                    title: 'Symptom saved successfully!\n',
                    button: false,
                    timer: 1500
                });
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
                var error_msg = '';
                if(data.responseJSON.name) {
                    error_msg += data.responseJSON.name[0];
                }
                swal({
                    icon: 'error',
                    title: 'Invalid input!',
                    position: 'top',
                    text: error_msg,
                });
                $('#saveBtn').html('Save Changes');
            }
        });
    });

    $('#data-table').on('click', '.deleteSymptom', function () {
        var symptom_id = $(this).data("id");
        // var confirmation = confirm("Are You sure want to delete !");
        // if(confirmation == false) {
        //     return false;
        // }

        swal({
            title: "Are you sure to delete?",
            icon: "warning",
            buttons: [true, "Yes, delete it!"],
            closeOnConfirm: false,
            closeOnCancel: false
            })
            .then((isConfirm) => {
            if (isConfirm) {
                $.ajax({
                    data: {
                        _token: $("._token").val(),
                        symptom_id: symptom_id,
                    },
                    type: "POST",
                    url: "/admin/symptoms/deleteData",
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        swal("Deleted!", "Your symptom has been deleted.", "success");
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        swal("Failed!", "Failed to delete symptom.", "error");
                    }
                });
            } else {
                swal("Did nothing :)", "Your symptom is safe", "info");
            }
            });
    });

    $('#data-table').on('change', '.hide-class', function (event, state) {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var symptom_id = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/hideSymptom',
            data: {'hide': status, 'id': symptom_id},
            success: function(data){
                if(data.success) {
                    swal({
                    icon: 'success',
                    title: 'Hide status changed successfully!\n',
                    button: false,
                    timer: 1500
                    });
                } else {
                }
            },
            error: function(data) {

            }
        });
    });

</script>
@endsection
