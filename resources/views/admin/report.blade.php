@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
    <div class="content-header container-fluid mb-2">
        
        <h1 class="m-0 text-dark">Reports</h1>
    </div>


    <table class="table">
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
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    </div>
@endsection
