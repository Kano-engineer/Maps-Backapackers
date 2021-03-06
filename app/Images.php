<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //
    protected $fillable = [
        'file_name',
        'path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
