<?php

namespace App\Model;

use DB;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    public $table = 'user_answer';
    public $timestamps = false;
    public $guarded = [];

    public function getUserExamAnswer($userId , $examID){
    		DB::enableQueryLog();
    		 $query = DB::table('user_answer as ua')
                    ->select('ua.*')
                    	// ->where(array(['exam_id', "=",$id], ['eq.status' , "=", 1]));

    	 			->where('user_id',$userId)
    	 			->where('exam_id',$examID);
             $result = $query->get();
         	 $resultData = $result->toArray();
         	 // dd($resultData);
        	 return $resultData;
    }
}
