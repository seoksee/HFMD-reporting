<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'recipients',
        'content',
        'when_to_send',
        'created_by',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
