<?php

$name_array = array('first' => 'bill', 'last' => 'shupp');

require('BTS.php');
$tpl = new BTS;

$tpl->assign('title', 'Welcome to my web site');
$tpl->assign('name', $name_array);
$tpl->display('tpl2.tpl');
?>
