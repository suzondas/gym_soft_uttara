<?php
header("Content-Type:text/json");

$ts = new stdClass();
$ts->PIN = 2;
$ts->DateTime = '02/03/2019';
$t = array($ts);
echo json_encode($t);
?>