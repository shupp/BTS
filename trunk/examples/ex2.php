<?php

$name_array = array('first' => 'bill', 'last' => 'shupp');

require_once 'BTS2.php';
$tpl = new BTS2;

$tpl->assign('title', 'Welcome to my web site');
$tpl->assign('name', $name_array);
$tpl->display('tpl2.tpl');
?>
