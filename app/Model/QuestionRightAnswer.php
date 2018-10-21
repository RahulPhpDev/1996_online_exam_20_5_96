<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuestionRightAnswer extends Model
{
    protected $table = "question_right_answer";
    // protected  $primaryKey = 'id';
//    protected $fillable =array ('l_name', 't_status','created_at', 'updated_at');
    protected $guarded = array();
    public $timestamps = false;
    
}
