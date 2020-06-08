<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    //
    protected $fillable = ['name'];

    public function reports()
    {
        $this->hasMany('App\Report');
    }
}
