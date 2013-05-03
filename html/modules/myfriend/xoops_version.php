<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
if ( !isset($root) ) {
  $root = XCube_Root::getSingleton();
}

$modversion['name'] = _MI_MYFRIEND_NAME;
$modversion['dirname'] = basename(dirname(__FILE__));
$modversion['version'] = 0.44;
$modversion['detailed_version'] = '0.44.0' ;
$modversion['description'] = _MI_MYFRIEND_NAME;
$modversion['author'] = 'Marijuana and XOOPS Cube distribution team';
$modversion['image'] = 'slogo.gif';
$modversion['mcl_update'] = 'myfriend';

$modversion['cube_style'] = true;
$modversion['read_any'] = true;

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][] = '{prefix}_{dirname}_friendlist';
$modversion['tables'][] = '{prefix}_{dirname}_invitation';
$modversion['tables'][] = '{prefix}_{dirname}_applist';

$modversion['hasAdmin'] = 1;

$modversion['hasMain'] = 1;
if ($root->mServiceManager->getService('UserSearch') != null ) {
  $modversion['sub'][] = array('name' => _MI_MYFRIEND_SUB_SEARCH, 'url' => 'index.php?action=search');
  $modversion['sub'][] = array('name' => _MI_MYFRIEND_SUB_FAVORITES, 'url' => 'index.php?action=favorites');
}

$modversion['templates'][] = array('file' => 'myfriend_index.html', 'description' => '');
$modversion['templates'][] = array('file' => 'myfriend_invitation.html', 'description' => '');
$modversion['templates'][] = array('file' => 'myfriend_invitation_confirm.html', 'description' => '');
$modversion['templates'][] = array('file' => 'myfriend_invitation_none.html', 'description' => '');
$modversion['templates'][] = array('file' => 'myfriend_invitation_regist.html', 'description' => '');
$modversion['templates'][] = array('file' => 'myfriend_invitation_regisconft.html', 'description' => '');
$modversion['templates'][] = array('file' => 'myfriend_userinfo.html', 'description' => '');
$modversion['templates'][] = array('file' => 'myfriend_application.html', 'description' => '');
$modversion['templates'][] = array('file' => 'myfriend_approval.html', 'description' => '');
$modversion['templates'][] = array('file' => 'myfriend_usersearch.html', 'description' => '');
$modversion['templates'][] = array('file' => 'myfriend_favorites.html', 'description' => '');

$modversion['blocks'][0]['file'] = 'myfriend_block.class.php';
$modversion['blocks'][0]['name'] = _MI_MYFRIEND_BLOCK_NAME;
$modversion['blocks'][0]['description'] = '';
$modversion['blocks'][0]['show_func'] = '';
$modversion['blocks'][0]['class'] = 'Block';
$modversion['blocks'][0]['template'] = 'myfriend_block_template.html';
$modversion['blocks'][0]['visible'] = '1';
$modversion['blocks'][0]['func_num'] = 1;

$modversion['config'][0]['name']        = 'in_group';
$modversion['config'][0]['title']       = '_MI_MYFRIEND_GROUP';
$modversion['config'][0]['description'] = '_MI_MYFRIEND_GROUP_DESC';
$modversion['config'][0]['formtype']    = 'group_multi';
$modversion['config'][0]['valuetype']   = 'array';
$modversion['config'][0]['default']     = array(XOOPS_GROUP_USERS);

$modversion['config'][1]['name']        = 'deletedays';
$modversion['config'][1]['title']       = '_MI_MYFRIEND_DELDAYS';
$modversion['config'][1]['description'] = '_MI_MYFRIEND_DELDAYS_DESC';
$modversion['config'][1]['formtype']    = 'textbox';
$modversion['config'][1]['valuetype']   = 'int';
$modversion['config'][1]['default']     = '30';
?>
