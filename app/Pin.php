<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    //
    protected $fillable = [
        'text',
        'body',
        'location',
        'user_id',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}