<?php

if(!isset($GLOBALS['mysqli'])){
	$GLOBALS['mysqli'] = null;
}

class CMysqli extends CDatabase {

	public $mysqli = null;
	public $database = null;
	public $query = '';
	public $result = null;
	public $table_prefix = '';
	public $num_rows = 0;
	public $num_pages = 1;
	public $num_affected_rows = 0;
	public $data;

	//public function CMysql($config='database_mysql_default')
	public function __construct($config='database_mysql_default') {
		parent::__construct($config);
		isset($this->config['table_prefix']) || ($this->config['table_prefix'] = '');
		$this->table_prefix = $this->config['table_prefix'];
		$this->init();
	}

	protected function init() {
		
		$this->mysqli = & $GLOBALS['mysqli']; // ortak connection kullanımı için
		
		if (empty($this->mysqli)) {
			$this->connect();
			$this->query("SET NAMES '" . $this->config['charset'] . "' COLLATE '" . $this->config['collation'] . "'");
		}
		if (empty($this->database)) {
			$this->selectDb();
		}
	}

	public function connect() {
		$this->mysqli = new mysqli($this->config['server'], $this->config['username'], $this->config['password']);
		
		if (!$this->mysqli) {
			throw new CException(_l('Database connection failed!'));
		}
	}

	public function close() {
		$this->mysqli->close();
	}

	public function selectDb($database='') {
		if (empty($database)) {
			$database = $this->config['database'];
		}
		
		if (@$this->mysqli->select_db($database)) {
			$this->database = $database;
		} elseif ($this->config['debug']) {
			throw new CException(_l('Database connection failed!'));
		}
		return $this;
	}

	public function query($q) {
		$this->init();
		$this->query = $q;
		$this->result = @ $this->mysqli->query($q);
		if (!$this->result && $this->config['debug']) {
			trigger_error('Query failed: ' . $q . '<br>' . $this->mysqli->error );
		}
		$log = _getAppData('log_query');
		if($log){
			error_log(date('Y-m-d H:i:s').' | '.$q ."\n\n", 3,APP_PATH.'/log/querylog.txt');
		}
		return $this->result;
	}

	private function _fetch($tablenameIndexed=false) {
		if ($tablenameIndexed) {
			if($this->data = $this->result->fetch_array(MYSQLI_NUM)){
				$tmp = array();
				foreach ($this->data as $i => $value) {
					$meta = $this->result->fetch_field_direct($i);
					$table = $meta->table;
					$name = $meta->name;
					if (!isset($tmp[$table])) {
						$tmp[$table] = array();
					}
					$tmp[$table][$name] = stripslashes($value);
				}
				return $tmp;
			} else {
				return $this->data;
			}
			
		} else {
			$this->data = $this->result->fetch_object();
			$this->_decode();
			return $this->data;
		}
	}

	private function _decode() {
		if (is_array($this->data)) {
			foreach ($this->data as $key => $value) {
				$this->data[$key] = stripslashes($value);
			}
		} elseif (is_object($this->data)) {
			foreach ($this->data as $key => $value) {
				$this->data->$key = stripslashes($value);
			}
		}
	}

	public function fetchRow($tablenameIndexed=false) {
		return $this->_fetch($tablenameIndexed);
	}

	public function fetchRows($tablenameIndexed=false) {
		$rows = array();
		while ($row = $this->_fetch($tablenameIndexed)) {
			$rows[] = $row;
		}
		return $rows;
	}

}
