--TEST--
__construct()
--FILE--
<?php

$templateDir = 'dir';
$phpself     = '/somepath.php';

$_SERVER['PHP_SELF'] = $phpself;

require_once 'BTS2.php';
class Test extends BTS2 {
    public function getTemplateDir()
    {
        return $this->templateDir;
    }
}

$bts = new Test($templateDir);
var_dump($bts->getTemplateDir() == $templateDir);
var_dump($bts->php_self == $phpself);

?>
--EXPECT--
bool(true)
bool(true)
