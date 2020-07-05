<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require _MY_MODULE_PATH.'forms/myfriendinvitationForm.class.php';

class invitationAction extends Myfriend_Abstract
{
  var $tplname;

  function __construct()
  {
    $this->mActionForm = new Myfriendinvitation_Form();
    $this->mActionForm->prepare();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $root = XCube_Root::getSingleton();
      if ( $root->mContext->mRequest->getRequest('cmd') == 'send' ) {
        $modhand = xoops_getmodulehandler('invitation');
        $modobj = $modhand->create();
        $this->mActionForm->update($modobj);
        if ( !$modhand->insert($modobj) ) {
          $this->setErr(_MD_MYFRIEND_ACTERR16);
          return;
        }

        $this->send_email();

        $root->mController->executeRedirect(_MY_MODULE_URL, 2, _MD_MYFRIEND_ACTERR17);
      } else {
        $this->mActionForm->del_session();
        $this->mActionForm->fetch();
        $this->mActionForm->validate();
        if ($this->mActionForm->hasError()) {
          $this->isError = true;
          $this->errMsg = implode('<br />',$this->mActionForm->getErrorMessages());
          return;
        }
        $this->mActionForm->set_session();
        $this->tplname = 'myfriend_invitation_confirm.html';
      }
    } else {
      $this->tplname = 'myfriend_invitation.html';
    }
  }

  function executeView(&$render)
  {
    $render->setTemplateName($this->tplname);
    $render->setAttribute('ActionForm', $this->mActionForm);
  }

  function send_email()
  {
    require_once XOOPS_ROOT_PATH.'/class/mail/phpmailer/class.phpmailer.php';
    require_once XOOPS_ROOT_PATH.'/modules/legacy/lib/Mailer/Mailer.php';

    $root = XCube_Root::getSingleton();
    $subject = XCube_Utils::formatString(_MD_MYFRIEND_ACTERR18, $root->mContext->mXoopsUser->get('uname'), $root->mContext->mXoopsConfig['sitename']);

    $tpl = new Smarty();
    $tpl->_canUpdateFromFile = true;
    $tpl->compile_check = true;
    $tpl->template_dir = _MY_MODULE_PATH.'language/'.$root->mLanguageManager->mLanguageName.'/';
    $tpl->cache_dir = XOOPS_CACHE_PATH;
    $tpl->compile_dir = XOOPS_COMPILE_PATH;

    $tpl->assign('sitename', $root->mContext->mXoopsConfig['sitename']);
    $tpl->assign('uname', $root->mContext->mXoopsUser->get('uname'));
    $tpl->assign('note', $this->mActionForm->get_session('note'));
    $tpl->assign('siteurl', XOOPS_URL.'/');
    $tpl->assign('registurl', _MY_MODULE_URL.'index.php?action=regist&actkey='.$this->mActionForm->get_actkey());
    $body = $tpl->fetch(_MY_MODULE_PATH.'language/'.$root->mLanguageManager->mLanguageName.'/invitation.tpl');

    $mailer = new Legacy_Mailer();
    $mailer->prepare();
    $mailer->setFrom($root->mContext->mXoopsConfig['adminmail']);
    $mailer->setFromname($root->mContext->mXoopsConfig['sitename']);
    $mailer->setTo($this->mActionForm->get_session('email'), "");
    $mailer->setSubject($subject);
    $mailer->setBody($body);
    $mailer->Send();
  }
}
