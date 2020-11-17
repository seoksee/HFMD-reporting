@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        {{-- <div class="content-header container-fluid mb-2">
            <h1 class="m-0 text-dark">Send Notifications to Registered Users</h1>
        </div> --}}
        <div class="container report-container bg-light p-5 " >
        <h3 class="text-center">Send Notificatins to Registered Users</h3><br><br>
        <form action="{{route('admin.notifications.store')}}" class="user" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">

                <label for="users" class="col-md-5 col-form-label text-md-right">{{ __('Send to') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6 ">

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
            <div class="form-group row">
                <label for="date" class="col-md-5 col-form-label text-md-right">{{ __('When to send') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <input type="dateTime-local" id="date" class="form-control" name="date" value="{{ old('date') }}" required autofocus>
                </div>
            </div>
            {{-- <div class="form-group row">
                <label for="title" class="col-md-5 col-form-label text-md-right">{{ __('Title') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <input type="text" id="title" class="form-control" name="title" value="{{ old('title') }}" autofocus placeholder="Enter title">
                </div>
            </div> --}}
            <div class="form-group row">
                <label for="message" class="col-md-5 col-form-label text-md-right">{{ __('Message') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <textarea name="message" class="form-control" rows="3" required placeholder="Type your message here"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <button type="submit" class="btn btn-success btn-user float-right">
                    {{ __('Submit') }}
                </button><br>
                </div>
            </div>

        </form>
        </div>

    </div>
@endsection
