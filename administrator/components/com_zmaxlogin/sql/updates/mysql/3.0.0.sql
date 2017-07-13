ALTER TABLE `#__zmax_users` ADD `nickname` varchar(256) ; 
ALTER TABLE `#__zmax_users` ADD `image_url` varchar(512) default "" ;

ALTER TABLE `#__zmax_extension` ADD `type` varchar(40) ;
ALTER TABLE `#__zmax_extension` ADD `name` varchar(128) ;
ALTER TABLE `#__zmax_extension` ADD `friendName` varchar(512) ;
ALTER TABLE `#__zmax_extension` ADD `authorEmail` varchar(128) ;
ALTER TABLE `#__zmax_extension` ADD `authorUrl` varchar(256) ;
ALTER TABLE `#__zmax_extension` ADD `description` TEXT ;
ALTER TABLE `#__zmax_extension` ADD `default` int  default 1;


