<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class MyFriendApplicationObject extends XoopsSimpleObject
{
  function __construct()
  {
    $this->initVar('id', XOBJ_DTYPE_INT, '0', true);
    $this->initVar('uid', XOBJ_DTYPE_INT, '0', true);
    $this->initVar('auid', XOBJ_DTYPE_INT, '', true);
    $this->initVar('utime', XOBJ_DTYPE_INT, '0', true);
    $this->initVar('note', XOBJ_DTYPE_TEXT, '', true);
  }
}

class MyFriendApplicationHandler extends XoopsObjectGenericHandler
{
  public $mTable = 'myfriend_applist';
  public $mPrimary = 'id';
  public $mClass = 'MyFriendApplicationObject';
    public function __construct(&$db) {
  //public function MyFriendInvitationHandler(&$db) {
    parent::__construct($db);
  }
}
