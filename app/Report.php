<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'DOB',
        'age',
        'relationship',
        'symptoms',
        'other_symptoms',
        'diagnosis',
        'hospital_admission',
        'residential_state_id',
        'residential_district_id',
        'attend_kindergarten',
        'kindergarten_state_id',
        'kindergarten_district_id',
        'children_in_kindergarten_infected',
        'document_id',
        'is_approve',
        'fatal',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function document(){
        return $this->belongsTo('App\Document');
    }

    public function symptoms(){
        return $this->belongsToMany('App\Symptom');
    }


}
