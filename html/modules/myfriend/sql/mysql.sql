CREATE TABLE `{prefix}_{dirname}_friendlist` (
  `uid`   int(8) unsigned NOT NULL default '0',
  `friend_uid` int(8) unsigned NOT NULL default '0',
  `utime` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`, `friend_uid`)
) TYPE=MyISAM;

CREATE TABLE `{prefix}_{dirname}_invitation` (
  `id`    int(11) unsigned NOT NULL auto_increment,
  `uid`   int(8) unsigned NOT NULL default '0',
  `email`  varchar(100) NOT NULL default '',
  `actkey` varchar(50) NOT NULL default '',
  `utime` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `{prefix}_{dirname}_applist` (
  `id`    int(11) unsigned NOT NULL auto_increment,
  `uid`   int(8) unsigned NOT NULL default '0',
  `auid` int(8) unsigned NOT NULL default '0',
  `utime` int(11) unsigned NOT NULL default '0',
  `note` text ,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
