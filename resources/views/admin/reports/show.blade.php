@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
    <div class="content-header container-fluid mb-2">
        <h1 class="m-0 text-dark">View Report</h1>
    </div>

            <div class="form-group row">
                <div class="col-sm-3">
                    {{-- <img src="{{$report->document ? $report->document->file : ''}}" alt="" class="img-responsive"> --}}
                </div>
                <div class="col-sm-9 row">
                    <div class="col-sm-3 text-md-right">
                        <h5><strong>Date of Birth of infected child :</strong></h5>
                    </div><div class="col-sm-6">
                        <h5>{{$report->DOB}} ({{Carbon\Carbon::parse($report->DOB)->age}} years old)</h5>
                    </div>
                    <div class="col-sm-4 text-md-right">
                        <h5><strong>Relationship with infected child :</strong></h5>
                    </div><div class="col-sm-6">
                        <h5>{{ucfirst(trans($report->relationship))}}</h5>
                    </div>
                    <div class="col-sm-4 text-md-right">
                        <h5><strong>Symptoms and Signs :</strong></h5>
                    </div><div class="col-sm-6">
                        <h5>@foreach(explode(',', $report->symptoms) as $symptom)
                            {{App\Symptom::find((int)$symptom)->name}},
                        @endforeach
                        @if($report->other_symptoms)
                            <strong>{{$report->other_symptoms}}</strong>
                        @endif</h5>
                    </div>
                    <div class="col-sm-4 text-md-right">
                        <h5><strong>Date of Diagnosis :</strong></h5>
                    </div><div class="col-sm-6">
                        <h5>{{$report->diagnosis}} ({{Carbon\Carbon::parse($report->diagnosis)->diffInDays(Carbon\Carbon::now())}} days ago)</h5>
                    </div>
                    <div class="col-sm-4 text-md-right">
                        <h5><strong>Admitted to Hospital? :</strong></h5>
                    </div><div class="col-sm-6">
                        <h5>{{$report->hospital ? "Yes" : "No"}}</h5>
                    </div>
                    <div class="col-sm-4 text-md-right">
                        <h5><strong>Residential Area :</strong></h5>
                    </div><div class="col-sm-6">
                        <h5>{{App\State::find($report->residential_state_id)->name}}</h5>
                    </div>
                    <div class="col-sm-4 text-md-right">
                        <h5><strong>Attending to nursery school or kindergarten? :</strong></h5>
                    </div><div class="col-sm-6">
                        <h5>{{$report->attend_kindergarten ? "Yes" : "No"}}</h5>
                    </div>
                    <div class="col-sm-4 text-md-right">
                        <h5><strong>Location of Institution :</strong></h5>
                    </div><div class="col-sm-6">
                        <h5>{{$report->kindergarten_state_id ? App\State::find($report->kindergarten_state_id)->name : '-'}}</h5>
                    </div>
                    <div class="col-sm-4 text-md-right">
                        <h5><strong>Any children from the institution have infected by HFMD recently? :</strong></h5>
                    </div><div class="col-sm-6">
                        <h5>{{$report->children_in_kindergarten_infected ? $report->children_in_kindergarten_infected : '-'}}</h5>
                    </div>
                    <div class="col-sm-6">
                        {!! $report->document ? "<button class='btn btn-primary float-right' id='viewFileButton'>View File</button>" : "<p class='float-right'>No document proof provided</p>" !!}
                    </div>
                    <div id="viewFileModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Document Proof</h4>
                                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{$report->document ? $report->document->file : ''}}" alt="" class="img-responsive">
                                    <embed src="{{$report->document ? $report->document->file : ''}}" type="" height="100%" width="100%" class="embed-responsive">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {{-- <div class="col-sm-10">
            {!! Form::open(['method'=>'DELETE', 'action'=>['AdminReportsController@destroy', $report->id]]) !!}
                <div class="form-group col-sm-10">
                    {!! Form::submit('Delete Report', ['class' => 'btn btn-danger float-right ']) !!}<tr>
                </div>
            {!! Form::close() !!}
            </div> --}}

    </div>

    <script>
        $('#viewFileButton').click(function(){
            $('#viewFileModal').modal();
        });
    </script>

@endsection
