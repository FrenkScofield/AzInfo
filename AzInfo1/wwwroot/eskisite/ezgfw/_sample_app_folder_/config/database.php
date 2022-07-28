<?php

$_config['database_mysql_default'] = IS_LOCALHOST ?

// LOCALHOST
array(
	'driver'    => 'mysqli',
	
	'server'    => 'localhost',
	'username'  => 'root',
	'password'  => ($_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1') ?'db_password':'',
	'database'  => '',
	
	'charset'   => 'utf8',
	'collation' => 'utf8_general_ci',
	'debug'     => true
)
: // SERVER
array(
	'driver'    => 'mysqli',
	
	'server'    => 'localhost',
	'username'  => '',
	'password'  => '',
	'database'  => '',
	
	'charset'   => 'utf8',
	'collation' => 'utf8_general_ci',
	'debug'     => true
)
;
