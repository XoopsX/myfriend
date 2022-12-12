<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class MyFriendInvitationObject extends XoopsSimpleObject
{
    function __construct()
    {
        $this->initVar('id', XOBJ_DTYPE_INT, '0', true);
        $this->initVar('uid', XOBJ_DTYPE_INT, '0', true);
        $this->initVar('email', XOBJ_DTYPE_STRING, '', true);
        $this->initVar('actkey', XOBJ_DTYPE_STRING, '', true);
        $this->initVar('utime', XOBJ_DTYPE_INT, '0', true);
    }
}

class MyFriendInvitationHandler extends XoopsObjectGenericHandler
{
    var $mTable = 'myfriend_invitation';
    var $mPrimary = 'id';
    var $mClass = 'MyFriendInvitationObject';

    function __construct(&$db)
    {
// parent::XoopsObjectGenericHandler($db);
        parent::__construct($db);
    }

    function oldDataDelete($d = 30)
    {
        $d = (int)$d;
        if ($d < 0) {
            $d = 30;
        }
        $time = time() - 86400 * $d;
        $sql = "DELETE FROM `" . $this->mTable . "` ";
        $sql .= "WHERE utime < " . $time;
        $result = $this->db->queryF($sql);
    }
}
