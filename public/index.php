<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

require '../config.php';
require SYS_PATH . 'autoload.php';

// Initialize
$core = new Core;
$core->run();

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo $total_time.' s';