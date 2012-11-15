<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
class Myfriend_Module extends Legacy_ModuleAdapter
{
  function Myfriend_Module(&$xoopsModule)
  {
    parent::Legacy_ModuleAdapter($xoopsModule);
  }
  
  function hasAdminIndex()
  {
    return true;
  }
  
  function getAdminIndex()
  {
    return XOOPS_MODULE_URL.'/'.$this->mXoopsModule->get('dirname').'/admin/index.php';
  }
  
  function getAdminMenu()
  {
    if ($this->_mAdminMenuLoadedFlag) {
      return $this->mAdminMenu;
    }
    $root = XCube_Root::getSingleton();
    $this->mAdminMenu[] = array(
      'link' => $root->mController->getPreferenceEditUrl($this->mXoopsModule),
      'title' => _PREFERENCES,
      'show' => true
    );
    $this->_mAdminMenuLoadedFlag = true;
    return $this->mAdminMenu;
  }
}
?>