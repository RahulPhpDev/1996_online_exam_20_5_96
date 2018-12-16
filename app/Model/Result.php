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
              // ->select(['r.id','r.exam_id','r.user_id'])
              // ->select(['q.id','q.question'])
              ->select('r.exam_id','r.user_id','r.id','r.obtain_mark','r.result_status','r.time_taken','ua.question_id','ua.answer_id','ua.mark','ua.status','q.question','q.id','q.marks','qo.question_option','e.exam_name')
         //     ->where(array(['r.id', "=",$id]));
              ->where(array(['r.id', '=', $rid]));
               $result = $query->get()->toArray();
               $sql = $query->toSql();
               return $result;
             // dd(DB::getQueryLog());
// select `r`.`exam_id`, `r`.`user_id`, `r`.`id`, `r`.`obtain_mark`, `r`.`result_status`, `r`.`time_taken`, `ua`.`question_id`, `ua`.`answer_id`, `ua`.`mark`, `q`.`question`, `q`.`id`, `q`.`marks`, `qo`.`question_option` from `results` as `r` left join `exams` as `e` on `r`.`exam_id` = `e`.`id` right join `user_answer` as `ua` on `ua`.`result_id` = `r`.`id` right join `questions` as `q` on `q`.`id` = `ua`.`question_id` right join `question_options` as `qo` on `ua`.`answer_id` = `qo`.`id` where (`r`.`id` = 30)
         }
}


