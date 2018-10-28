<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ExamQuestion;
use App\Model\Question;
use  App\Model\QuestionOption;
use DB;

class Exam extends Model
{
    protected $guarded = [];
    public $timestamps = false;

      

    public function ExamQuestion(){
        $questionOutput = $this->belongsToMany(Question::class)->wherePivot('status', 1);
        
        return $questionOutput;
    }


    // public function Question(){
    // // $question = $this
    // }

    public function getExamDetailsById($id){
    	 DB::enableQueryLog();
    	 $res = DB::table('exams as e')->select('e.*')->where('id', $id);
         $result = $res->get()->first();
         // dd($result);
         $final = array();
         $counter = 0;

	 		$final['exam_details'] = $result;
	 		$examQuestion =	$this->getExamQuestionById($id);
			$final['question'] = $examQuestion;
			return $final;
  		 } 


        public function getExamQuestionById($id){
        	// echo $id;die();
    	 DB::enableQueryLog();
    	 $query = DB::table('exam_question as eq')
                    ->leftJoin('questions as q', 'q.id',  '=', 'eq.question_id')
                    ->select('q.*','eq.*')
    	 			->where(array(['exam_id', "=",$id], ['eq.status' , "=", 1]));
          $result = $query->get()->toArray();
          $i = 0;
          foreach($result as $res){
          $output[$res->question_id]['question'] = $res; 
         	$options =  	$this->getQuestionOption($res->question_id);
         	$output[$res->question_id]['options']= $options;


          $right_answer =   $this->getRightAnswerQuestion($res->question_id);
          $output[$res->question_id]['right_anser'] = $right_answer;

         	$i++;
          }
          return $output;
  		 } 

  		 public function getQuestionOption($qid){
  		 	DB::enableQueryLog();
    		 $query = DB::table('question_options as qo')
                    ->select('qo.*')
    	 			->where('question_id',$qid);
             $result = $query->get();
         $result = $result->toArray();
          return $result;
  		 }

  		 public function getRightAnswerQuestion($qid){
  		 	DB::enableQueryLog();
    		 $query = DB::table('question_right_answer as qra')
                    ->select('qra.*')
    	 			->where('question_id',$qid);
             $result = $query->get()->first();
            // $result = $result->toArray();
         
          return $result;
  		 }
    
}
