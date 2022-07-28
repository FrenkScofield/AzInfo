<?php

class CModel {
	public $_lang = ''; // Active language cache
	public $_module = null; // must be set to module_dir for models belonging to a module 
	public $_dbType = 'mysqli';
	public $_dbConfig = 'database_mysql_default';
	public $_db = null;
	public $_isActive = false; // wheter object has active record data	
	public $_className = '';
	public $_tableName = '';
	public $_tablePrefix = '';
	public $_alias = ''; //  for using AS `alias` ... in queries
	public $_use_alias = false;
	public $_primaryKey = 'id';	
	public $_defaultOrderBy = '';
	public $_tablenameIndexed = false; // active for relational queries
	public $_selected = false; //active when $_sql['what'] is set.
	public $_query = '';
	public $_sql = array(
		'command' => '',
		'what' => '',
		'set' => '',
		'from' => '',
		'as' => '',
		'join' => '',
		'where' => '',
		'group_by' => '',
		'having' => '',
		'order_by' => '',
		'limit' => ''
	);
	public $_sql_reset = array(); // will be assigned equal to $_sql
	
	public $_conditions = array(); // to be used for functions like where
	public $_having_conditions = array(); // to be used for having statement
	public $_rowFilter = array(); // solid filtering conditions for model
	public $_paging = array(
		'pageSize' => 10,
		'totalPages' => 1,
		'totalRows' => 0,
		'currentPage' => 1
	);
	public $_data = null;
	public $_relations = array(); // keys: rel (relation type), ref(reference column name), class(class name of related model), object(dont use this key!)
	public $_rows = array();
	public $_fields = array();

	public function setFieldValues() {
		foreach ($this->_fields as $key => $f) {
			$this->_fields[$key]['object']->setValue($this->$key);
		}
	}

	public function getLabel() {
		return 'id:' . $this->getId();
	}
		
	public function __construct($params=array()) {
		foreach ($params as $name => $value) {
			if (isset($this->$name)) {
				$this->$name = $value;
			}
		}
		
		// pre convert _dbConfig to config array (required for getting mysql driver type)
		$config = $this->_dbConfig;
		if(!is_array($config))
		{
			$config = CCoreHelper::getConfig($config,'database');
		}
		if(isset($config['driver'])){
			$this->_dbType = $config['driver'];
		}
		$this->_dbConfig = $config;
		
		$this->_className = get_class($this);
		if (empty($this->_tableName)) {
			$this->_tableName = strtolower(preg_replace('/(Model)$/', '', $this->_className));
		}
		
		if(empty($this->_lang)){
			$this->_lang = defined('LANG')? LANG : _getAppData('lang');
		}
		
		$this->_alias = uniqid($this->_tableName);

		switch ($this->_dbType) {
			case 'mysqli':
				$this->_sql_reset = $this->_sql;
				
				$this->_db = new CMysqli($this->_dbConfig);
				// ***** set the real tablename ******
				// load module config file if model belongs to a module and get table_prefix for the module
				//if( $module_dir =  CUrlHelper::isModule() )
				if ($module_dir = CCoreHelper::isModule($this)) {
					$mConfig = CCoreHelper::getModConfig('main', '', $module_dir);
					isset($mConfig['table_prefix']) || ($mConfig['table_prefix'] = '');
					$this->_tablePrefix = $mConfig['table_prefix'];
				}
				$this->_tableName =
						$this->_db->table_prefix  //  prefix for the mysql config
						. $this->_tablePrefix //  prefix for this model (forced to be set as the config setting 'table_prefix' for module based models)
						. $this->_tableName;

				if (empty($this->_alias)) {
					$this->_alias = $this->_tableName;
				}
			break;
			
			case 'mysql':
			default:
				$this->_sql_reset = $this->_sql;
				
				$this->_db = new CMysql($this->_dbConfig);
				// ***** set the real tablename ******
				// load module config file if model belongs to a module and get table_prefix for the module
				//if( $module_dir =  CUrlHelper::isModule() )
				if ($module_dir = CCoreHelper::isModule($this)) {
					$mConfig = CCoreHelper::getModConfig('main', '', $module_dir);
					isset($mConfig['table_prefix']) || ($mConfig['table_prefix'] = '');
					$this->_tablePrefix = $mConfig['table_prefix'];
				}
				$this->_tableName =
						$this->_db->table_prefix  //  prefix for the mysql config
						. $this->_tablePrefix //  prefix for this model (forced to be set as the config setting 'table_prefix' for module based models)
						. $this->_tableName;

				if (empty($this->_alias)) {
					$this->_alias = $this->_tableName;
				}
		}
		$this->_sql['from'] = 'FROM `' . $this->_tableName . '` ';
	}

	public function __destruct() {		
		unset($this->_db);
	}

	public function __get($name) {
		// check relative Models (lazy aproach)
		if (isset($this->_relations[$name])) {
			$relation = & $this->_relations[$name];
			if (isset($relation['object'])) {
				$relation['object']->setFieldValues(); // gridde her satır için yeni değerlerin kullanılmasını sağlar
				return $relation['object'];
			} else {
				$className = isset($relation['class']) ? $relation['class'] : $name;

				$relation['object'] = new $className();

				$relObj = & $relation['object'];

				switch ($relation['rel']) {
					case 'belongsTo':
						$ref = $relation['ref'];
						if (isset($relation['remote_ref'])) {
							$relObj->find(array($relation['remote_ref'] => $this->$ref));
						} else {
							$relObj->findByPk($this->$ref);
						}
						//$relObj->setFieldValues();
						break;

					case 'hasMany':
						$ref = $relation['ref'];
						$relObj->where(array($ref => $this->getId()))->findAll();
						break;

					case 'hasOne':
						$ref = $relation['ref'];
						$relObj->find(array($ref => $this->getId()));
						break;
				}
				return $relObj;
			}
		}

		// return data value		
		if (is_object($this->_data)) {
			if(isset($this->_data->$name)){
				return $this->_data->$name;
			}
			$name_lang = $name.'_'.$this->_lang;
			if(isset($this->_data->$name_lang)){
				return $this->_data->$name_lang;
			}
			
		} elseif (is_array($this->_data)) {
			if(isset($this->_data[$name])){
				return $this->_data[$name];
			}
			$name_lang = $name.'_'.$this->_lang;
			if(isset($this->_data[$name_lang])){
				return $this->_data[$name_lang];
			}
		}
	}

	public function __set($name, $val) {
		if (is_object($this->_data)) {
			$this->_data->$name = $val;
		} elseif (is_array($this->_data)) {
			$this->_data[$name] = $val;
		}
	}
	
	public function getAsArray(){
		$return = array();
		foreach($this->_data as $name=>$val){
			$return[$name] = $val;
		}
		return $return;
	}
	
	public function resetSql(){
		$this->_conditions = array();
		$this->_having_conditions = array();
		$this->_tablenameIndexed = false;
		$this->_selected = false;
		$this->_query = '';
		$this->_sql = $this->_sql_reset ;		
	}
	
	public function reset(){
		$this->resetSql();
	}
	
	public function _getQuery() {
		if ($this->_sql['command'] == 'SELECT' && empty($this->_sql['order_by'])) {
			$this->orderBy($this->_defaultOrderBy);
		}

		if (in_array($this->_sql['command'], array('SELECT', 'DELETE','UPDATE')) && count($this->_conditions) > 0) {
			$this->_sql['where'] = ' WHERE (' . implode(' AND ', $this->_conditions) . ') ';
		}
		if (in_array($this->_sql['command'], array('SELECT', 'DELETE','UPDATE')) && count($this->_having_conditions) > 0) {
			$this->_sql['having'] = ' HAVING (' . implode(' AND ', $this->_having_conditions) . ') ';
		}
		return $this->_query = implode(' ', $this->_sql);
	}

	private function _setCommand($command='select') {
		$command = strtolower($command);

		switch ($command) {
			case 'insert':
			case 'replace':
				$this->_sql['command'] = strtoupper($command) . ' INTO';
				$this->_sql['what'] = '`' . $this->_tableName . '`';
				//$this->_sql['values'] = '';
				$this->_sql['set'] = '';
				$this->_sql['from'] = '';
				$this->_sql['order_by'] = '';
				$this->_sql['where'] = '';
				$this->_conditions = array();
				break;

			case 'update':
				$this->_sql['command'] = 'UPDATE';
				$this->_sql['what'] = '`' . $this->_tableName . '`';
				$this->_sql['values'] = '';
				//$this->_sql['set'] = '';
				$this->_sql['from'] = '';
				break;

			case 'delete':
				$this->_sql['command'] = 'DELETE';
				$this->_sql['what'] = '';
				$this->_sql['values'] = '';
				$this->_sql['set'] = '';
				$this->_sql['from'] = 'FROM `' . $this->_tableName . '`';
				break;

			case 'select':
			default:
				$this->_sql['command'] = 'SELECT';
				if (!$this->_selected) {
					$this->_sql['what'] = ' * ';
				}
				$this->_sql['values'] = '';
				$this->_sql['set'] = '';
				$this->_sql['from'] = 'FROM `' . $this->_tableName . '` ';
		}
		return $this;
	}

	public function select($what = '*') {
		$this->_setCommand('select');
		$this->_sql['what'] = $what;
		$this->_selected = true;
		return $this;
	}

	public function isActive() {
		return $this->_isActive;
	}

	public function getId() {
		$col = $this->_primaryKey;
		return $this->$col;
	}

	public function getRows() {
		return $this->_rows;
	}

	/**************************************** QUERY METHODS **************************************/

	public function query($q='') {		
		if(empty($q)){
			$this->where($this->_rowFilter, false);
			$q = $this->_getQuery();
		}		
		return $this->_db->query($q);
	}

	public function run($command='select') {
		$this->_setCommand($command);
		return $this->query();
	}
	
	/**************************************** TRANSACTION METHODS **************************************/
	public function begin() {
		$this->_db->query('BEGIN');
	}
	public function commit() {
		$this->_db->query('COMMIT');
	}
	public function rollback() {
		$this->_db->query('ROLLBACK');
	}
	
	/**************************************** FETCH METHOD **************************************/
	public function fetchRow() {
		$this->_isActive = false;
		if (($this->_data = $this->_db->fetchRow($this->_tablenameIndexed))) {
			if ($this->_tablenameIndexed) {
				foreach ($this->_relations as $key => $rel) {
					$relation = & $this->_relations[$key];
					if (!isset($relation['object'])) {
						continue;
					}

					$relObj = & $this->_relations[$key]['object'];

					$index_name = ($relObj->_use_alias && isset($this->_data[$relObj->_alias])) ? $relObj->_alias : $relObj->_tableName
					;

					if (isset($this->_data[$index_name])) {
						$relObj->_data = $this->_data[$index_name];
						$relObj->_isActive = true;
					}
				}

				$index_name = ($this->_use_alias && isset($this->_data[$this->_alias])) ? $this->_alias : $this->_tableName
				;
				if (isset($this->_data[$index_name])) {
					if(isset($this->_data[''])){ // Add tableless columns to main array
						$this->_data[$index_name] = array_merge($this->_data[$index_name],$this->_data['']);
					}						
					$this->_data = $this->_data[$index_name];
					$this->_isActive = true;
				}
			} else {
				$this->_isActive = true;
			}
		}
		return $this->_data;
	}

	/*	 * ****************************************COUNT METHOD ***************************************** */

	public function count($condition='', $reset=true) {
		$count = 0;
		$_sql_tmp = $this->_sql;		
		$this->_setCommand('select');
		
		if($this->_sql['what'] == ' * '){
			$this->_sql['what'] = ' COUNT(*) as count ';
		} else {
			$this->_sql['what'] .= ', COUNT(*) as count ';
		}
		
		$this->where($condition, $reset);
		$this->_sql['order_by']= '';		
		
		switch($this->_dbType){
			case 'mysqli':
				$this->query();
				$row = $this->_db->result->fetch_array(MYSQLI_ASSOC);
				break;
			case 'mysql':
			default:
				$row = mysql_fetch_array($this->query(), MYSQL_ASSOC);
		}
		
		if ($row) {
			$count = $row['count'];
		}
		$this->_sql = $_sql_tmp;		
		return $count;
	}

	/*	 * ****************************************DELETE METHODS ***************************************** */

	public function deleteByPk($pk) {
		return $this->_setCommand('delete')->where(array($this->_primaryKey => $pk))->query();
	}

	public function delete($condition='') {
		if (empty($condition)) {
			$condition = array($this->_primaryKey => $this->getId());
		}
		return $this->_setCommand('delete')->where($condition)->query();
	}

	/*	 * ****************************************SAVE METHODS (insert / update) ***************************************** */

	public function insert($data = array()) {
		$this->_setCommand('insert');
		$keys = array();
		$vals = array();
		foreach ($data as $key => $val) {
			$key = $this->real_escape_string($key);
			$val = $this->real_escape_string($val);
			$keys[] = '`' . $key . '`';
			if ($val == null)
				$vals[] = 'null';
			else
				$vals[] = "'" . $val . "'";
		}
		$keys = implode(', ', $keys);
		$vals = implode(', ', $vals);
		$this->_sql['values'] = '(' . $keys . ') VALUES(' . $vals . ')';
		return $this->query();
	}

	public function update($data = array(), $condition='') {
		$this->_setCommand('update');
		if(is_array($condition)){
			if(!count($condition)){
				$condition = array($this->_primaryKey => $this->getId());
			}
		}
		else {
			if(empty($condition)) {
				$condition = array($this->_primaryKey => $this->getId());
			}
		}
				
		$this->where($condition);
		
		if (!is_array($data)) { // custom SET string usage ex: $model->update('`order`=``order`+1 `');
			$data = trim($data);
			if (empty($data)) { // if nothing to set dont do anything
				return true;
			}
			$this->_sql['set'] = 'SET ' . $data;
		} else {
			$settings = array();
			foreach ($data as $key => $val) {
				$key = $this->real_escape_string($key);
				if ($val == null)
					$settings[] = ' `' . $this->_tableName . '`.`' . $key . '` = null ';
				else {
					$val = $this->real_escape_string($val);
					$settings[] = ' `' . $this->_tableName . '`.`' . $key . "`='" . $val . "' ";
				}
			}

			if (!(count($settings) > 0)) { // if nothing to set dont do anything
				return true;
			}
			$this->_sql['set'] = 'SET ' . implode(',', $settings);
		}

		return $this->query();
	}

	/*	 * ****************************************FINDER METHODS ***************************************** */

	/*	 * ************* SINGLE ROW ************* */

	public function find($condition='') {
		$this->_setCommand('select');
		$this->where($condition);
		$this->query();
		return $this->fetchRow();
	}

	public function findByPk($pk) {
		return $this->find(array(
					$this->_primaryKey => $pk
				));
	}

	/*	 * ************ MULTIPLE ROWS ************* */

	/*
	 * Note: multiple rows find methods are not advised when used together with the "with" function for joining related models too
	 * (joined table(s) of only the last row (is/are) accessible through relative model object(s) of the current model )
	 * tip: you can use the $model->with(array('Model1','Model2'))->run() method instead of findAll and do $model->fetchRow() in a while loop to retrive rows one by one.
	 */

	public function findAll($condition='') {
		$this->_setCommand('select');
		$this->where($condition);
		$this->query();
		$this->_rows = $this->_db->fetchRows($this->_tablenameIndexed);
		//$this->_tablenameIndexed = false;
		return $this->_rows;
	}

	public function findPage($page=1, $pageSize=10, $condition='') {
		return $this->page($page, $pageSize, $condition)->findAll($condition);
	}

	/*	 * **************************************** HELPER METHODS ***************************************** */

	public function real_escape_string($str) {
		if(is_array($str)){
			return '';
		}
		switch($this->_dbType){
			case 'mysqli':
				return $this->_db->mysqli->real_escape_string($str);
			break;
			case 'mysql':
			default:	
				return mysql_real_escape_string($str, $this->_db->link);
		}
	}
	
	public function getConditionPart($col, $val, $op='=') {
		$col = $this->real_escape_string($col);
		$val = $this->real_escape_string($val);
		return "`{$this->_tableName}`.`{$col}` " . $op . " '{$val}'";
	}
	
	public function get_insert_id(){
		switch($this->_dbType){
			case 'mysqli':
				return $this->_db->mysqli->insert_id;
			break;
			case 'mysql':
			default:	
				return mysql_insert_id($this->_db->link);
		}
	}

	/*	 * ****************************************(CHAINABLE) MODIFIER METHODS ***************************************** */

	public function where($condition='', $reset=true, $op='=') {
		if (empty($condition)) {
			return $this;
		}

		if ($reset) {
			$this->_conditions = array();
		}

		if (is_array($condition)) { 
			foreach ($condition as $col => $val) {
				$this->_conditions[] = $this->getConditionPart($col, $val, $op);
			}
		} elseif (!empty($condition)) {
			$this->_conditions[] = $condition;
		}
		
		return $this;
	}
	
	public function having($condition='', $reset=true, $op='=') {		
		if (empty($condition)) {
			return $this;
		}

		if ($reset) {
			$this->_having_conditions = array();
		}

		if (is_array($condition)) {
			foreach ($condition as $col => $val) {
				$this->_having_conditions[] = $this->getConditionPart($col, $val, $op);
			}
		} elseif (!empty($condition)) {
			$this->_having_conditions[] = $condition;
		}
		
		return $this;
	}

	public function whereNot($condition=array(), $reset=true) { // string condition not allowed (use where for that)
		if (!is_array($condition)) {
			return $this;
		}
		return $this->where($condition, $reset, '<>');
	}

	public function groupBy($groupBy='') {
		if (is_array($groupBy) && count($groupBy)) {
			$this->_sql['group_by'] = 'GROUP BY ' . implode(', ', $groupBy);
		} elseif (!empty($groupBy)) {
			$this->_sql['group_by'] = 'GROUP BY ' . $groupBy;
		}
		return $this;
	}

	public function orderBy($orderBy='') {
		if (is_array($orderBy) && count($orderBy)) {
			$this->_sql['order_by'] = 'ORDER BY ' . implode(', ', $orderBy);
		} elseif (!empty($orderBy)) {
			$this->_sql['order_by'] = 'ORDER BY ' . $orderBy;
		}
		return $this;
	}

	public function limit($rows, $offset=0) {
		$this->_sql['limit'] = 'LIMIT ' . $offset . ',' . $rows;
		return $this;
	}

	public function page($page=1, $pageSize=10, $condition='',$offsetShift=0) {
		$count = $this->count($condition);
		$total_pages = 1;
		if ($count > 0) {
			$total_pages = ceil($count / $pageSize);
		}

		$this->_paging = array(
			'pageSize' => $pageSize,
			'totalPages' => $total_pages,
			'totalRows' => $count,
			'currentPage' => $page
		);
		$offset = ($page - 1) * $pageSize;
		return $this->limit($pageSize, $offset+$offsetShift)->where($condition);
	}

	public function withAll() {
		return $this->with(array_keys($this->_relations));
	}

	public function with($keys = array()) {
		$joins = array();
		if (!is_array($keys)) {
			$keys = explode(',', $keys);
		}
		$keys = array_map('trim', $keys);

		foreach ($keys as $key) {
			if (isset($this->_relations[$key])) {
				$relation = & $this->_relations[$key];
				$className = isset($relation['class']) ? $relation['class'] : $key;

				$relation['object'] = new $className();
				$relObj = & $relation['object'];

				switch ($relation['rel']) {
					case 'belongsTo':
						$relObj->_alias = $key;
						$relObj->_use_alias = true;
						$remote_ref = isset($relation['remote_ref']) ? $relation['remote_ref'] : $relObj->_primaryKey;
						$joins[] = 'LEFT JOIN `' . $relObj->_tableName . '` AS `' . $relObj->_alias . '` ON `' . $relObj->_alias . '`.`' . $remote_ref . '`=`' . $this->_tableName . '`.`' . $relation['ref'] . '` ';
						break;

					case 'hasOne':
						$relObj->_alias = $key;
						$relObj->_use_alias = true;
						$joins[] = 'LEFT JOIN `' . $relObj->_tableName . '` AS `' . $relObj->_alias . '` ON `' . $relObj->_alias . '`.`' . $relation['ref'] . '`=`' . $this->_tableName . '`.`' . $this->_primaryKey . '` ';
						break;

					case 'hasMany':
						break;

					default:
						trigger_error('Undefined relation type set for ' . $key . ' in class ' . $this->_className);
				}
				$this->_tablenameIndexed = true;
			} else {
				trigger_error($key . ' is not defined as a related Model of ' . $this->_className);
			}
		}
		$this->_sql['join'] = implode(' ', $joins);
		return $this;
	}

}
