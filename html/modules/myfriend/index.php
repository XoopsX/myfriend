<?php
require '../../mainfile.php';
define ('_MY_DIRNAME', basename(dirname(__FILE__)));
define ('_MY_MODULE_PATH', XOOPS_MODULE_PATH.'/'._MY_DIRNAME.'/');
define ('_MY_MODULE_URL', XOOPS_MODULE_URL.'/'._MY_DIRNAME.'/');
$classname = _MY_DIRNAME;
require _MY_MODULE_PATH.'class/'._MY_DIRNAME.'.class.php';

$root = XCube_Root::getSingleton();
$root->mController->executeHeader();

$mymodule = new $classname();
$root->mController->mExecute->add(array(&$mymodule, 'execute'));
$root->mController->execute();

define('XOOPS_FOOTER_INCLUDED',1);
$root->mController->executeView();
?>
