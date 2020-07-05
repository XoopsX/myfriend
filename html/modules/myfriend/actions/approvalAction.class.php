<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

class approvalAction extends Myfriend_Abstract
{
  var $tplname;
  var $modObj;
  var $auser;

  function __construct()
  {
    $root = XCube_Root::getSingleton();
    $id = (int)$root->mContext->mRequest->getRequest('id');
    $uid = $root->mContext->mXoopsUser->get('uid');

    $modHand = xoops_getmodulehandler('application');
    $this->modObj = $modHand->get($id);
    if ( !is_object($this->modObj) ) {
      $this->setErr(_MD_MYFRIEND_ACTERR13);
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $denial = (int)$root->mContext->mRequest->getRequest('Denial');
      $msg = $root->mContext->mRequest->getRequest('note');
      if ( $denial == 0 ) {
        $this->errMsg = _MD_MYFRIEND_ACTERR14;
      } else {
        $this->errMsg = _MD_MYFRIEND_ACTERR15;
      }
      if ( $msg !== "" ) {
        $pmHandler = xoops_gethandler('privmessage');
        $pmobj = $pmHandler->create();

        $pmobj->set('subject', $this->errMsg);
        $pmobj->set('from_userid', $uid);
        $pmobj->set('to_userid', $this->modObj->get('auid'));
        $pmobj->set('msg_time', time());
        $pmobj->set('msg_text', $msg);
        $pmHandler->insert($pmobj);
      }
      if ( $denial == 0 ) {
        $frihand = xoops_getmodulehandler('friend');
        $friObj = $frihand->create();
        $friObj->set('uid', $uid);
        $friObj->set('friend_uid', $this->modObj->get('auid'));
        $friObj->set('utime', time());
        if ( $frihand->insert($friObj) ) {
          $friObj = $frihand->create();
          $friObj->set('uid', $this->modObj->get('auid'));
          $friObj->set('friend_uid', $uid);
          $friObj->set('utime', time());
          if ( !$frihand->insert($friObj) ) {
            $this->errMsg = _MD_MYFRIEND_ACTERR3;
          }
        } else {
          $this->errMsg = _MD_MYFRIEND_ACTERR3;
        }
      }
      $modHand->delete($this->modObj);
      $this->isError = true;
      return;
    }

    $userHand = xoops_gethandler('user');
    $this->auser = $userHand->get($this->modObj->get('auid'));

    $this->tplname = 'myfriend_approval.html';
  }

  function executeView(&$render)
  {
    $render->setTemplateName($this->tplname);
    $render->setAttribute('modObj', $this->modObj);
    $render->setAttribute('auser', $this->auser);
    $render->setAttribute('titlemsg', XCube_Utils::formatString(_MD_MYFRIEND_FROM_APP, $this->auser->getShow('uname')));
  }
}
