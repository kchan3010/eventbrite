<?php
/**
 * Created by PhpStorm.
 * User: kennychan
 * Date: 1/27/17
 * Time: 8:38 AM
 */


array_shift($argv);
if (count($argv) == 0) {
    $argv[0] = "php://stdin";
}

$lines = explode("\n", file_get_contents($argv[0], "r"));

if(empty($lines)) {

    throw new Exception("File cannot be empty");
}


$map = [];

foreach($lines as $line) {
    $data = explode("\t", $line);

    //something is wrong and continue
    if(empty($data)) {
        continue;
    }

    if (!isset($data[1]) || !isset($data[2])) {
        continue;
    }

    $rating = $data[1];
    $title = $data[2];

    $map[$rating][] = $title;

}

krsort($map);

$current_rank = 1;

foreach($map as $movie_list) {
    sort($movie_list);

    foreach($movie_list as $movie) {
        echo $current_rank . "\t" . $movie . "\n";
    }

    $current_rank = $current_rank + count($movie_list);
}