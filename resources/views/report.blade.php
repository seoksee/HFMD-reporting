@extends('layouts.user_home')

@section('content')
    <div class="container report-container p-5">
        <h3 class="text-center"><strong>Hand Foot Mouth Disease Reporting</strong></h3>
        <form action="ReportController@store" class="user" method="POST">
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

                    <select name="relationship" id="" class="custom-select" >
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
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-3 col-form-label">
                    <input type="checkbox" id="fever" class="custom-checkbox" name="fever" value="fever">
                    <label for="fever">Fever</label><br>
                    <input type="checkbox" id="sore-throat" class="custom-checkbox" name="sore-throat" value="sore-throat">
                    <label for="sore-throat">Sore Throat</label><br>
                    <input type="checkbox" id="appetite" class="custom-checkbox" name="appetite" value="appetite">
                    <label for="appetite">Poor Appetite</label><br>
                    <input type="checkbox" id="malaise" class="custom-checkbox" name="malaise" value="malaise">
                    <label for="malaise">Malaise</label><br>
                </div>
                <div class="col-md-3 col-form-label">
                    <input type="checkbox" id="spot-mouth" class="custom-checkbox" name="spot-mouth" value="spot-mouth">
                    <label for="spot-mouth">Red spots on Mouth</label><br>
                    <input type="checkbox" id="spot-hand" class="custom-checkbox" name="spot-hand" value="spot-hand">
                    <label for="spot-hand">Red spots on Hand/Wrist</label><br>
                    <input type="checkbox" id="spot-feet" class="custom-checkbox" name="spot-feet" value="spot-feet">
                    <label for="spot-feet">Red spots on Feet</label><br>
                    {{-- <input type="checkbox" class="custom-checkbox" name="other" value="other">
                    <label for="fever">Other: </label>
                    <input type="text" class="form-control"> --}}

                        <input type="checkbox" class="custom-checkbox"
                        onclick="var input = $('#other'); if(this.checked){ input.removeAttr('disabled'); input.focus();}else{input.attr('disabled','disabled');}" />
                        <label for="other">Other: </label>
                        <input id="other" name="other" class="col-md-6 " disabled="disabled"/>
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
                    <input type="radio" class="form-check-input" name="hospital" value="{{ old('yes') }}" autofocus/>
                    <label for="hospitalY" class="form-check-label">Yes</label>
                </div>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="hospital" value="{{ old('no') }}" autofocus/>
                    <label for="hospitalN" class="form-check-label">No</label>
                </div>
            </div>
            <div class="form-group row">
                <label for="resident" class="col-md-5 col-form-label text-md-right">{{ __('Residential Area') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <input type="text" id="resident" class="form-control" name="resident" value="{{ old('resident') }}" autofocus required placeholder="District name, State">
                </div>
            </div>
            <div class="form-group row">
                <label for="kindergarten" class="col-md-5 col-form-label text-md-right">{{ __('Attending to nursery school or kindergarten?') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" id="kindergartenY" class="form-check-input" name="kindergarten" value="{{ old('yes') }}" autofocus
                onclick="var input = $('#institution'); if(this.checked){input.show('slow');}">
                    <label for="kindergartenY" class="form-check-label">Yes</label>
                </div>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" id="kindergartenN" class="form-check-input" name="kindergarten" value="{{ old('no') }}" autofocus
                    onclick="var input = $('#institution'); if(this.checked){input.hide('slow');}">
                    <label for="kindergartenN" class="form-check-label">No</label>
                </div>
            </div>
            <div class="form-group row" id="institution">
                <label for="school" class="col-md-5 col-form-label text-md-right">{{ __('Location of Institution') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <input type="text" id="school" class="form-control" name="school" value="{{ old('school') }}" autofocus required placeholder="District name, State">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-5 col-form-label text-md-right">{{ __('Any children from the institution have infected by HFMD recently?') }}</div>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" id="other-infect-y" class="form-check-input" name="other-infect"  autofocus
                    onclick="var input = $('#infected'); if($(this).prop('checked',true)){ input.removeAttr('disabled'); input.focus();}else if($(this).prop('checked',false)){input.attr('disabled','disabled');}" />

                    <label for="other-infect-y" class="form-check-label">Yes</label> &nbsp;
                    <input id="infected" name="other-infect" class="col-md-6 " disabled="disabled" placeholder="How many?"/>
                </div>
                <div class="col-md-3 form-check form-check-inline">
                    <input type="radio" id="other-infect-n" class="form-check-input" name="other-infect" value="{{ old('0') }}" autofocus>
                    <label for="other-infect-n" class="form-check-label">No</label>
                </div>
            </div>
            <div class="form-group row">
                <label for="document" class="col-md-5 col-form-label text-md-right">{{ __('Document proof') }}</label>
                <span class="col-form-label"><strong>:</strong></span>
                <div class="col-md-6">
                    <input type="file" class="form-control-file" name="document" value="{{ old('document') }}" autofocus >
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{ __('Submit') }}
                </button><br>
        </form>
        <div class="container">
            <img src="https://i1.wp.com/images.clipartpanda.com/reception-clipart-cropped-preschool-clipart23.png" height="130rem" alt="">
            <img src="https://i1.wp.com/images.clipartpanda.com/reception-clipart-cropped-preschool-clipart23.png" height="130rem" alt="">
        </div>

    </div>

    <script>
        $("#institution").hide();

    </script>
@endsection
