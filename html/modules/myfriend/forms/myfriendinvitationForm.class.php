<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
require_once XOOPS_ROOT_PATH . '/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH . '/legacy/class/Legacy_Validator.class.php';

class Myfriendinvitation_Form extends XCube_ActionForm
{
    var $actkey;

    function __construct()
    {
// parent::XCube_ActionForm(); //
        parent::__construct();
    }

    function validateEmail()
    {
         if (strlen($this->get('email')) > 0) { //if ($this->get('email') !== '') {
            $modhand = xoops_getmodulehandler('invitation');
            $criteria = new CriteriaCompo(new Criteria('email', $this->get('email')));
            if ($modhand->getCount($criteria) > 0) {
                $this->addErrorMessage(_MD_MYFRIEND_FORMERR1);
            }

            $userHandler = xoops_gethandler('user');
            $criteria = new CriteriaCompo(new Criteria('email', $this->get('email')));
            if ($userHandler->getCount($criteria) > 0) {
                $this->addErrorMessage(_MD_MYFRIEND_FORMERR2);
            }
        }
    }

    function getTokenName()
    {
        return 'module.myfriend.invitation.TOKEN';
    }

    function prepare()
    {
        $this->mFormProperties['email'] = new XCube_StringProperty('email');
        $this->mFormProperties['note'] = new XCube_TextProperty('note');

        $this->mFieldProperties['email'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['email']->setDependsByArray(array('required', 'email'));
        $this->mFieldProperties['email']->addMessage('required', _MD_MYFRIEND_FORMERR3);
        $this->mFieldProperties['email']->addMessage('email', _MD_MYFRIEND_FORMERR4);

        $this->mFieldProperties['note'] = new XCube_FieldProperty($this);
    }

    function set_session()
    {
        $_SESSION['MYFRIEND']['email'] = $this->get('email');
        $_SESSION['MYFRIEND']['note'] = $this->get('note');
    }

    function del_session()
    {
        $_SESSION['MYFRIEND'] = null;
        unset($_SESSION['MYFRIEND']);
    }

    function get_session($key)
    {
        if (isset($_SESSION['MYFRIEND'][$key])) {
            return $_SESSION['MYFRIEND'][$key];
        }
    }

    function update(&$obj)
    {
        $root = XCube_Root::getSingleton();
        $uid = $root->mContext->mXoopsUser->get('uid');

        $obj->set('uid', $uid);
        $obj->set('email', $this->get_session('email'));
        $obj->set('actkey', $this->get_actkey());
        $obj->set('utime', time());
    }

    function get_actkey()
    {
        if ($this->actkey == "") {
            $ip = str_pad(str_replace('.', '', $_SERVER['REMOTE_ADDR']), 12, '0');
            $fcry = uniqid(rand());
            $ymd = date('ymd');
            $this->actkey = substr(sha1($ymd . $ip . $fcry), 0, 20);
        }
        return $this->actkey;
    }
}
