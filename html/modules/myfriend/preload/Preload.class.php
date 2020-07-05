<?php

if (!defined('XOOPS_ROOT_PATH')) {
    die();
}

class Myfriend_Preload extends XCube_ActionFilter
{
    function postFilter()
    {
        if ($this->mRoot->mContext->mUser->isInRole('Site.RegisteredUser')) {
            $file = XOOPS_ROOT_PATH . '/modules/myfriend/kernel/myfriend.class.php';
            $this->mRoot->mDelegateManager->add('Legacypage.Userinfo.Access', 'MyfriendFunction::userinfo', XCUBE_DELEGATE_PRIORITY_FIRST, $file);
        }

        $this->mRoot->mDelegateManager->add('Legacy.Event.UserDelete', 'Myfriend_Preload::userdel');
    }

    function userdel(&$obj)
    {
        $root = XCube_Root::getSingleton();
        $db = $root->mController->getDB();
        $sql = "DELETE FROM `" . $db->prefix('myfriend_friendlist') . "` ";
        $sql .= "WHERE `friend_uid` = " . $obj->get('uid') . " ";
        $sql .= "OR `uid` = " . $obj->get('uid');
        $db->queryF($sql);
    }
}
