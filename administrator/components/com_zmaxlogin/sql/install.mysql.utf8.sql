DROP TABLE IF EXISTS `#__zmax_users`;
DROP TABLE IF EXISTS `#__zmax_extension`;

CREATE TABLE IF NOT EXISTS `#__zmax_users` (
  `id` int(10) unsigned NOT NULL auto_increment,  /*系统使用的ID，标示唯一记录*/
  `uid` varchar(256) NOT NULL,  /*第三方系统使用的OPENID*/
  `joomla_uid` int(11) default NULL, /*Joomla系统中对于的用户id*/
  `timestamp` int(10) unsigned NOT NULL, /*注册时的时间戳*/
  `type` varchar(40) NOT NULL , /*第三方登陆用户的登陆类型*/
  `nickname` varchar(512) NOT NULL default "" , /*第三方昵称*/
  `image_url` varchar(512) NOT NULL , /*第三方图像*/
  `params` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uid_2` (`uid`,`type`),
  KEY `uid` (`uid`,`joomla_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__zmax_extension` (
  `id` int(10) unsigned NOT NULL auto_increment ,
  `type` varchar(40) NOT NULL, /*扩展类型 ,可以是登陆认证扩展，也可以是系统使用的插件*/
  `logintype` varchar(40) NOT NULL, /*扩展类型，这个变量需要唯一，不能重复*/
  `name` varchar(128) default NULL, /*名称 和logintype保持一致*/ 
  `friendName` varchar(512) default NULL, /*显示给用户的名称*/
  `version` varchar(128) default NULL, /*扩展的版本*/
  `author` varchar(40) NOT NULL , /*扩展的作者*/
  `authorEmail` varchar(128) NOT NULL , /*作者Email*/
  `authorUrl` varchar(256) NOT NULL , /*作者URL*/
  `description` text,/*扩展描述*/
  `post_date` int(20) NOT NULL, /*扩展安装的时间*/
  `default` tinyint(1)  NOT NULL default 1 , /*保留字段*/
  `published` tinyint(1)  NOT NULL default 1 , /*扩展的状态*/
  `small_image` varchar(256) NOT NULL default "" , /*登陆后显示的图片*/
  `big_image` varchar(256) NOT NULL default "" , /*登陆前显示的图片*/
  `params` text,/*扩展的参数*/
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
