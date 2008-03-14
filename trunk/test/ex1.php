<?php
require_once 'BTS2.php';
$tpl = new BTS2('../examples/templates');;

$tpl->assign('title', 'Welcome to my web site');
$tpl->display('tpl1.tpl');
?>
