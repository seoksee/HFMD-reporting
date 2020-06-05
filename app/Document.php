<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $uploads = '/documents/';
    protected $fillable = ['file'];

    public function getFileAttribute($document)
    {
        return $this->uploads.$document;
    }
}
