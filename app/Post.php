<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dailies_tasks_table extends Model
{
    protected $table = "post";

    protected $fillable =
    [
        'id',
        'todo_text',
        'daily_text',
        'created_at',
        'updated_at'
    ];
}
