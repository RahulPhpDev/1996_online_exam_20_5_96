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
 function get_next_key($cKey){
    $array = session('question_class');
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