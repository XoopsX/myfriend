<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class MyfriendFriendObject extends XoopsSimpleObject
{
    function __construct()
    {
        $this->initVar('uid', XOBJ_DTYPE_INT, '0', true);
        $this->initVar('friend_uid', XOBJ_DTYPE_INT, '0', true);
        $this->initVar('utime', XOBJ_DTYPE_INT, time(), true);
    }
}

class MyfriendFriendHandler extends XoopsObjectGenericHandler
{
    var $mTable = 'myfriend_friendlist';
    //var $mPrimary = array('uid','friend_id');
    var $mClass = 'MyfriendFriendObject';

    function __construct(&$db)
    {
        parent::__construct($db);
    }
}

