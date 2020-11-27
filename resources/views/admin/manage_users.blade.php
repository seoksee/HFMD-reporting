@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header container-fluid mb-2">
            <h1 class="m-0 text-dark">Manage Users</h1>
        </div>

        <table class="table" id="data-table">
            <thead>
                <th>ID</th>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Email Address</th>
                <th>Created At</th>
                <th>Role</th>
            </thead>
            <tbody>
                {{-- @if($users)
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->created_at}}</td>
                        <td>
                            <input data-id="{{$user->id}}" class="role-class" type="checkbox" data-onstyle="info" data-offstyle=""
                            data-toggle="toggle" data-on="Admin" data-off="Public" {{ $user->role_id==1 ? 'checked' : '' }}>
                        </td>
                    </tr>
                @endforeach
                @endif --}}
            </tbody>
        </table>

        {{-- <div class="offset-6">
            {{$users->render()}}
        </div> --}}

    </div>

@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>

    <script>

        var table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        // ajax: "{{ route('admin.notifications.index') }}",
        ajax: {
            url: "/admin/manageUsers/getTableData",
            dataType: "json",
            type: "POST",
            data: {
                _token: "{{csrf_token()}}",
                // _token: $("._token").val(),
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'created_at',
                render: function(data, type, row) {
                    var time_to_string = new Date(Date.parse(data)).toLocaleString()
                    return '<span>'+ time_to_string +'</span>';
            }},
            {data: 'role_id',
                render: function(data, type, row) {
                    if(data == 1 ) {
                        return '<input data-id=' + row.id + ' class="role-class" type="checkbox" data-onstyle="info" data-on="Admin" data-off="Public"'  + ' checked>';
                    }
                    return '<input data-id=' + row.id + ' class="role-class" type="checkbox" data-onstyle="info" data-on="Admin" data-off="Public"'  + '>';
                }
            }
        ],
        rowCallback: function ( row, data ) {
        $('input.role-class', row).prop( 'data-toggle="toggle" checked', data.role_id == 1 ).bootstrapToggle({width: "100px"});
        }
    });
    </script>
    <script>
        $('#data-table').on('change', '.role-class', function (event, state) {
        var status = $(this).prop('checked') == true ? 1 : 2;
        var user_id = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeRole',
            data: {'role_id': status, 'id': user_id},
            success: function(data){
            //   alert(data.success)
            swal({
                    icon: 'success',
                    title: 'Role changed successfully!\n',
                    button: false,
                    timer: 1500
                });
            },
        });
    });
    </script>
@endsection

