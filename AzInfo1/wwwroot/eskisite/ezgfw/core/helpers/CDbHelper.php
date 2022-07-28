<?php

class CDbHelper extends CHelper
{
	public static function dbConnect($configName='database_mysql_default')
	{
		$config = CCoreHelper::getConfig($configName,'database');				
		$appData = _getAppData(null,true);
		switch($config['driver'])
		{
			case 'mysql':
			default:				
				$appData['Controller']->db = new CMysql($configName);
		}
	}
}
