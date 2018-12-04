<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use  App\Model\QuestionOption;
use  App\Model\QuestionRightAnswer;

class Question extends Model
{
   protected $table = "questions";
    // protected  $primaryKey = 'id';
//    protected $fillable =array ('l_name', 't_status','created_at', 'updated_at');
    protected $guarded = array();
    public $timestamps = false;

    public function Options(){
    	$optionData = $this->hasMany(QuestionOption::class);
    	return $optionData;
    }

    public function rightAnswer(){
	    return  $this->hasOne(QuestionRightAnswer::class,'question_id');
	 }

     
}
