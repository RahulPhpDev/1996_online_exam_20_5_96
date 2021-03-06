<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// use App\Model\ExamQuestion;
use App\Model\Question;
use  App\Model\QuestionOption;
use  App\Model\Subscription;
use App\User;
use App\Model\Course;
use App\Model\Result;
use DB;
use Auth;
use Session;

class Exam extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function ExamQuestion(){
        $questionOutput = $this->belongsToMany(Question::class)->wherePivot('status', 1);
         return $questionOutput;
    }

    public function getExamDetailsById($id){
    	 DB::enableQueryLog();
    	 $res = DB::table('exams as e')->select('e.*')->where('id', $id);
         $result = $res->get()->first();
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
          $output = array();
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
             return $result;
  		 }

    public function UserExam(){
        $res = $this->belongsToMany(Exam::class,'user_exam')->wherePivot('status' , "=", 1);
        return $res;
    }

    public function userAnswer(){
      // dd($userId);
      $res = session()->get('res_id');
       $userDetails =  Auth::user();
        $res = $this->belongsToMany(Exam::class,'user_answer')
                    ->withPivot(['question_id','answer_id','result_id'])
                    ->wherePivot('user_id' , "=", $userDetails['id'])
                    // session()->flash('res_id', $r_id);
                    ->wherePivot('result_id' , "=", $res);
        // dd($res);
        // res_id
        return $res;
    }

//     $id =       $request->segment(2);
// dd($id);

//       $r_id = Crypt::decrypt($resultId);
//       dd($r_id);
//         $resultObj = new Result;
//         echo $r_id;

//        $userDetails =  Auth::user();
//         $res = $this->belongsToMany(Exam::class,'user_answer')->withPivot(['question_id','answer_id','result_id'])->wherePivot('user_id' , "=", $userDetails['id'])->wherePivot('result_id' , "=", 777);
//         // dd($res); 'result_id' , "=", 777
//         return $res;

     public function UserExamData(){
        $res = $this->belongsToMany(User::class,'user_exam')->wherePivot('status' , "=", 1);
        return $res;
    }

     public function Subscriptions(){
      $res = $this->belongsToMany(Subscription::class)->withPivot(['status'])->where('exam_subscription.status','=' ,1);
      return $res;
    }

     public function Courses(){
      $res = $this->belongsToMany(Course::class)->withPivot(['status'])->where('course_exam.status','=' ,1);
      return $res;
    }

    public function AllCourses(){
      $res = $this->belongsToMany(Course::class)->withPivot(['status']);
      return $res;
    }

    public function Results(){
        $res = $this->hasMany(Result::class);
        return $res;
    }

    public function getExamQuestionForMarkUpdation($id){
      DB::enableQueryLog();
      $query = DB::table('exam_question as eq')
          ->leftJoin('questions as q', 'q.id', '=', 'eq.question_id')
          ->select('q.id as question_id','marks','q.negative_marks','q.is_negative_marking')
          ->where(array(['exam_id', "=",$id], ['eq.status' , "=", 1]));
      $result = $query->get()->toArray();
      return $result;
    }
}
