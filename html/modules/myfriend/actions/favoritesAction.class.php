<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

class favoritesAction extends Myfriend_Abstract
{
  var $mService;
  var $favorites;
  var $root;
  
  function favoritesAction()
  {
    $this->root = XCube_Root::getSingleton();
    $this->mService = $this->root->mServiceManager->getService('UserSearch');
    $this->setUrl('index.php?action=favorites');
    $this->execute();
  }
  
  function addFavorites()
  {
    $adduid = $this->root->mContext->mRequest->getRequest('adduid');
    if ( !is_array($adduid) || count($adduid) == 0 ) {
      $this->errMsg = _MD_USERSEARCH_FAVORITES0;
      return;
    }
    $mid = $this->root->mContext->mXoopsModule->get('mid');
    $client = $this->root->mServiceManager->createClient($this->mService);
    foreach ( $adduid as $fuid ) {
      $ret[] = $client->call('addFavorites', array('mid' => $mid, 'fuid' => $fuid, 'weight' => 0));
    }
    if ( in_array(false, $ret) ) {
      $this->errMsg = _MD_USERSEARCH_FAVORITES1;
    } else {
      $this->errMsg = _MD_USERSEARCH_FAVORITES2;
    }
  }
  
  function edtFavorites()
  {
    $weight = $this->root->mContext->mRequest->getRequest('weight');
    if ( !is_array($weight) || count($weight) == 0 ) {
      return true;
    }
    $client = $this->root->mServiceManager->createClient($this->mService);
    foreach ( $weight as $id => $w ) {
      $ret[] = $client->call('edtFavorites', array('id' => $id, 'weight' => $w));
    }
    if ( in_array(false, $ret) ) {
      $this->errMsg = _MD_USERSEARCH_FAVORITES3;
      return false;
    } else {
      $this->errMsg = _MD_USERSEARCH_FAVORITES4;
    }
    return true;
  }
  
  function delFavorites()
  {
    $delid = $this->root->mContext->mRequest->getRequest('delid');
    if ( !is_array($delid) || count($delid) == 0 ) {
      return;
    }
    $client = $this->root->mServiceManager->createClient($this->mService);
    foreach ( $delid as $id ) {
      $ret[] = $client->call('delFavorites', array('id' => $id));
    }
    if ( in_array(false, $ret) ) {
      $this->errMsg = _MD_USERSEARCH_FAVORITES4;
    } else {
      $this->errMsg = _MD_USERSEARCH_FAVORITES5;
    }
  }
  
  function getFavorites()
  {
    $mid = $this->root->mContext->mXoopsModule->get('mid');
    $client = $this->root->mServiceManager->createClient($this->mService);
    $this->favorites = $client->call('getFavoritesUsers', array('mid' => $mid));
  }
  
  function execute()
  {
    if ( $this->mService == null ) {
      $this->setErr('Service Not loaded.');
      return;
    }
    
    $this->root->mLanguageManager->loadModuleMessageCatalog('usersearch');
    $cmd = $this->root->mContext->mRequest->getRequest('cmd');
    if ( $cmd == "" ) {
      $this->getFavorites();
    } else {
      $this->isError = true;
      switch ($cmd) {
        case 'add':
          $this->addFavorites();
          break;
        case 'edt':
          if ( $this->edtFavorites() ) {
            $this->delFavorites();
          }
          break;
      }
    }
  }
  
  function executeView(&$render)
  {
    $render->setTemplateName('myfriend_favorites.html');
    $render->setAttribute('fuser', $this->favorites);
    //$render->setAttribute('listdata', $this->listdata);
  }
}
?>