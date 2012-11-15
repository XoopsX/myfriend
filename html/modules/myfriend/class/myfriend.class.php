<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require _MY_MODULE_PATH.'class/AbstractAction.class.php';

class myfriend
{
  var $act;
  
  function myfriend()
  {
    $root = XCube_Root::getSingleton();
    $this->act = $root->mContext->mRequest->getRequest('action');
    if ( !is_object($root->mContext->mXoopsUser) ) {
      if ( $this->act != 'register' ) {
        $this->act = 'regist';
      }
    }
    if ( $this->act == "" ) {
      $this->act = 'index';
    }
    if (!preg_match("/^\w+$/", $this->act)) {
      exit('bad action name');
    }
  }
  
  function execute($controller)
  {
    $className = $this->act.'Action';
    $fileName = _MY_MODULE_PATH.'actions/'.$className.'.class.php';
    if (!file_exists($fileName)) {
      exit('file not found');
    }
    require $fileName;
    $Action = new $className($controller);
    if ( $Action->getisError() ) {
      $controller->executeRedirect($Action->getUrl(), 2, $Action->geterrMsg());
    } else {
      $Action->executeView($controller->mRoot->mContext->mModule->getRenderTarget());
    }
  }
}
?>