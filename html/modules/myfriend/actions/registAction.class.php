<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require _MY_MODULE_PATH.'forms/myfriendregisterForm.class.php';

class registAction extends Myfriend_Abstract
{
  var $tplname;
  var $rdata = false;

  function __construct()
  {
    $root = XCube_Root::getSingleton();
    if ( is_object($root->mContext->mXoopsUser) ) {
      $this->setErr(_MD_MYFRIEND_ACTERR1);
      return;
    }
    $actkey = $root->mContext->mRequest->getRequest('actkey');
    $modhand = xoops_getmodulehandler('invitation');
    $mCriteria = new CriteriaCompo();
    $mCriteria->add(new Criteria('actkey', $actkey));
    $modObj = $modhand->getObjects($mCriteria);
    if ( count($modObj) == 1 ) {
      $this->tplname ='myfriend_invitation_regist.html';
      $root->mController->setupModuleContext('user');
      $root->mLanguageManager->loadModuleMessageCatalog('user');

      $this->_processActionForm();
      $this->mActionForm->set('timezone_offset', $root->mContext->getXoopsConfig('default_TZ'));
      $this->mActionForm->set('actkey', $actkey);
      $this->mActionForm->delete_session();
      if  (xoops_getenv("REQUEST_METHOD") == "POST") {
        $this->mActionForm->fetch();
        $this->mActionForm->validate();
        if (!$this->mActionForm->hasError()) {
          $this->tplname ='myfriend_invitation_regisconft.html';
          $this->mActionForm->save_session();
        }
      }
    } else {
      $this->tplname ='myfriend_invitation_none.html';
    }
  }
  //http://localhost/21b3/modules/myfriend/index.php?action=regist&actkey=3e16af2cfc

  function _processActionForm()
  {
    $moduleHandler = xoops_gethandler('module');
    $usermod = $moduleHandler->getByDirname('user');
    $configHandler = xoops_gethandler('config');
    $configs = $configHandler->getConfigsByCat(0, $usermod->get('mid'));

    $this->mActionForm = new myfreendRegisterForm($configs);
    $this->mActionForm->prepare();
  }

  function executeView(&$render)
  {
    $render->setTemplateName($this->tplname);
    $render->setAttribute('rdata', $this->rdata);
    $render->setAttribute('actionForm', $this->mActionForm);
    $tzoneHandler = xoops_gethandler('timezone');
    $timezones = $tzoneHandler->getObjects();
    $render->setAttribute('timezones', $timezones);
  }
}

