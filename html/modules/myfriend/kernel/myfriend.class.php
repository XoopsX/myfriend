<?php
class MyfriendFunction
{
  function userinfo()
  {
    $root = XCube_Root::getSingleton();
    $root->mController->executeHeader();
    
    $root->mController->setupModuleContext('user');
    $root->mLanguageManager->loadModuleMessageCatalog('user');
    $root->mLanguageManager->loadModuleMessageCatalog('myfriend');
    
    $moduleRunner = new MyfriendFunction();

    $root->mController->mExecute->add(array(&$moduleRunner, 'execute'));
    $root->mController->execute();
    $root->mController->executeView();
    exit;
  }
  
  function execute($controller)
  {
    $fileName = XOOPS_MODULE_PATH.'/myfriend/actions/UserInfoAction.class.php';
    require $fileName;

    $Action = new Myfriend_UserInfoAction($controller);
    if ( $Action->getisError() ) {
      $controller->executeRedirect(XOOPS_URL.'/', 2, $Action->geterrMsg());
    } else {
      $Action->executeView($controller->mRoot->mContext->mModule->getRenderTarget());
    }
  }
}
?>
