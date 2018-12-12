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