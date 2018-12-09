<?php
if (!function_exists('rahul')) {
    function rahul()
    {
     return 'rahul';
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