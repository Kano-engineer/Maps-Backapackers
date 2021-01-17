<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //
    protected $fillable = [
        'photo',
        'pin_id',
    ];

    public function pin()
    {
        return $this->belongsTo(Pin::class);
    }

}
