<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class searchAction extends Myfriend_Abstract
{
  var $mActionform;

  var $listdata;
  var $mPagenavi = null;
  var $root;
  var $mService;

  function __construct()
  {
    $this->root = XCube_Root::getSingleton();
    $this->mService = $this->root->mServiceManager->getService('UserSearch');
    $this->execute();
  }

  function getData($request)
  {
    $client = $this->root->mServiceManager->createClient($this->mService);
    $this->listdata = $client->call('getUserList', $request);
  }

  function execute()
  {
    if ( $this->mService == null ) {
      $this->setErr('Service Not loaded.');
      return;
    }
    $this->root->mLanguageManager->loadModuleMessageCatalog('usersearch');
    require_once XOOPS_MODULE_PATH.'/usersearch/forms/UsersearchForm.class.php';

    $this->mActionform = new UsersearchForm();
    $this->mActionform->prepare();

    $this->mActionform->fetch();
    if ( $this->mActionform->get('dosearch') == 1 ) {
      $this->mActionform->validate();
      if ($this->mActionform->hasError()) {
        $this->setErr($this->mActionform->getErrorMessages());
        return;
      }
      $request = array(
        'uname' => $this->mActionform->get('uname'),
        'stype' => $this->mActionform->get('searchtype'),
        'page'  => 12,
        'url'   => 'index.php?action=search'
      );
      $this->getData($request);
    } else {
      $this->mActionform->set('searchtype', 0);
    }
  }

  function executeView(&$render)
  {
    $render->setTemplateName('myfriend_usersearch.html');
    $render->setAttribute('mActionform', $this->mActionform);
    $render->setAttribute('listdata', $this->listdata);
  }
}
