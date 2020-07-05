<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require _MY_MODULE_PATH.'forms/myfriendapplicationForm.class.php';

class applicationAction extends Myfriend_Abstract
{
  var $tplname;
  var $auser;

  function __construct()
  {
    $root = XCube_Root::getSingleton();
    $auid = (int)$root->mContext->mRequest->getRequest('auid');
    $uid = $root->mContext->mXoopsUser->get('uid');
    $this->mActionForm = new Myfriendapplication_Form();
    $this->mActionForm->prepare();

    $handler = xoops_gethandler('user');
    $this->auser = $handler->get($auid);
    if ( !is_object($this->auser) ) {
      $this->setErr(_MD_MYFRIEND_ACTERR7);
      return;
    }
    $this->mActionForm->load($auid);
    if ( $this->chk_application($uid, $auid) ) {
      $this->setErr(_MD_MYFRIEND_ACTERR8);
      return;
    }

    if ( $this->chk_myfriend($uid, $auid) ) {
      $this->setErr(_MD_MYFRIEND_ACTERR9);
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->mActionForm->fetch();
      $this->mActionForm->validate();
      if ($this->mActionForm->hasError()) {
        $this->setErr(implode('<br />',$this->mActionForm->getErrorMessages()));
        return;
      }
      $ahandler = xoops_getmodulehandler('application');
      $modObj = $ahandler->create();
      $this->mActionForm->update($modObj);
      $this->isError = true;
      if ( !$ahandler->insert($modObj) ) {
        $this->errMsg = _MD_MYFRIEND_ACTERR10;
      } else {
        $this->errMsg = _MD_MYFRIEND_ACTERR11;
      }
    } else {
      $this->tplname = 'myfriend_application.html';
    }
  }

  function chk_application($uid, $auid)
  {
    $mCriteria = new CriteriaCompo();
    $mCriteria->add(new Criteria('uid', $uid));
    $mCriteria->add(new Criteria('auid', $auid));
    $ahandler = xoops_getmodulehandler('application');
    return $ahandler->getCount($mCriteria);
  }

  function chk_myfriend($uid, $auid)
  {
    $num = 0;
    $root = XCube_Root::getSingleton();
    $db = $root->mController->mDB;
    $sql = "SELECT COUNT(*) FROM `".$db->prefix('myfriend_friendlist')."` ";
    $sql.= "WHERE `uid` = ".$uid;
    $sql.= " AND `friend_uid` = ".$auid;
    $result = $db->query($sql);
    [$num] = $db->fetchRow($result);
    return $num;
  }

  function executeView(&$render)
  {
    $render->setTemplateName($this->tplname);
    $render->setAttribute('ActionForm', $this->mActionForm);
    $render->setAttribute('auser', $this->auser);
    $render->setAttribute('titlemsg', XCube_Utils::formatString(_MD_MYFRIEND_APP, $this->auser->getShow('uname')));
  }
}
