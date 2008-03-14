<?php

$names_array[0] = 'bill';
$names_array[1] = 'david';
$names_array[2] = 'bob';
$names_array[3] = 'steve';
$names_array[4] = 'mike';

require_once 'BTS2.php';
$tpl = new BTS2;

$tpl->assign('title', "Here's a List of names, with cycling tr bgcolors:");
$tpl->assign('names', $names_array);
$tpl->assign('name_selected', 'steve');
$out = $tpl->display('tpl4.tpl', 1);
echo $out;
?>
