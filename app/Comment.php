<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //テーブル名
    protected $table = 'comments';

    //可変項目(変わる項目)
    protected $fillable =
    [
        'comment'
    ]; 

    //Postモデルから唱えるとPostにアクセスできる
    public function post(){
        return $this->belongsTo(Post::class);
    }
}
