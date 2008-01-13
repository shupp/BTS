<?php
require('BTS.php');
$tpl = new BTS;

$tpl->assign('title', 'Welcome to my web site');
$tpl->display('tpl1.tpl');
?>
