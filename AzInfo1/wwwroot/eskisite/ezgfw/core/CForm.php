<?php
/* Sample field
	'sample_field'=>array(
		'label'=>'Sample Field',
		'type'=>'text',
		'value'=>'',
		'allowHtml'=>false,
		'rules'=>array()
	)
*/
class CForm
{
	public $ownerModel=null;
	
	protected $_className = '';
	
	public $_method = 'POST'; // POST , GET
	
	public $_fields = array();
	
	protected $_input  = array();	
	protected $_validated = true;
	
	protected $_errors = array();
	
	public $alert_session_name = '';
	
			
	protected $_tokenData = array(
		'name'=>'',
		'value'=>''
	);
	
	public function __get($var)
	{
		if(isset($this->_fields[$var]))
		{
			return $this->_fields[$var]['value'];
		}
	}
	
	public function __set($var,$val)
	{
		if(isset($this->_fields[$var]))
		{
			$this->_fields[$var]['value'] = $val;
		}
	}
	
	public function createFields()
	{		
		foreach($this->_fields as $name=>$field){
			$field['name'] = $name;
			$class = 'Field_'.ucfirst($field['type']);			
			$this->_fields[$name]['_field'] = new $class($field,$this,$this->ownerModel);
		}
	}
		
	public function setValues($row=false)
	{		
		if(is_object($row)){
			foreach($this->_fields as $name=>$f)
			{				
				if(isset($row->$name)){
					$this->_fields[$name]['_field']->setValue($row->$name);
					$this->_fields[$name]['value'] = $row->$name;
				}
			}
		}
		elseif(is_array($row)){
			foreach($this->_fields as $name=>$f)
			{				
				if(isset($row[$name])){
					$this->_fields[$name]['_field']->setValue($row[$name]);
					$this->_fields[$name]['value'] = $row[$name];
				}
			}
		}		
	}
	
	public function __construct(& $ownerModel = null)
	{
		$this->ownerModel = $ownerModel;
		$this->_className = get_class($this);
		$this->resetFields();
		
		$this->createFields();
				
		// Translate error messages
		foreach($this->_fields as $key=>$f)
		{
			$field = & $this->_fields[$key];
			$field['label'] =  isset($field['label'])? _l($field['label']) : '';
			isset($field['allowHtml']) || $field['allowHtml'] = false;
			isset($field['rules']) || ($field['rules'] = array());
			if(is_array($field['rules'])){
				foreach($field['rules'] as $rk=>$rule_str){
					$field['rules'][$rk] = _l($rule_str);
				}
			}			
		}
	}
	
	
	public function run($checkToken=true) // (varsayılan olarak token kontrolü aktif edildi)
	{
		$return = false;
		
		if(!$checkToken || $this->checkToken()){
			
			// eğer veri gönderilmemişse false dön
			$src = $this->getInputSource();
			if(!count($src)){
				return false;
			}
			
			$this->getInput();
			if($this->validate()){
				$return = true;
			}
		}
		return $return;
	}
	
	
	public function resetFields()
	{
		foreach($this->_fields as $field=>$params)
		{
			CCoreHelper::setDefault($this->_fields[$field]['value'],null);
			CCoreHelper::setDefault($this->_fields[$field]['type'],'text');
		}
	}
	
	public function setFieldsByModel(& $model){
		foreach($this->_fields as $name=>$arr){
			$val = $model->$name;
			if(!empty($val)){
				$this->$name = $val;
			}
		}
	}
	

	// <Token Functions>
	public function initToken(){ // aynı şekilde /init.php içinde de tanımlanıyor
		if(!isset($_SESSION['_token'])){
			$_SESSION['_token'] = md5(uniqid('tkn_', true));
		}
	}
	public function checkToken()
	{
		$this->initToken();
		$src = $this->getInputSource();
		return ( isset($src['_token']) && $src['_token']==$_SESSION['_token'] );
	}
	public function getTokenInput()
	{		
		$this->initToken();
		return '<input type="hidden" name="_token" value="'.$_SESSION['_token'].'">';
	}
	public function tokenInput()
	{		
		$this->initToken();
		?><input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?>">';<?php
	}
	
	/*
	public function initToken(){
		if(!isset($_SESSION['forms'][$this->_className]['tokenData']))
		{
			$this->_tokenData = array(
				'name'=>md5(uniqid().session_id().phpversion().$_SERVER['REMOTE_ADDR']),
				'value'=>md5(uniqid())
			);
			CCoreHelper::setDefault($_SESSION['forms'],array());
			CCoreHelper::setDefault($_SESSION['forms'][$this->_className],array());
			$_SESSION['forms'][$this->_className]['tokenData'] = $this->_tokenData ;
		}
		else{
			$this->_tokenData = $_SESSION['forms'][$this->_className]['tokenData'];
		}
	}
	public function getTokenName(){
		$this->initToken();
		return $this->_tokenData['name'];
	}
	public function getTokenValue(){
		$this->initToken();
		return $this->_tokenData['value'];
	}
	public function getTokenInput()
	{		
		$this->initToken();
		return '<input type="hidden" name="'.$this->_tokenData['name'].'" value="'.$this->_tokenData['value'].'">';
	}
	
	public function checkToken()
	{
		$result = isset($_SESSION['forms'][$this->_className]['tokenData']['name'])
			&& isset($_SESSION['forms'][$this->_className]['tokenData']['value'])
			&& isset( $_REQUEST[ $_SESSION['forms'][$this->_className]['tokenData']['name'] ])
			&& ($_REQUEST[ $_SESSION['forms'][$this->_className]['tokenData']['name'] ] == $_SESSION['forms'][$this->_className]['tokenData']['value'])
		;
		if($result)
		{
			unset($_SESSION['forms'][$this->_className]['tokenData']);
		}
		return $result;
	} */
	// </Token Functions>
	
		
	public function toHtml()
	{
		$this->createFields();
		
		$html = '<table>';		
		
		foreach($this->_fields as $name=>$field){			
			//$html.='<tr><td>'.$field['label'].'</td><td>:</td><td>'.$field['value'].'</td></tr>';			
			$html.='<tr><td valign="top">'.(!empty($field['label'])?$field['label']:$name).'</td><td valign="top">:</td><td valign="top">'.$this->_fields[$name]['_field'].'</td></tr>';
		}				
		$html.='</table>';		
		return $html;
	}
	
	public function hasErrors()
	{
		return count($this->_errors)?true:false;
	}
	
	public function showErrors($class='error')
	{
		$hasErrors = $this->hasErrors();
		if($hasErrors){
			?><div class="<?=$class?>"><?php 
			foreach($this->_errors as $error)
			{
				echo $error.'<br>';
			}
			?></div><?php 
		}		
		return $hasErrors;
	}
	
	public function getInputSource(){
		$this->_method = strtoupper($this->_method);
		if($this->_method=='GET') {
			$src = & $_GET;
		} else {
			$src = & $_POST;
		}
		return $src;
	}
	
	public function getInput()
	{		
		$src = $this->getInputSource();
		
		foreach($this->_fields as $field=>$params)
		{			
			$value = isset($src[$field])?$src[$field]:null;
			
			if(!is_array($value))
			{
				$value = trim($value);
			}
			
			$value = $this->_fields[$field]['_field']->input2db($value);
						
			$this->_input[$field] = $value;
			if($this->_validateField($field,$value))
			{
				if($this->_fields[$field]['allowHtml'] || $this->_fields[$field]['_field']->allowHtml ){
					$setVal = CFilterHelper::filterFormHtmlInput($value);
				}
				else{
					$setVal = CFilterHelper::filterFormInput($value);
				}
				$this->_fields[$field]['value'] = $setVal;
				$this->_fields[$field]['_field']->setValue($setVal);
			}
		}
		return $this->_input;
	}
		
	public function validate()
	{
		return $this->_validated;
	}
	
	protected function _validateField($field,&$value)
	{
		if(!isset($this->_fields[$field]))
		{
			return false;
		}
		$rules = isset($this->_fields[$field]['rules']) ? $this->_fields[$field]['rules'] : array();
		$label = isset($this->_fields[$field]['label']) ? $this->_fields[$field]['label'] : $field;
		$customErrors = true;
		if(!is_array($rules))
		{
			$rules = explode('|',$rules);
			$customErrors = false;
		}
		$result = true;
		foreach($rules as $key=>$ruleVal)
		{
			if($customErrors)
			{
				$rule = $key;
				$errorStr = $ruleVal;
			}
			else
			{
				$rule = $ruleVal;
			}
			if(!empty($rule))
			{
				$match = array();
				if( preg_match('/([[a-zA-Z0-9_-]+)\(([a-zA-Z0-9|_-]+)\)/',$rule,$match ) && count($match)==3 ) // rule(data) formatted functional rules
				{
					$rule = strtolower($match[1]);
					$ruleData = $match[2];
					$result = $result && CValidateHelper::$rule($this,$value,$ruleData);
				}
				else
				{
					$result = $result && CValidateHelper::$rule($value);
				}
				
				if(!$result)
				{
					$this->_validated = false;
					$this->_errors[$field] = $customErrors?$errorStr:$this->getErrorStr($field,$rule);
					return false;
				}
			}
			
		}
		return $result;
	}
	
	public function addError($error,$session_name='')
	{
		$this->_errors[] = $error;
		
		if(empty($session_name)){
			$session_name = $this->alert_session_name;
		}
		
		if(!empty($session_name)){
			$_SESSION[$session_name] = $error;
		}
	}
	
	protected function getErrorStr($field,$rule)
	{
		$label = isset($this->_fields[$field]['label']) ? $this->_fields[$field]['label'] : $field;
		$error_msg = 'Geçersiz alan: '.$label.'';
		switch($rule)
		{
			case 'required':$error_msg = _l('Field required').': '.$label; break;
			case 'email':$error_msg = _l('Please enter a valid e-mail address').': '.$label; break;
		}
		return _l($error_msg);
	}
	
	public function getErrors()
	{
		return $this->_errors;
	}
	
	public function getAsArray(){
		$row = array();
		foreach($this->_fields as $name=>$f){
			$row[$name] = $this->_fields[$name]['value'];
		}
		return $row;
	}
	
	public function getFillScript($selector='form',$fillEmptyAsLabel=false){
		$row = $this->getAsArray();
		ob_start();
		?><script type="text/javascript">$(document).ready(function(){ <?php 
		foreach($row as $name=>$value){
			if($fillEmptyAsLabel && empty($value)){
				$value= $this->_fields[$name]['label'];
			}
			$fType = isset($this->_fields[$name]['type']) ? $this->_fields[$name]['type'] : 'text';
			switch($fType){
				case 'radio':
					?>$("<?=$selector?> [name='<?=$name?>'][value='<?=$value?>']").attr('checked','checked');<?php 
					break;
				case 'checkbox':
					if($value==1){
						?>$("<?=$selector?> [name='<?=$name?>']").attr('checked','checked');<?php 
					}
					break;
				case 'select':
					?>$("<?=$selector?> [name='<?=$name?>'] option[value='<?=$value?>']").eq(0).attr('selected','selected');<?php 
					break;
				default:
					$value = str_replace(array("\r\n","\n","\r"), '\n', $value);
					$fClass = 'Field_'.ucfirst($fType);
					$field = new $fClass ;
					$value = $field->db2ui($value);
					$value = html_entity_decode($value,ENT_QUOTES);
					$value = str_replace("'","\'",$value);
					?>$("<?=$selector?> [name='<?=$name?>']").val('<?=$value?>');<?php 
			}
		}
		?> });</script><?php 
		return ob_get_clean();
	}
	
}
