<?php

$names_array[0] = array('first' => 'John', 'last' => 'Parker');
$names_array[1] = array('first' => 'Matt', 'last' => 'Timmons');
$names_array[2] = array('first' => 'Joe', 'last' => 'Shmoe');
$names_array[3] = array('first' => 'Fred', 'last' => 'Hamilton');

require_once 'BTS.php';
$tpl = new BTS;

$tpl->assign('title', "Here's a List of names, with cycling tr bgcolors:");
$tpl->assign('names', $names_array);
$out = $tpl->display('tpl3.tpl', 1);
echo $out;
?>
