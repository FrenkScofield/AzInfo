CREATE TABLE `mod_admin_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(40) DEFAULT NULL,
  `email` text,
  `password` varchar(40) DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL, 
  `confirm_status` enum('0','1') DEFAULT '0',
  `signature` text,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;

CREATE TABLE `mod_admin_user_group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `demo_mode` enum('0','1'),
  `permissions` longtext,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;

CREATE TABLE `mod_admin_email_template` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `content` text,
  `order` int(11) DEFAULT '999',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
;

INSERT INTO `mod_admin_user_group` (`name`,`permissions`) VALUES('Admin','a:9:{i:0;s:35:"mod_admin/admin_mod_admin_user/list";i:1;s:35:"mod_admin/admin_mod_admin_user/edit";i:2;s:37:"mod_admin/admin_mod_admin_user/delete";i:3;s:41:"mod_admin/admin_mod_admin_user_group/list";i:4;s:41:"mod_admin/admin_mod_admin_user_group/edit";i:5;s:43:"mod_admin/admin_mod_admin_user_group/delete";i:6;s:45:"mod_admin/admin_mod_admin_email_template/list";i:7;s:45:"mod_admin/admin_mod_admin_email_template/edit";i:8;s:47:"mod_admin/admin_mod_admin_email_template/delete";}')
;
