<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    public $table = 'user_answer';
    public $timestamps = false;
    public $guarded = [];
}
