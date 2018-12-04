<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Exam;
use DB;


use  App\Model\QuestionRightAnswer;
class Result extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function User(){
    	$res = $this->belongsTo(User::class);
        return $res;
    }

    public function Exam(){
    	$res = $this->belongsTo(Exam::class);
        return $res;
    }

    public function QuestionAnswer(){
        $res =   $this->hasOne(QuestionRightAnswer::class,'question_id');
        return $res;
    }
}
