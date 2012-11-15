<?php
require_once '../../../mainfile.php';
$root = XCube_Root::getSingleton();
$root->mController->executeHeader();


$xoopsLogger = $root->mController->getLogger();
$xoopsLogger->stopTime();
$root->mController->executeView();
?>