<?php

$tsBefore = microtime(true) * 1000;

require_once('autoload.php');

$app = new \base\Application();

$app->start();

$tsAfter = microtime(true) * 1000;

$timePassed = $tsAfter - $tsBefore;

echo 'Time passed: ' . round($timePassed, 1) . 'ms';