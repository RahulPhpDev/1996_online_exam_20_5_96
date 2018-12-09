<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Exam;
use DB;
class Course extends Model
{
     protected $fillable = [
        'id','name', 'description','add_date','status','edit_date'
    ];
   public $timestamps = false;
   protected $table = "courses";
    protected  $primaryKey = 'id';
////    protected $fillable =array ('l_name', 't_status','created_at', 'updated_at');
//    protected $guarded = array();
    //

     public function Exam(){
    	$res = $this->belongsToMany(Exam::class)->withPivot(['status'])->where('course_exam.status','=' ,1);
    	return $res;
    }

     public function getCourseHaveExam(){
        	// echo $id;die();
    	 DB::enableQueryLog();
    	 $query = DB::table('course_exam as ce')
    	 			 ->groupBy('ce.course_id')
    	 			 ->leftJoin('courses as c', 'c.id',  '=', 'ce.course_id')	
             ->take(8)
             ->orderBy('ce.id','desc')
    	 			->where(array(['ce.status' , "=", 1]));
          $result = $query->get()->toArray();
       //   dd($result);
       $counter = 0;
       $output = array();
       foreach($result as $res){
       $courseExam = 	$this->getCourseExam($res->course_id);
      //dd( $courseExam);
   		$output[$counter]['course'] = $res->name;
   		$output[$counter]['id'] = $res->id;
   		$output[$counter]['description'] = $res->description;
   		//foreach ($courseExam as $key => $exam) {
   			$output[$counter]['exam'] = $courseExam;
   		//}
   		 $counter++;
   		}
          return ($output);
  		 } 

		public function getCourseExam($c_id){
			DB::enableQueryLog();
    		 $query = DB::table('course_exam as ce')
    				 ->leftJoin('exams as e', 'ce.exam_id',  '=', 'e.id')
    	 			->where(array('e.status' =>1, 'ce.course_id' => $c_id))
             ->take(3)
             ->orderBy('e.id', 'desc')
              // ->select(DB::raw('count(*) as total'))
    	 			->select([ 'e.id','e.exam_name','e.total_question', 'e.total_marks','e.image','e.time']);
          $result = $query->get()->toArray();
          return $result;
		}
	}
