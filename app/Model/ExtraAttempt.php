<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class ExtraAttempt extends Model
{
    protected $table = 'extra_attempt';
    protected $guarded = [];
    public $timestamps = false;

    public function getUserExamById($exam_id, $user_id){
    	$data = DB::table('user_exam as ue')
    			->where(array(
    					['user_id', $user_id],
    					['exam_id', $exam_id]
    				))
    		->select(['exam_name', 'fname', 'lname', 'email'])
    		->leftJoin('users as u','u.id', '=', 'ue.user_id')
    		->leftJoin('exams as e', 'e.id', '=', 'ue.exam_id')
    		->first();  		
		return $data;   		
    }

    public function userExtraAttemptOnExamById($exam_id, $user_id){
    	$data = DB::table($this->table.' as ea')
    			->where(array(
    					['user_id', $user_id],
    					['exam_id', $exam_id],
    					['ea.status', 1]
    				))
    		->select(['exam_name', 'fname', 'lname', 'email','ea.attempt', 'ea.end_date', 'ea.status','ea.create_at'])
    		->leftJoin('users as u','u.id', '=', 'ea.user_id')
    		->leftJoin('exams as e', 'e.id', '=', 'ea.exam_id')
    		->get();  	
		return $data;
    }
}
