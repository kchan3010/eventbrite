<?php
/**
 * Created by PhpStorm.
 * User: kennychan
 * Date: 1/27/17
 * Time: 12:41 PM
 */
date_default_timezone_set ( 'America/Los_Angeles' );

//Setting up script to take in inputs as aguments or stdin

array_shift($argv);
if (count($argv) == 0) {
    $argv = "php://stdin";
}

$cal_lines = explode("\n", file_get_contents($argv[0], "r"));
$proposed_lines = explode("\n", file_get_contents($argv[1], "r"));

if(empty($cal_lines) || empty($proposed_lines)) {

    throw new Exception("File cannot be empty");
}


//creating a map and to break up the data points into a sub-array
$cal_map = [];
foreach($cal_lines as $cal) {
    $cal_map[] = explode(",", $cal);
}

//for each proposed time we will perform a binary search
//if the proposed time falls between the beginning and end time
//then we found the event and return the string
foreach($proposed_lines as $proposed) {
    $i = 0;
    $front = 0;
    $end = count($cal_map) - 1;
    $proposed_time = strtotime($proposed);
    $proposed_time_msg = "Nothing";
    $found = false;

    while ($front <= $end && $found != true) {
        $mid = floor(($front + $end) / 2);

        if($proposed_time < strtotime($cal_map[$mid][0])) {
            $end = $mid - 1;
        }

        if($proposed_time > strtotime($cal_map[$mid][0]) && $proposed_time > strtotime($cal_map[$mid][1])) {
            $front = $mid + 1;
        }

        if($proposed_time >= strtotime($cal_map[$mid][0]) && $proposed_time <= strtotime($cal_map[$mid][1])) {
            $proposed_time_msg =  $cal_map[$mid][2];
            $found = true;
        }

    }

    echo $proposed . "," . $proposed_time_msg . "\n";

}