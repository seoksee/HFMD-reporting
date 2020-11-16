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
    console.log(table);
    </script>
@endsection
