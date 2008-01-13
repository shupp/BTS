<?php

$names_array[0] = 'bill';
$names_array[1] = 'shupp';
$names_array[2] = 'bob';
$names_array[3] = 'jones';

require('BTS.php');
$tpl = new BTS;

$tpl->assign('title', "Here's a List of names, with cycling tr bgcolors:");
$tpl->assign('names', $names_array);
$tpl->assign('name_selected', 'shupp');
$out = $tpl->display('tpl4.tpl', 1);
echo $out;
?>
