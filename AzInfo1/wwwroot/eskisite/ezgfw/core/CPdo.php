<?php
/*
 * Sample database config array for config/database.php:
 
 $_config['database_pdo_default'] = array(
	'dsn'=>'',
	'username'=>'',
	'password'=>'',
	'options'=>array()
);
  
 */

class CPdo extends CDatabase {

	public $pdo = null; // PDO object	
	
	public function __construct($config='database_pdo_default') {
		parent::__construct($config);
		
		isset($this->config['dsn']) || $this->config['dsn'] = '';
		isset($this->config['username']) || $this->config['username'] = '';
		isset($this->config['password']) || $this->config['password'] = '';
		isset($this->config['options']) || $this->config['options'] = array();
		
		try{
			$this->pdo = new PDO($this->config['dsn']  , $this->config['username'], $this->config['password'], $this->config['options']);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			throw new CException('PDO Error: '.$e->getMessage());
		}
	}
}
