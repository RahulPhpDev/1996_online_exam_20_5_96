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

       public function getResultByUserId($id){
            // echo $id;die();
         DB::enableQueryLog();
         $query = DB::table('results as r')
                    ->leftJoin('user_answer as ua', 'r.id',  '=', 'ua.result_id')
                    ->leftJoin('questions as q', 'q.id',  '=', 'ua.question_id')
                    ->leftJoin('question_options as qo', 'qo.id',  '=', 'ua.answer_id')
                    ->select('q.*','r.*','ua.*','qo.*')
                    ->where(array(['r.id', "=",$id]));
                    // DB::table('users')->toSql()
                    // dd(DB::getQueryLog());

                    // , ['eq.status' , "=", 1]
          $result = $query->get()->toArray();
          $sql = $query->toSql();
         // dd(DB::getQueryLog());

// $bindings = $query->getBindings();
//           dd($sql);
          // dd($query);
          // dd($result);
          return $result;
         } 

         public function getResultDetailsById($rid){
          DB::enableQueryLog();
          $query =  DB::table('results as r')
              ->leftJoin('exams as e', 'r.exam_id','=', 'e.id')
              ->rightJoin('user_answer as ua','ua.result_id','=','r.id')
              ->rightJoin('questions as q','q.id','=','ua.question_id')
              ->leftJoin('question_options as qo','ua.answer_id','=','qo.id')
              ->leftJoin('users as u','r.user_id','=','u.id')
              ->select('r.exam_id','r.user_id','r.id','r.obtain_mark','r.result_status','r.time_taken','qo.question_option','e.exam_name')
              ->addselect('ua.question_id','ua.answer_id','ua.mark','ua.status')
              ->addselect('q.question','q.id','q.marks')
              ->addselect('u.fname','u.lname')
         //     ->where(array(['r.id', "=",$id]));
              ->where(array(['r.id', '=', $rid]));
               $result = $query->get()->toArray();
               $sql = $query->toSql();
               return $result;
             // dd(DB::getQueryLog());
// select `r`.`exam_id`, `r`.`user_id`, `r`.`id`, `r`.`obtain_mark`, `r`.`result_status`, `r`.`time_taken`, `ua`.`question_id`, `ua`.`answer_id`, `ua`.`mark`, `q`.`question`, `q`.`id`, `q`.`marks`, `qo`.`question_option` from `results` as `r` left join `exams` as `e` on `r`.`exam_id` = `e`.`id` right join `user_answer` as `ua` on `ua`.`result_id` = `r`.`id` right join `questions` as `q` on `q`.`id` = `ua`.`question_id` right join `question_options` as `qo` on `ua`.`answer_id` = `qo`.`id` where (`r`.`id` = 30)
         }

         public function getResultDetailsforAdmin($rid){
            DB::enableQueryLog();
            $query =  DB::table('results as r')
                ->leftJoin('exams as e', 'r.exam_id','=', 'e.id')
                ->rightJoin('user_answer as ua','ua.result_id','=','r.id')
                ->rightJoin('questions as q','q.id','=','ua.question_id')
                ->leftJoin('question_options as qo','ua.answer_id','=','qo.id')
                ->leftJoin('users as u','r.user_id','=','u.id')
                //->leftJoin('question_right_answer as ra','ra.question_id','=','q.id')
              //  ->leftJoin('question_options as rqo','ra.option_id','=','qo.id')


                ->select('r.exam_id','r.user_id','r.id','r.obtain_mark','r.result_status','r.time_taken','qo.question_option','e.exam_name')
                ->addselect('ua.question_id','ua.answer_id','ua.mark','ua.status')
                ->addselect('q.question','q.id','q.marks')
                ->addselect('u.fname','u.lname')
              //  ->addselect('ra.question_id','ra.option_id')
              //  ->addselect('rqo.question_option as right_option')

                ->where(array(['r.id', '=', $rid]));
                 $result = $query->get()->toArray();
                 $sql = $query->toSql();
                //  dd(DB::getQueryLog());
                 return $result;
           }

         public function rightAnswerByResultId($user_id, $question_id){
            DB::enableQueryLog();
            $query = DB::table('user_answer as ua')
                      ->select('question_id', 'answer_id','status','mark')
                      ->where(array(
                        // ['result_id' , '=', $res_id],
                                 ['user_id', '=', $user_id],
                                 ['question_id' , '=',$question_id ]
                      ));
            $result = $query->first();
            return $result;                      

         }
// Get All Question 

         public function getDataByResultId($rid,$userId){
            DB::enableQueryLog();
            $query =  DB::table('results as r')
                        ->select('r.exam_id','r.user_id','r.id','r.obtain_mark','r.result_status','r.time_taken')
                        ->where(array(['r.id', '=', $rid],
                          ['r.user_id', '=', $userId],));
                         $result = $query->get()->toArray();
              $final_array = array();
              $counter = 0;           
              foreach($result as $res){
                $allInfoAboutQuestion =   $this->getUserAnswerByResultId($rid);
                $final_array = $allInfoAboutQuestion;
                $counter++;
              }
            // dd($final_array);
            return $final_array;
           }

        public function getQuestionById($qid){
            DB::enableQueryLog();
            $query =  DB::table('questions as q')
                        // ->leftJoin('question_right_answer as ra','ra.question_id','=','ua.question_id')
                        ->select('q.question')
                        // ->addselect('ra.option_id')
                        ->where(array(['q.id', '=', $qid]));
                         $result = $query->first();
                        
            return $result;                         
        }   


        public function getUserAnswerByResultId($rid){
            DB::enableQueryLog();
            $query =  DB::table('user_answer as ua')
                        ->leftJoin('question_right_answer as ra','ra.question_id','=','ua.question_id')
                        ->select('ua.question_id','ua.answer_id','ua.mark','ua.status')
                        ->addselect('ra.option_id')
                        ->where(array(
                          ['ua.result_id', '=', $rid],
                        ));
                         $result = $query->get()->toArray();
                         // $sql = $query->toSql();
                         // dd($result);
            $option_data = array(); 
            $counter = 0;                        
            foreach($result as $res){
               $allInfoAboutQuestion =   $this->getQuestionById($res->question_id);
               $allOptions =  $this->getOptionByQuestionId($res->question_id);
              
               $option_data[$counter]['question'] =   $allInfoAboutQuestion->question;
               $option_data[$counter]['option'] =  $allOptions;
               $option_data[$counter]['user_right_answer'] =  $res->answer_id;
               $option_data[$counter]['question_right_answer'] =  $res->option_id;
               $option_data[$counter]['mark_status'] =  $res->status;
               $option_data[$counter]['mark'] =  $res->mark;

               $counter++;
            }
            return $option_data;
            // dd($option_data);
        }   

        public function getOptionByQuestionId($qid){
          DB::enableQueryLog();
            $query =  DB::table('question_options as qo')
                        ->select('qo.id','qo.question_id','qo.question_option')
                        ->where(array(['qo.question_id', '=', $qid]));
                         $result = $query->get()->toArray();
                         // $sql = $query->toSql();
            //              dd($result);
            // foreach($result as $res){
            //     $this->getOptionByQuestionId($res->question_id);
            // }
            return $result; 
        }
}


