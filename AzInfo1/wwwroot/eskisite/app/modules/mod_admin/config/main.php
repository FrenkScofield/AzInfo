<?php 

$_config['main'] = array(
	'session_name'=>'PHPSESSID', // needed for assets (captcha image script)
	'table_prefix'=>'', // left blank for externally used tables won't be related to admin module itself
	
	// menu items config (added to the admin menu in order of module definitions in application main config file)	
	'admin_menu'=>array(
		'User management'=>array(
			'Users'=>array('mod'=>'mod_admin','action'=>'admin_mod_admin_user/list'),
			'User groups'=>array('mod'=>'mod_admin','action'=>'admin_mod_admin_user_group/list'),
			//'Templates'=>array('mod'=>'mod_admin','action'=>'admin_mod_admin_email_template/list'), // to be activated later
		)
	),
	// sample permission definitions (created by default)
	/*
	'admin_permissions'=>array(
		'Users'=>array(
			'List'=>'admin_mod_admin_user/list',
			'Edit'=>'admin_mod_admin_user/edit',
			'Delete'=>'admin_mod_admin_user/delete',
		),
		'User groups'=>array(
			'List'=>'admin_mod_admin_user_group/list',
			'Edit'=>'admin_mod_admin_user_group/edit',
			'Delete'=>'admin_mod_admin_user_group/delete'
		),
		'Email templates'=>array(
			'List'=>'admin_mod_admin_email_template/list',
			'Edit'=>'admin_mod_admin_email_template/edit',
			'Delete'=>'admin_mod_admin_email_template/delete'
		),
	),
	*/
);
