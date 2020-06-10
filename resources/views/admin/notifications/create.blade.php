@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        {{-- <div class="content-header container-fluid mb-2">
            <h1 class="m-0 text-dark">Send Notifications to Registered Users</h1>
        </div> --}}
        <div class="container report-container bg-light p-5 " >
        <h3 class="text-center">Send Notificatins to Registered Users</h3><br><br>
        <form action="/report" class="user" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">

                <label for="relationship" class="col-md-5 col-form-label text-md-right">{{ __('Send to') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6 ">

                    <select name="relationship" id="" class="custom-select" >
                        <option value="parent">All Users</option>
                        <option value="guardian">Users in Selangor</option>
                        <option value="guardian_dependent">Users in Johor</option>
                        <option value="teacher">Users in Penang</option>
                        <option value="siblings">Users in Perak</option>
                        <option value="relatives">Users in Sarawak</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="DOB" class="col-md-5 col-form-label text-md-right">{{ __('When to send') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <input type="date" id="DOB" class="form-control" name="DOB" value="{{ old('DOB') }}" required autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="school" class="col-md-5 col-form-label text-md-right">{{ __('Title') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <input type="text" id="school" class="form-control" name="kindergarten_location" value="{{ old('school') }}" autofocus placeholder="Enter title">
                </div>
            </div>
            <div class="form-group row">
                <label for="message" class="col-md-5 col-form-label text-md-right">{{ __('Message') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <textarea class="form-control" rows="3" placeholder="Type your message here"></textarea>
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
