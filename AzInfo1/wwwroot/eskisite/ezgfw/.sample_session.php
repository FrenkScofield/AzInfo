<?php

$sessid = session_id();
if(empty($sessid)){	
	session_start();
}
