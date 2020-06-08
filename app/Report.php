<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'DOB',
        'relationship',
        'symptoms',
        'other_symptoms',
        'diagnosis',
        'hospital_admission',
        'residential',
        'attend_kindergarten',
        'kindergarten_location',
        'children_in_kindergarten_infected',
        'file',
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
        return $this->hasMany('App\Symptom');
    }


}
