<?php
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
class Myfriend_Module extends Legacy_ModuleAdapter
{

    public function __construct($xoopsModule)
    {
        parent::__construct($xoopsModule);
    }

  public function hasAdminIndex()
  {
    return true;
  }

    public function getAdminIndex()
  {
    return XOOPS_MODULE_URL.'/'.$this->mXoopsModule->get('dirname').'/admin/index.php';
  }

    public function getAdminMenu()
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
