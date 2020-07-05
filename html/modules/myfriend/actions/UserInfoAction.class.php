<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

define ('USER_USERINFO_MAXHIT', 5);

class Myfriend_UserInfoAction
{
  var $mObject = null;
  var $mRankObject = null;
  var $mSearchResults = null;

  var $mSelfDelete = false;

  var $mPmliteURL = null;

  var $errFlg = false;
  var $errMsg;
  var $fuid;

  function __construct(&$controller)
  {
    $user = $controller->mRoot->mContext->mUser;
    if ($user->isInRole('Site.GuestUser')) {
      $this->_seterrMsg(_MD_MYFRIEND_NOGUEST);
    } else {
      $this->getDefaultView($controller);
    }
  }

  function _seterrMsg($msg)
  {
    $this->errFlg = true;
    $this->errMsg[] = $msg;
  }

  function getisError()
  {
    return $this->errFlg;
  }

  function geterrMsg()
  {
    return $this->errMsg;
  }

  function getDefaultView(&$controller)
  {
    $root = $controller->mRoot;
    $xoopsUser = $root->mContext->mXoopsUser;
    $this->fuid = (int)$controller->mRoot->mContext->mRequest->getRequest('uid');
    $handler = xoops_gethandler('user');
    $this->mObject = $handler->get($this->fuid);
    if (!is_object($this->mObject)) {
      $this->_seterrMsg(_MD_MYFRIEND_NOUSER);
      return;
    }

    $rankHandler = xoops_getmodulehandler('ranks', 'user');
    $this->mRankObject = $rankHandler->get($this->mObject->get('rank'));

    $service = $root->mServiceManager->getService('privateMessage');
    if ($service !== null) {
      $client = $root->mServiceManager->createClient($service);
      $this->mPmliteURL = $client->call('getPmliteUrl', array('fromUid' => $xoopsUser->get('uid'), 'toUid' => $this->fuid));
    }
    unset($service);

    $service = $root->mServiceManager->getService("LegacySearch");
    if ($service !== null) {
      $this->mSearchResults = array();

      $client = $root->mServiceManager->createClient($service);

      $moduleArr = $client->call('getActiveModules', array());

      foreach ($moduleArr as $t_module) {
        $module = array();
        $module['name'] = $t_module['name'];
        $module['mid'] = $t_module['mid'];

        $params['mid'] = $t_module['mid'];
        $params['uid'] = $this->mObject->get('uid');
        $params['maxhit'] = USER_USERINFO_MAXHIT;
        $params['start'] = 0;

        $module['results'] = $client->call('searchItemsOfUser', $params);

        if (count($module['results']) > 0) {
          $module['has_more'] = count($module['results']) >= USER_USERINFO_MAXHIT;
          $this->mSearchResults[] = $module;
        }
      }
    }
  }

  function executeView(&$render)
  {
    $render->setTemplateName('myfriend_userinfo.html');
    $render->setAttribute('thisUser', $this->mObject);
    $render->setAttribute('rank', $this->mRankObject);
    $render->setAttribute('pmliteUrl', $this->mPmliteURL);
    $render->setAttribute('isFriend', $this->chk_myfriend());

    $userSignature = $this->mObject->getShow('user_sig');

    $render->setAttribute('user_signature', $userSignature);
    $render->setAttribute('searchResults', $this->mSearchResults);

    $root = XCube_Root::getSingleton();
    $xoopsUser = $root->mContext->mXoopsUser;

    $user_ownpage = (is_object($xoopsUser) && $xoopsUser->get('uid') == $this->mObject->get('uid'));
    $render->setAttribute('user_ownpage', $user_ownpage);

    $handler = xoops_gethandler('config');
    $uconfig = $handler->getConfigsByDirname('user');
    if ( $user_ownpage && $uconfig['self_delete'] ) {
      $render->setAttribute('enableSelfDelete', true);
    } else {
      $render->setAttribute('enableSelfDelete', false);
    }

    $render->setAttribute('myfriends', $this->get_myfreindlist());
  }

  function get_myfreindlist()
  {
    $freiends = false;
    $root = XCube_Root::getSingleton();
    $db = $root->mController->mDB;
    $sql = "SELECT u.`uid`, u.`uname`, u.`user_avatar` avatar ";
    $sql.= "FROM `".$db->prefix('users')."` u, `".$db->prefix('myfriend_friendlist')."` m ";
    $sql.= "WHERE m.`uid` = ".$this->fuid." ";
    $sql.= "AND u.`uid` = m.`friend_uid` ";
    $sql.= "ORDER BY m.`uid`, rand() ";
    $sql.= "LIMIT 0, 9";
    $result = $db->query($sql);
    while ($val = $db->fetchArray($result)) {
      $freiends[] = $val;
    }
    return $freiends;
  }

  function chk_myfriend()
  {
    $num = 0;
    $root = XCube_Root::getSingleton();
    $db = $root->mController->mDB;
    $sql = "SELECT COUNT(*) FROM `".$db->prefix('myfriend_friendlist')."` ";
    $sql.= "WHERE `uid` = ".$root->mContext->mXoopsUser->get('uid');
    $sql.= " AND `friend_uid` = ".$this->fuid;
    $result = $db->query($sql);
    [$num] = $db->fetchRow($result);
    return $num;
  }
}

