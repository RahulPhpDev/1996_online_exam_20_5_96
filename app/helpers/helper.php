<?php


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
    function DateTimeConvert($dates){
        $date = new \DateTime($dates);
        return date_format($date, 'Y-m-d H:i:s');
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

if (!function_exists('forgetSession')) {
    function forgetSession(){
        if(session()->has('user_answer.question')) {
            session()->forget('user_answer.question');
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
      }
}