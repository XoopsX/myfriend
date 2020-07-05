<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require _MY_MODULE_PATH.'forms/myfriendPageNavi.class.php';

define('_MYFRIEND_PAGENUM', 10);

class indexAction extends Myfriend_Abstract
{
  var $listuser;
  var $mPagenavi = null;
  var $listinvi;

  function __construct()
  {
    $root = XCube_Root::getSingleton();
    $uid = $root->mContext->mXoopsUser->getVar('uid');

    $modhand = xoops_getmodulehandler('friend');
    $this->mPagenavi = new Myfriend_PageNavi($modhand);
    $this->mPagenavi->addCriteria('uid',$uid);
    $this->mPagenavi->fetch();
    $modObj = $modhand->getObjects($this->mPagenavi->getCriteria());

    $userhand = xoops_gethandler('user');
    foreach ($modObj as $mod) {
      $this->listuser[] = $userhand->get($mod->getShow('friend_uid'));
    }

    $modhand = xoops_getmodulehandler('invitation');
    $modhand->oldDataDelete($root->mContext->mModuleConfig['deletedays']);
    $mCriteria = new CriteriaCompo();
    $mCriteria->add(new Criteria('uid', $uid));
    $modObj = $modhand->getObjects($mCriteria);

    foreach ($modObj as $mod) {
      foreach ( array_keys($mod->gets()) as $var_name ) {
        $item_ary[$var_name] = $mod->getShow($var_name);
      }
      $item_ary['formattedDate'] = formatTimestamp($item_ary['utime']);
      $this->listinvi[] = $item_ary;
    }
  }

  function executeView(&$render)
  {
    $render->setTemplateName('myfriend_index.html');
    $render->setAttribute('ListData', $this->listuser);
    $render->setAttribute('pageNavi', $this->mPagenavi->mNavi);
    $render->setAttribute('invidata', $this->listinvi);
  }
}
