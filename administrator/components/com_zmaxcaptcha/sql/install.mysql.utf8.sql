DROP TABLE IF EXISTS `#__zmaxcaptcha_code`;

CREATE TABLE IF NOT EXISTS `#__zmaxcaptcha_code` (
  `id` int(10) unsigned NOT NULL auto_increment,  /*系统使用的ID，标示唯一记录*/
  `session_id` varchar(256) NOT NULL,  /*Session ID*/
  `type` varchar(20) NOT NULL default "normal", /*验证码的类型*/
  `code` varchar(10) NOT NULL, /*验证码*/
  `start_date` int(11) unsigned NOT NULL, /*验证码产生的时间*/
  `end_date` int(11) unsigned NOT NULL , /*验证码失效的时间*/
  `params` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `#__users` ADD `mobileno` VARCHAR( 12 ) NOT NULL DEFAULT '';
ALTER TABLE `#__users` ADD KEY `mobileno` (`mobileno`);
ALTER TABLE `#__users` ADD INDEX(`mobileno`);
