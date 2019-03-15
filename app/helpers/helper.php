<?php

if(!function_exists('getExamStatusMeaning')){
    function getExamStatusMeaning($status){
        $statusArr = array('status', '>=',  1);
        switch($status){
            case 'active':
               $statusArr = array('status', '=', 1);
               return $statusArr;
            break;

            case 'disable':
                $statusArr = array('status', '=',  2);
                return $statusArr;
            break;

            case 'all':
                $statusArr = array('status', '>=',  0);
                return $statusArr;
              break;

            case 'in_complete':
              $statusArr = array('status', '=',  0);
              return $statusArr;
            break;

            case 'passed_date':
                $statusArr = array('end_date', '>=', date('Y-m-d H:i:s'));
                return $statusArr;
            break;

            default:
                return  $statusArr;
            break;
        }
    }
}
if (!function_exists('timeDifference')) {
    function timeDifference($date)
    {
        $time = date('Y-m-d H:i:s');
        $start_date = new DateTime($date);
        $end_date = new DateTime($time);
        $interval = $start_date->diff($end_date);
        $diff = $interval->h.":".$interval->i.":".$interval->s;
        return $diff;
    }
}

if (!function_exists('DateManipulation')) {
function DateManipulation($date,$format='d-M-Y'){
    if($date!=""){
        return date($format,strtotime($date));
    }
    else {
        echo "";
    }
 }
}

if (!function_exists('DateTimeConvert')) {
    function DateTimeConvert($dates , $type = 'Y-m-d H:i:s'){
        $date = new \DateTime($dates);
        return date_format($date, $type);
        }
}

if (!function_exists('extractDateTime')) {
    function extractDateTime($format = 'Y-m-d',$dates){
        $timestamp =  strtotime($dates);
        return date($format, $timestamp);

        }
}

if (!function_exists('isDateInBetween')) {
    function isDateInBetween($start , $end, $current = 'Y-m-d H:i:s'){
        $currentDate = date($current);            
        $startDate=date('Y-m-d H:i:s', strtotime($start));
        $endDate = date('Y-m-d H:i:s', strtotime($end));
        $returnval = 0;
        if (($currentDate >= $startDate) && ($currentDate <= $endDate)){
            $returnval = 1;
        }
        return $returnval;
    }
}

if (!function_exists('get_next')) {
    function get_next($array , $c_val){
      $i = 0;
      $nextVal = current($array);
      foreach($array as $vl){
        if($i == 1){
          $nextVal = $vl;
          break;
        }
          else if($c_val == $vl){
            $i = 1;
          }
        }
      return $nextVal;
    }
}


if (!function_exists('get_next_key')) {
 function get_next_key(  $array,$cKey){
    // $array = session('question_class');
      $i = 0;
      $nextVal = key($array);
      foreach($array as $vl => $value){
        if($i == 1){
          $nextVal = $vl;
          break;
        }
          else if($cKey == $vl){
            $i = 1;
          }
        }
      return $nextVal;
    }
}

if (!function_exists('forgetSession')) {
    function forgetSession(){
        // session()->flush();
        if(session()->has('user_answer.question')) {
            session()->forget('user_answer.question');
        }
        if(session()->has('all_question_checked')) {
            session()->forget('all_question_checked');
        }
        if(session()->has('attempt_questions')) {
            session()->forget('attempt_questions');
        }
        if(session()->has('questions_answer')) {
            session()->forget('questions_answer');
        }
        
        if(session()->has('exam_id')) {
            session()->forget('exam_id');
        }
        if(session()->has('all_questions')) {
            session()->forget('all_questions');
        }
        if(session()->has('all_questions_class')) {
        session()->forget('all_questions_class');
        }

        if(session()->has('exam_process')) {
            session()->forget('current_question');
            session()->forget('exam_process');
        }

        if(session()->has('user_answer.question')) {
        session()->forget('user_answer.question');
        }
        if(session()->has('start_time')) {
         session()->forget('start_time');
        }

        if(session()->has('lastanswer')) {
         session()->forget('lastanswer');
        }
      }
    }



if(!function_exists('trim_words')){
  function trim_words(string $str,$limit = '15'){
        $output = strlen($str) > $limit ? substr($str,0,$limit).'...':$str ;
        return $output;
  }
}

if(!function_exists('generate_string')){     
    function generate_string($strength = 16) {
        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.time();
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
     
        return $random_string;
    }
 }
if(!function_exists('maxAttempt')){     
    function maxAttempt() {
     return array('1' => '1', '2' => '2', '3' => '3', '0'=> 'Forever');
    }
}

/************************* Start Of New ATTempt *******************
    public function attemptExam($e_id){
     $id =  Crypt::decrypt($e_id);
     $examData = Cache::remember('examDetails'.$id, 60, function() use ($id) {
       return Exam::find($id);
     });
     $allQuestionArray = array();
       if(!Session::has('total_time')){
        session(['total_time' => $examData->time]);
       }
     $passArray = array(
               'examDetails' => Response::json($examData),
               'en_eId' => $e_id,
        );  
      return view('permit.exam.attempt-exam',$passArray);
    }

  public function fetchExamQuestion($id){
    $examId = Crypt::decrypt($id);
    $examData = Cache::remember('examDetails'.$examId, 60, function() use ($examId) {
       return Exam::find($examId);
     });
     $questionData = Cache::remember('questionData'.$examId, 60, function() use ($examData) {
        return $questionData = array_column($examData->ExamQuestion->toArray(), 'id');
     });
      $questionWithDetails = array();
      if(!session()->has('exam_process')) { 
          $current_question = $questionData[0];
          session(['current_question' => $current_question]);
          session()->put('exam_process' , 1);
       }else{
         $current_question = session('current_question');
      }
       if(!session()->has('question_class')) {   
          foreach($questionData as $key => $que){
              $questionWithDetailsClass['question_class'][$que]  = ($key == 0) ?  'current':  'pending';
            }
            session(['question_class' =>  $questionWithDetailsClass['question_class']]);
          }else{
              Session::put('question_class.'.$current_question,'current');
        } 
        session::save();       
       
      $questionDetails    = Question::find($current_question);
      $questionWithDetails['question'] =  $questionDetails;
      $questionWithDetails['question']['encoded_question'] = htmlspecialchars_decode($questionDetails->question);
      $questionWithDetails['question_class'] = session('question_class');
     foreach($questionDetails->Options->toArray() as $key => $data){
        $questionWithDetails['optionsdata'][$key]['id'] = $data['id'];
        $questionWithDetails['optionsdata'][$key]['question_option'] = htmlspecialchars_decode($data['question_option']);
     }
      return json_encode($questionWithDetails);
  }

  public function getDirectQuestion(Request $request){
    $last_attempt_question = session('current_question');
     if(session()->has('questions_answer.'.$last_attempt_question) && (session('questions_answer.'.$last_attempt_question ) > 0) ) {
             Session::put('question_class.'.$last_attempt_question, 'answered');
      }else{
        Session::put('question_class.'.$last_attempt_question,'review');
      }
    session(['current_question' => $request->questionId]);
  }  

  public function saveAnswer(Request $request){
      $last_attempt_question = session('current_question');
      if($request['save'] ==  'continue'){
        if(isset($request['answer'])){
          $answerID = $request['answer'];
          Session::put('question_class.'.$last_attempt_question,'answered');
          Session::put('questions_answer.'.$last_attempt_question,$answerID);
        }else{
          Session::put('question_class.'.$last_attempt_question,'review');
        }
        $nextQuestionId = get_next_key( session('current_question'));
        session(['current_question' => $nextQuestionId]);
      }

      else if($request['save'] ==  'skip'){
        $class = 'not_answered';
        Session::put('question_class.'.$last_attempt_question,$class);
        Session::put('questions_answer.'.$last_attempt_question,0);
        $nextQuestionId = get_next_key( session('current_question'));
        session(['current_question' => $nextQuestionId]);
      }

      else if($request['save'] ==  'preview'){
        Session::put('question_class.'.$last_attempt_question,'review');
          $nextQuestionId = get_next_key(session('current_question'));
          session(['current_question' => $nextQuestionId]);    
        if(session()->has('questions_answer.'.$last_attempt_question) && (session('questions_answer'.$last_attempt_question ) > 0) ) {
             Session::put('questions_answer.'.$last_attempt_question,-1);
        }
      }

  }
Array
(
    [_token] => 0tUykv1twjYl5yusHFsAsVGG7SC11XEJnsyJXVr3
    [_previous] => Array
        (
            [url] => http://127.0.0.1:8000/fetch_exam_question/eyJpdiI6InpZU2pTNDNvVDRDUFwvK1A0VURVK29RPT0iLCJ2YWx1ZSI6IlM1WWk3MmNXZk1ObG91OUJHN29CUmc9PSIsIm1hYyI6IjkzNzNjNWY3MzY4MDI3MTgwN2M5MDk5MTUzNDVkZDliZDIwNjY1MTdmMjJjZjRmYWVlZjU1N2QyMDE5MmJlZGQifQ==
        )

    [_flash] => Array
        (
            [old] => Array
                (
                )

            [new] => Array
                (
                )

        )

    [login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d] => 35
    [total_time] => 50
    [current_question] => 715
    [exam_process] => 1
    [question_class] => Array
        (
            [697] => answered
            [698] => answered
            [699] => answered
            [700] => answered
            [701] => answered
            [702] => answered
            [703] => answered
            [704] => answered
            [705] => review
            [706] => not_answered
            [707] => not_answered
            [708] => review
            [709] => review
            [710] => review
            [711] => review
            [712] => answered
            [713] => answered
            [714] => answered
            [715] => current
            [716] => pending
            [717] => pending
            [718] => pending
            [719] => pending
            [720] => pending
            [721] => pending
            [722] => pending
            [723] => pending
            [724] => pending
            [725] => pending
            [726] => pending
            [727] => pending
            [728] => pending
            [729] => pending
            [730] => pending
            [731] => pending
            [732] => pending
            [733] => pending
            [734] => pending
            [735] => pending
            [736] => pending
            [737] => pending
            [738] => pending
            [739] => pending
            [740] => pending
            [741] => pending
            [742] => pending
            [743] => pending
            [744] => pending
            [745] => pending
            [746] => pending
        )

    [questions_answer] => Array
        (
            [697] => 2773
            [700] => 2785
            [701] => 2790
            [702] => 2795
            [703] => 2797
            [699] => 2781
            [704] => 2801
            [705] => 0
            [706] => 0
            [707] => 0
            [712] => 2836
            [698] => 2779
            [713] => 2838
            [714] => 2842
        )

)
check
  
/************************* End Of New ATTempt ********************/