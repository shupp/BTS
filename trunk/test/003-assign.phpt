--TEST--
__construct()
--FILE--
<?php

require_once 'BTS2.php';
$bts = new BTS2;
$bts->assign('test', 'test');
var_dump($bts->test == 'test');
?>
--EXPECT--
bool(true)
