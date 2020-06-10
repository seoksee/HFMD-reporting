@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header container-fluid mb-2">
            <h1 class="m-0 text-dark">Edit Symptoms</h1>
        </div>

        {!! Form::model($symptom, ['method'=>'PATCH', 'action'=>['AdminSymptomsController@update', $symptom->id]]) !!}
        <div class="form-group row">

        </div>
    </div>
@endsection
