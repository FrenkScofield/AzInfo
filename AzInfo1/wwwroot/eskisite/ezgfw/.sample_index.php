<?php

require('init.php');

date_default_timezone_set('Asia/Istanbul');

// LIMIT EXECUTION PER SECOND

$_max_xps = 2; // max. execution per second
$now = time();

if( !isset($_SESSION['_x_time']) || !isset($_SESSION['_x_count']) ){	
	$_SESSION['_x_time'] = $now;
	$_SESSION['_x_count'] = $_max_xps;
}

if($_SESSION['_x_time']==$now){
	$_SESSION['_x_count'] ++;
	if($_SESSION['_x_count']> $_max_xps ){
		sleep(1);
	}
}else {
	$_SESSION['_x_time'] = $now;
	$_SESSION['_x_count'] = 1;
}

CApp::run();
