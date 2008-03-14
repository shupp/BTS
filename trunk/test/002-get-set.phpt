--TEST--
__construct()
--FILE--
<?php

$test = 'test';
require_once 'BTS2.php';
$bts = new BTS2;
$bts->test = $test;
var_dump($bts->test == $test);
var_dump($bts->bogus == null);
?>
--EXPECT--
bool(true)
bool(true)
