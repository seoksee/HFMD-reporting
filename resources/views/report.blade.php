@extends('layouts.user_home')

@section('content')
<style>
    .has-error .help-block,
.has-error .control-label,
.has-error .radio,
.has-error .checkbox,
.has-error .radio-inline,
.has-error .checkbox-inline,
.has-error.radio label,
.has-error.checkbox label,
.has-error.radio-inline label,
.has-error.checkbox-inline label {
  color: #a94442;
}
.has-error .form-control {
  border-color: #a94442;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
}
.has-error .form-control:focus {
  border-color: #843534;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
}
.has-error .input-group-addon {
  color: #a94442;
  background-color: #f2dede;
  border-color: #a94442;
}
.has-error .form-control-feedback {
  color: #a94442;
}
    </style>
    <div class="container report-container p-5">
        <h3 class="text-center"><strong>Hand Foot Mouth Disease Reporting</strong></h3>
        <form id="add_new_report" action="#" class="user" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group row">
                <label for="DOB" class="col-md-5 col-form-label text-md-right">{{ __('Date of birth of infected child') }}<span class="col-form-label"><strong>:</strong></span></label>

                <div class="col-md-6">
                <input type="date" id="DOB" class="form-control" name="DOB" max="{{Carbon::now()->isoFormat('YYYY-MM-DD')}}" value="{{ old('DOB') }}" required autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="relationship" class="col-md-5 col-form-label text-md-right">{{ __('Relationship with infected child') }}<span class="col-form-label"><strong>:</strong></span></label>

                <div class="col-md-6 ">

                    <select name="relationship" id="relationship_select" class="custom-select" required >
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
                <p class="col-md-5 col-form-label text-md-right">{{ __('Symptoms and Signs') }}<span class="col-form-label"><strong>:</strong></spatext-md-rightn><p>

                <div class="col-md-6 col-form-label">
                    @foreach ($symptoms as $symptom)
                        <input type="checkbox" class="custom-checkbox" name="symptoms[]" value="{{$symptom->id}}" >
                        {{ $symptom->name }} <br>
                    @endforeach
                    <input type="checkbox" class="custom-checkbox"
                    onclick="var input = $('#other'); if(this.checked){ input.removeAttr('disabled'); input.focus();}else{input.attr('disabled','disabled');}" />
                    <label for="other">Other: </label>
                    <input id="other" name="other_symptoms" type="text" class="col-md-6 " disabled="disabled"/>
                    <div id="symptom_error"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="diagnosis" class="col-md-5 col-form-label text-md-right">{{ __('Date of diagnosis') }}<span class="col-form-label"><strong>:</strong></span></label>

                <div class="col-md-6">
                    <input type="date" id="diagnosis" class="form-control" name="diagnosis" max="{{Carbon::now()->isoFormat('YYYY-MM-DD')}}" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="hospital" class="col-md-5 col-form-label text-md-right">{{ __('Admitted to hospital?') }}<span class="col-form-label"><strong>:</strong></span></label>

                <div class="col-md-6">
                    <div class="col-md-5 form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="hospital_admission" value="1" autofocus required/>
                        <label for="hospitalY" class="form-check-label">Yes</label>
                    </div>
                    <div class="col-md-5 form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="hospital_admission" value="0" autofocus/>
                        <label for="hospitalN" class="form-check-label">No</label>
                    </div>
                    <div id="hospital_error"></div>
                </div>

            </div>
            <div class="form-group row">
                <label for="resident" class="col-md-5 col-form-label text-md-right">{{ __('Residential Area') }}<span class="col-form-label"><strong>:</strong></span></label>

                <div class="col-md-6 row">
                    <div class="col-md-6">
                        <select name="residential_state_id" id="residential_state" class="custom-select dynamic" data-dependent="residential" required >
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{$state->id}}">{{$state->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="residential_district_id" id="residential_district" class="custom-select" required >
                            <option value="1">Select District</option>
                            {{-- @foreach($districts as $district)
                            @if($district->state_id == 10)
                                <option value="{{$district->id}}">{{$district->name}}</option>
                            @endif
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <div class="col-md-5"></div>
                    <div class="col-md-6">

                    </div>
                </div> --}}

            </div>
            <div class="form-group row">
                <label for="kindergarten" class="col-md-5 col-form-label text-md-right">{{ __('Attending to nursery school or kindergarten?') }}<span class="col-form-label"><strong>:</strong></span></label>

                <div class="col-md-6">
                    <div class="col-md-5 form-check form-check-inline">
                    <input type="radio" id="kindergartenY" class="form-check-input" name="attend_kindergarten" value="1" autofocus required
                onclick="var input = $('.institution'); if(this.checked){input.show('slow');}">
                    <label for="kindergartenY" class="form-check-label">Yes</label>
                </div>
                <div class="col-md-5 form-check form-check-inline">
                    <input type="radio" id="kindergartenN" class="form-check-input" name="attend_kindergarten" value="0" autofocus
                    onclick="var input = $('.institution'); if(this.checked){input.hide('slow');}">
                    <label for="kindergartenN" class="form-check-label">No</label>
                </div>
                <div id="kindergarten_error"></div>
                </div>

            </div>
            <div class="form-group row institution">
                <label for="school" class="col-md-5 col-form-label text-md-right">{{ __('Location of Institution') }}<span class="col-form-label"><strong>:</strong></span></label>

                <div class="col-md-6 row">
                    <div class="col-md-6">
                        <select name="kindergarten_state_id" id="kindergarten_state" class="custom-select dynamic" data-dependent="kindergarten" required >
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{$state->id}}">{{$state->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="kindergarten_district_id" id="kindergarten_district" class="custom-select" required >
                            <option value="">Select District</option>
                        </select>
                    </div>
                    {{-- <input type="text" id="school" class="form-control" name="kindergarten_location" value="{{ old('school') }}" autofocus placeholder="District name, State"> --}}
                </div>
            </div>
            <div class="form-group row institution">
                <div class="col-md-5 col-form-label text-md-right">{{ __('Any children from the institution have infected by HFMD recently?') }}<span class="col-form-label"><strong>:</strong></span></div>

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
                <label for="document" class="col-md-5 col-form-label text-md-right">{{ __('Document proof') }}<span class="col-form-label"><strong>:</strong></span></label>

                <div class="col-md-6">
                    <input type="file" class="form-control-file" name="document_id" autofocus >
                </div>
            </div>
            <button type="submit" id="checkBtn" class="btn btn-primary btn-user btn-block">
                    {{ __('Submit') }}
                </button><br>
        </form>
        <div class="container d-none d-lg-inline">
            <img src="https://i1.wp.com/images.clipartpanda.com/reception-clipart-cropped-preschool-clipart23.png" height="130rem" alt="">
            <img src="https://i1.wp.com/images.clipartpanda.com/reception-clipart-cropped-preschool-clipart23.png" height="130rem" alt="">
        </div>

    </div>
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>

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
            $('.dynamic').change(function(){
                if($(this).val() != '') {
                    var select = "state_id";
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var _token = "{{csrf_token()}}";
                    $.ajax({
                        url: "/district/fetch",
                        method: "POST",
                        data: {
                            select: select,
                            value: value,
                            _token: _token,
                            dependent: dependent
                        },
                        success: function(result){
                            $('#'+dependent+'_district').html(result);
                        }
                    })
                }
            });

            $('#residiential_state').change(function() {
                $('residential_district').val('');
            });

            validator2 = $('#add_new_report').validate({
            // ignore: ":hidden",
            rules: {
                DOB: {
                    required: true,
                },
                relationship: {
                    required: true,
                },
                "symptoms[]": {
                    required: true,
                    minlength: 1,
                }
            },
            messages: {
                DOB: {
                    required: "Date of birth of infected child is required.",
                },
                relationship: {
                    required: "Please upload the file",
                },
                "symptoms[]": {
                    required: "Please select at least one symptom or sign.",
                },
                hospital_admission: {
                    required: "Please select one of the option.",
                },
                attend_kindergarten: {
                    required: "Please select one of the option.",
                }
            },
            highlight: function (element) {
                $(element).closest(".form-group").addClass("has-error");
            },
            unhighlight: function (element) {
                $(element).closest(".form-group").removeClass("has-error");
            },
            errorElement: "span",
            errorClass: "help-block",
            errorPlacement: function (error, element) {
                if (element.parent(".input-group").length) {
                    error.insertAfter(element.parent());
                } else if (element.attr("name") == "symptoms[]") {
                    error
                        .appendTo("#symptom_error");
                } else if (element.attr("name") == "hospital_admission") {
                    error.appendTo("#hospital_error");
                } else if (element.attr("name") == "attend_kindergarten") {
                    error.appendTo("#kindergarten_error");
                } else {
                    error.insertAfter(element);
                }
            },

            // Display error
            invalidHandler: function (event, validator) {

                swal({
                    title: "",
                    text:
                        "There are some errors in your submission. Please correct them.",
                    icon: "warning",
                    confirmButtonClass: "btn btn-secondary",
                });
            },

            // Submit valid form
            submitHandler: function (form) {
        //         $.ajax({
        //     data: $('#add_new_report').serialize(),
        //     url: "/report",
        //     type: "POST",
        //     dataType: 'json',
        //     success: function (data) {
        //         swal({
        //             icon: 'success',
        //             title: 'Your report has been submitted and waiting review by an admin.',
        //             button: false,
        //             timer: 1500
        //         }),
        //         window.location.href= "/";
        //     },
        //     error: function (data) {
        //         console.log('Error:', data);
        //         var error_msg = '';
        //         if(data.responseJSON.name) {
        //             error_msg += data.responseJSON.name[0];
        //         }
        //         swal({
        //             icon: 'error',
        //             title: 'Invalid input!',
        //             position: 'top',
        //             text: error_msg,
        //         });
        //     }
        // });

                setTimeout(function () {
                    var dataForm = new FormData();
                    var token = "{{csrf_token()}}";
                    var DOB = $('input[name="DOB"]').val();
                    var relationship = $('#relationship_select option:selected').text();
                    var symptoms = [];
                    $.each($("input[name='symptoms[]']:checked"), function() {
                        symptoms.push($(this).val());
                    });
                    var other_symptoms = $('input[name="other_symptoms"]').val();
                    var diagnosis = $('input[name="diagnosis"]').val();
                    var hospital_admission = $('input[name="hospital_admission"]:checked').val();
                    var residential_state_id = $('#residential_state option:selected').val();
                    var residential_district_id = $('#residential_district option:selected').val();
                    var attend_kindergarten = $('input[name="attend_kindergarten"]:checked').val();
                    var kindergarten_state_id = $('#kindergarten_state option:selected').val();
                    var kindergarten_district_id = $('#kindergarten_district option:selected').val();
                    var children_in_kindergarten_infected = $('input[name="children_in_kindergarten_infected"]').val();
                    var children_infected = $('input[name="children_infected"]:checked').val();
                    if(children_infected == 0) {
                        children_in_kindergarten_infected = 0;
                    }
                    var document_id = $('input[name="document_id"]')[0].files[0];
                    // var document_types_id = $(".document_types_id").val();
                    // var description = $(".description").val();
                    // var invoice_id = $(".invoice_id").val();
                    // var role = $(".role").val();

                    dataForm.append("_token", token);
                    dataForm.append("DOB", DOB);
                    dataForm.append("relationship", relationship);
                    dataForm.append("symptoms[]", symptoms);
                    dataForm.append("other_symptoms", other_symptoms);
                    dataForm.append("diagnosis", diagnosis);
                    dataForm.append("hospital_admission", hospital_admission);
                    dataForm.append("residential_state_id", residential_state_id);
                    dataForm.append("residential_district_id", residential_district_id);
                    dataForm.append("attend_kindergarten", attend_kindergarten);
                    dataForm.append("kindergarten_state_id", kindergarten_state_id);
                    dataForm.append("kindergarten_district_id", kindergarten_district_id);
                    dataForm.append("children_in_kindergarten_infected", children_in_kindergarten_infected);
                    dataForm.append("document_id", document_id);

                    // alert(formData);

                    $.ajax({
                        url: "/report",
                        type: "POST",
                        data: dataForm,
                        mimeTypes: "multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData: false,
                        error: function (data) {
                            console.log('Error:', data);
                            var error_msg = '';
                            if(data.responseJSON.name) {
                                error_msg += data.responseJSON.name[0];
                            }
                            swal({
                                icon: 'error',
                                title: 'There is an error submitting your report.',
                                position: 'top',
                                text: error_msg,
                            });

                        },
                        success: function (data) {
                            swal({
                                title: "Your report has been submitted and waiting review by an admin.",
                                icon: "success",

                                })
                                .then(() => {
                                    window.location.href= "/";

                                });
                        },
                    });

                }, 500);
            },
        });
        });
    </script>
@endsection
