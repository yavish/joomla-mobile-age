DROP TABLE IF EXISTS `#__zmaxcaptcha_code`;

CREATE TABLE IF NOT EXISTS `#__zmaxcaptcha_code` (
  `id` int(10) unsigned NOT NULL auto_increment,  /*ϵͳʹ�õ�ID����ʾΨһ��¼*/
  `session_id` varchar(256) NOT NULL,  /*Session ID*/
  `type` varchar(20) NOT NULL default "normal", /*��֤�������*/
  `code` varchar(10) NOT NULL, /*��֤��*/
  `start_date` int(11) unsigned NOT NULL, /*��֤�������ʱ��*/
  `end_date` int(11) unsigned NOT NULL , /*��֤��ʧЧ��ʱ��*/
  `params` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;