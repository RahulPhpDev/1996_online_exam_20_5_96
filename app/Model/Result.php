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
}


