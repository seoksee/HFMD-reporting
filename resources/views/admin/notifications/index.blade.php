@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header container-fluid mb-2">
            <h1 class="m-0 text-dark">Notifications</h1>
        </div>

        {{-- <a class="btn btn-success float-right" style="margin:0.5%" href="{{route('admin.notifications.create')}}" id="createNewSymptom"> Create New Notification</a> --}}
        <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewNotification"> Create New Notification</a>
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recipients</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- <tr>
                    <td>1</td>
                    <td><a href="#">New Confirmed Case at Petaling Jaya</a></td>
                    <td>Tan Seok See</td>
                    <td>2020-06-09</td>
                    <td>2020-06-09 12:00</td>
                    <td class="badge badge-pill bg-primary">Posted</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><a href="#">New Confirmed Case at Pantai Dalam</a></td>
                    <td>Tan Seok See</td>
                    <td>2020-06-08</td>
                    <td>2020-06-08 12:00</td>
                    <td class="badge badge-pill bg-primary">Posted</td>
                </tr>
                 <tr>
                    <td>3</td>
                    <td><a href="#">Precaution Acts to Prevent HFMD</a></td>
                    <td>Tan Seok See</td>
                    <td>2020-06-07</td>
                    <td>2020-06-10 12:00</td>
                    <td class="badge badge-pill bg-danger">Scheduled</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td><a href="#">Detected Outbreak at Kuching</a></td>
                    <td>Tan Seok See</td>
                    <td>2020-06-06</td>
                    <td>2020-06-06 12:00</td>
                    <td class="badge badge-pill bg-primary">Posted</td>
                </tr> --}}
            </tbody>
        </table>

        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalHeading"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="notificationForm" class="form-horizontal">
                        <input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="notification_id" id="notification_id">
                        <div class="form-group">
                            <label for="users" class="col-sm-5 col-form-label">{{ __('Send to') }}</label>

                            <div class="col-sm-12 ">

                                <select name="users" id="" class="custom-select" >
                                    <option value="all">All Users</option>
                                    <option value="selangor">Users in Selangor</option>
                                    <option value="johor">Users in Johor</option>
                                    <option value="penang">Users in Penang</option>
                                    <option value="perak">Users in Perak</option>
                                    <option value="sarawak">Users in Sarawak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date" class="col-sm-5 control-label">When to send</label>
                            <div class="col-sm-12">
                                <input type="datetime-local" class="form-control" name="date" id="date" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="col-sm-5 control-label">Message</label>
                            <div class="col-sm-12">
                                <textarea name="message" id="message" class="form-control" rows="3" placeholder="Type your message here" required></textarea>
                            </div>
                        </div>

                        <div class="col-sm-offset-2">
                            <button type="submit" class="btn btn-primary float-right" id="saveBtn" value="create">Save Changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        // ajax: "{{ route('admin.notifications.index') }}",
        ajax: {
            url: "/admin/notifications/getTableData",
            dataType: "json",
            type: "POST",
            data: {
                _token: "{{csrf_token()}}",
                // _token: $("._token").val(),
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'recipients', name: 'recipients'},
            {data: 'content', name: 'content'},
            {data: 'when_to_send',
            render: function(data, type, row) {
                if(data > "{{Carbon\Carbon::now()}}") {
                    return '<span class="badge badge-pill bg-danger">Scheduled</span>';

                } else {
                    return '<span class="badge badge-pill bg-primary">Posted</span>';
                }
            }},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    // console.log(table);

    $('#createNewNotification').click(function() {
        $('#saveBtn').val("create-notification");
        $('#notification_id').val('');
        $('#notificationForm').trigger("reset");
        $('#modalHeading').html("Create New Notification");
        $('#ajaxModel').modal('show');
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending...');

        $.ajax({
            data: $('#notificationForm').serialize(),
            url: "{{route('admin.notifications.store')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                $('#notificationForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                $('#saveBtn').html('Save Changes');
                table.draw();
            },
            error: function (data) {
                console.log("Error:" , data);
                $('#saveBtn').html('Save Changes');
            }
        });
    });

    </script>
@endsection
