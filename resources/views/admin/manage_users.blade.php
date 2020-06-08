@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header container-fluid mb-2">
            <h1 class="m-0 text-dark">Manage Users</h1>
        </div>

        <table class="table">
            <thead>
                <th>ID</th>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Email Address</th>
                <th>Created At</th>
                <th>Role</th>
            </thead>
            <tbody>
                @if($users)
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
                @endif
            </tbody>
        </table>

        <div class="offset-6">
            {{$users->render()}}
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        $('.role-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 2;
        var user_id = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeRole',
            data: {'role_id': status, 'id': user_id},
            success: function(data){
              alert(data.success)
            },
        });
    });
    </script>
@endsection

