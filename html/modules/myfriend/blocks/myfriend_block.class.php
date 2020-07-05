<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class Myfriend_Block extends Legacy_BlockProcedure
{
    public $options = array();
    public $myfriendDelegate;
    public $mNewAlert = array();

    public function __construct(&$block)
    {
        parent::__construct($block);
    }


    public function prepare()
    {
        $root = XCube_Root::getSingleton();
        if ($root->mContext->mUser->isInRole('Site.RegisteredUser')) {
            $root->mLanguageManager->loadModinfoMessageCatalog(basename(dirname(__FILE__, 2)));
            $this->myfriendDelegate = new XCube_Delegate;
            $this->myfriendDelegate->add(array(&$this, 'getMyfriendNew'));
            $this->myfriendDelegate->register('Myfriend.NewAlert');
            $this->myfriendDelegate->call(new XCube_Ref($this->mNewAlert));
        }
    }

    public function getMyfriendNew(&$arrays)
    {
        $root = XCube_Root::getSingleton();
        if ($root->mContext->mUser->isInRole('Site.RegisteredUser')) {
            $root->mLanguageManager->loadModuleMessageCatalog('myfriend');
            $uid = $root->mContext->mXoopsUser->get('uid');
            $modHand = xoops_getmodulehandler('application', 'myfriend');

            $mCriteria = new CriteriaCompo();
            $mCriteria->add(new Criteria('uid', $uid));
            $modObj = $modHand->getObjects($mCriteria);
            foreach ($modObj as $obj) {
                $arrays[] = array(
                    'url' => XOOPS_MODULE_URL . '/myfriend/index.php?action=approval&amp;id=' . $obj->get('id'),
                    'title' => _MD_MYFRIEND_NEW
                );
            }
        }
    }

    public function getTitle()
    {
        return _MI_MYFRIEND_BLOCK_NAME;
    }

    function isDisplay()
    {
        return count($this->mNewAlert) > 0;
    }

    public function execute()
    {
        $render =& $this->getRenderTarget();
        $render->setTemplateName($this->_mBlock->get('template'));
        $render->setAttribute('mid', $this->_mBlock->get('mid'));
        $render->setAttribute('bid', $this->_mBlock->get('bid'));
        $render->setAttribute('block', $this->mNewAlert);

        $root = XCube_Root::getSingleton();
        $renderSystem =& $root->getRenderSystem($this->getRenderSystemName());
        $renderSystem->renderBlock($render);
    }
}
