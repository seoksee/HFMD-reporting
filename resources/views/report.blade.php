@extends('layouts.user_home')

@section('content')
    <div class="container report-container p-5">
        <h3 class="text-center"><strong>Hand Foot Mouth Disease Reporting</strong></h3>
        <form action="/report" class="user" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="DOB" class="col-md-5 col-form-label text-md-right">{{ __('Date of birth of infected child') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <input type="date" id="DOB" class="form-control" name="DOB" value="{{ old('DOB') }}" required autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="relationship" class="col-md-5 col-form-label text-md-right">{{ __('Relationship with infected child') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6 ">

                    <select name="relationship" id="" class="custom-select" required >
                        <option value="parent">Parent</option>
                        <option value="guardian">Guardian</option>
                        <option value="guardian_dependent">Guardian dependent</option>
                        <option value="teacher">Teacher/Institution worker</option>
                        <option value="siblings">Siblings</option>
                        <option value="relatives">Relatives</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <p class="col-md-5 col-form-label text-md-right">{{ __('Symptoms and Signs') }}<p>
                <span class="col-form-label"><strong>:</strong></spatext-md-rightn>
                <div class="col-md-6 col-form-label">
                    @foreach ($symptoms as $symptom)
                        <input type="checkbox" class="custom-checkbox" name="symptoms[]" value="{{$symptom->id}}" >
                        {{ $symptom->name }} <br>
                    @endforeach
                    <input type="checkbox" class="custom-checkbox" 
                    onclick="var input = $('#other'); if(this.checked){ input.removeAttr('disabled'); input.focus();}else{input.attr('disabled','disabled');}" />
                    <label for="other">Other: </label>
                    <input id="other" name="other_symptoms" type="text" class="col-md-6 " disabled="disabled"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="diagnosis" class="col-md-5 col-form-label text-md-right">{{ __('Date of diagnosis') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <input type="date" id="diagnosis" class="form-control" name="diagnosis" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="hospital" class="col-md-5 col-form-label text-md-right">{{ __('Admitted to hospital?') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="hospital_admission" value="1" autofocus required/>
                    <label for="hospitalY" class="form-check-label">Yes</label>
                </div>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="hospital_admission" value="0" autofocus/>
                    <label for="hospitalN" class="form-check-label">No</label>
                </div>
            </div>
            <div class="form-group row">
                <label for="resident" class="col-md-5 col-form-label text-md-right">{{ __('Residential Area') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <select name="residential_state_id" id="residential_state" class="custom-select" required >
                        @foreach($states as $state)
                            <option value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                    {{-- <select name="residential_district_id" id="residential_district" class="custom-select" required >
                            <option value="">--Select District--</option>
                            @foreach($districts as $district)
                            @if($district->state_id==)
                                <option value="{{$district->id}}">{{$district->name}}</option>
                            @endif
                            @endforeach
                        </select> --}}
                </div>
                {{-- <div class="form-group row">
                    <div class="col-md-5"></div>
                    <div class="col-md-6">

                    </div>
                </div> --}}

            </div>
            <div class="form-group row">
                <label for="kindergarten" class="col-md-5 col-form-label text-md-right">{{ __('Attending to nursery school or kindergarten?') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" id="kindergartenY" class="form-check-input" name="attend_kindergarten" value="1" autofocus required
                onclick="var input = $('.institution'); if(this.checked){input.show('slow');}">
                    <label for="kindergartenY" class="form-check-label">Yes</label>
                </div>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" id="kindergartenN" class="form-check-input" name="attend_kindergarten" value="0" autofocus
                    onclick="var input = $('.institution'); if(this.checked){input.hide('slow');}">
                    <label for="kindergartenN" class="form-check-label">No</label>
                </div>
            </div>
            <div class="form-group row institution">
                <label for="school" class="col-md-5 col-form-label text-md-right">{{ __('Location of Institution') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <select name="kindergarten_state_id" id="kindergarten_state" class="custom-select" required >
                        @foreach($states as $state)
                            <option value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                    {{-- <input type="text" id="school" class="form-control" name="kindergarten_location" value="{{ old('school') }}" autofocus placeholder="District name, State"> --}}
                </div>
            </div>
            <div class="form-group row institution">
                <div class="col-md-5 col-form-label text-md-right">{{ __('Any children from the institution have infected by HFMD recently?') }}</div>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" id="other-infect-y" class="form-check-input" name="children_infected" value="1"
                    onchange="var input = $('#infected');
                                if($('#other-infected-y').prop('checked',true)){
                                    input.removeAttr('disabled', 'disabled');
                                    input.focus();}" />

                    <label for="other-infect-y" class="form-check-label">Yes</label> &nbsp;
                    <input id="infected" name="children_in_kindergarten_infected" class="col-md-6 " disabled="true" placeholder="How many?"/>
                </div>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" id="other-infect-n" class="form-check-input" name="children_infected" value="0" autofocus
                    onclick="var input = $('#infected');
                            input.attr('disabled','disabled');"
                            >
                    <label for="other-infect-n" class="form-check-label">No</label>
                </div>
            </div>
            <div class="form-group row">
                <label for="document" class="col-md-5 col-form-label text-md-right">{{ __('Document proof') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <input type="file" class="form-control-file" name="document_id" autofocus >
                </div>
            </div>
            <button type="submit" id="checkBtn" class="btn btn-primary btn-user btn-block">
                    {{ __('Submit') }}
                </button><br>
        </form>
        <div class="container">
            <img src="https://i1.wp.com/images.clipartpanda.com/reception-clipart-cropped-preschool-clipart23.png" height="130rem" alt="">
            <img src="https://i1.wp.com/images.clipartpanda.com/reception-clipart-cropped-preschool-clipart23.png" height="130rem" alt="">
        </div>

    </div>

    <script>
        $(".institution").hide();
        $("#other-infected-y").change(function(event){
            X = event.target.value;
            if(X==0){
                $("#infected").attr("disabled","disabled");
            } else{
                $("#infected").removeAttr("disabled","disabled");
            }
        });
        $(document).ready(function () {
            $('#checkBtn').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if(!checked) {
                    alert("You must check at least one symptoms and signs.");
                return false;
                }
            });
        });
    </script>
@endsection
