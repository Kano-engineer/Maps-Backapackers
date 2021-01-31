<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function pins()
    {
        return $this->hasMany(Pin::class);
    }
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function favorites()
    {
        return $this->belongsToMany('App\Pin')->withTimestamps();
    }
    
     // フォロワー→フォロー
     public function followUsers()
     {
         return $this->belongsToMany('App\User', 'follow_users', 'followed_user_id', 'following_user_id');
     }
 
     // フォロー→フォロワー
     public function follows()
     {
         return $this->belongsToMany('App\User', 'follow_users', 'following_user_id', 'followed_user_id');
     }   
}