<?php
$root = XCube_Root::getSingleton();
if ($root->mContext->mUser->isInRole('Site.GuestUser')) {
  define('_MI_MYFRIEND_NAME', 'Registration with Invites');
} else {
  define('_MI_MYFRIEND_NAME', 'MyFriend');
}

define('_MI_MYFRIEND_GROUP', 'Users Group');
define('_MI_MYFRIEND_GROUP_DESC', 'Select the group to assign users who registered with an invitation.');

define('_MI_MYFRIEND_BLOCK_NAME', 'Newly arrived block');
define('_MI_MYFRIEND_SUB_SEARCH', 'User search');
define('_MI_MYFRIEND_SUB_FAVORITES', 'Favorites Users');

define('_MI_MYFRIEND_DELDAYS', 'Expiration of Invitations');
define('_MI_MYFRIEND_DELDAYS_DESC', 'Number of days before delete pending invitations.');
