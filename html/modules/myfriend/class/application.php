<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
class MyFriendApplicationObject extends XoopsSimpleObject
{
  function MyFriendApplicationObject()
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
  var $mTable = 'myfriend_applist';
  var $mPrimary = 'id';
  var $mClass = 'MyFriendApplicationObject';

  function MyFriendInvitationHandler(&$db) {
    parent::XoopsObjectGenericHandler($db);
  }
}
?>