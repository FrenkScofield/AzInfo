<?php

class CMysql extends CDatabase {

	public $link = null;
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
		if (empty($this->link)) {
			$this->connect();
			$this->query("SET NAMES '" . $this->config['charset'] . "' COLLATE '" . $this->config['collation'] . "'");
		}
		if (empty($this->database)) {
			$this->selectDb();
		}
	}

	public function connect() {		
		$this->link = @mysql_connect(
			$this->config['server']
			, $this->config['username']
			, $this->config['password']			
		);

		if (!$this->link) {
			throw new CException(_l('Database connection failed!'));
		}
	}

	public function close() {
		mysql_close($this->link);
	}

	public function selectDb($database='') {
		if (empty($database)) {
			$database = $this->config['database'];
		}
		if (@mysql_select_db($database, $this->link)) {
			$this->database = $database;
		} elseif ($this->config['debug']) {
			throw new CException(_l('Database connection failed!'));
		}
		return $this;
	}

	public function query($q) {
		$this->init();
		$this->query = $q;
		$this->result = @mysql_query($q, $this->link);
		if (!$this->result && $this->config['debug']) {
			//trigger_error(_getAppData('is_localhost') ? 'Query failed: ' . $q . '<br>' . mysql_error($this->link) : 'Query failed' );
			trigger_error('Query failed: ' . $q . '<br>' . mysql_error($this->link) );
		}
		return $this->result;
	}

	private function _fetch($tablenameIndexed=false) {
		if ($tablenameIndexed) {
			if ($this->data = mysql_fetch_array($this->result, MYSQL_NUM)) {
				$tmp = array();
				foreach ($this->data as $key => $value) {
					$table = mysql_field_table($this->result, $key);
					$name = mysql_field_name($this->result, $key);
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
			$this->data = mysql_fetch_object($this->result);
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
