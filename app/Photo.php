<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //
    protected $fillable = [
        'photo',
        'pin_id',
        'path',
    ];

    public function pin()
    {
        return $this->belongsTo(Pin::class);
    }

}