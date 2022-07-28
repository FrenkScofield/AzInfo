<?php

class CDatabase
{
	public $config=array();
	
	public function __construct($config='database_mysql_default')
	{		
		if(is_array($config))
		{
			$this->config = $config;
		}
		else
		{
			$this->config = CCoreHelper::getConfig($config,'database');
		}
	}
}
