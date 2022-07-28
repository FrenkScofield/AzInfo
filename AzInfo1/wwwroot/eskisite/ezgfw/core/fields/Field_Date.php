<?php

class Field_Date extends CField
{
	public $datepicker = false;
		
	public function showInput()
	{		
		?><input type="text" name="<?=$this->name?>" size="10" value="<?=$this->db2input($this->value)?>" id="<?=$this->id?>">
		<script type="text/javascript">
		$(function(){
			$('#<?=$this->id?>').mask('99.99.9999')<?php if($this->datepicker){ ?>.datepicker()<?php } ?>;
		});
		</script>
		<?php 
	}
	
	private function formatDate($tar=''){
		if(empty($tar)) return '';
		$year  = substr($tar, 0,4 );
		$month = substr($tar, 5,2 );
		$day   = substr($tar, 8,2 );
		if($month==0) $month='01';
		if($day==0) $day='01';
		return $day.'.'.$month.'.'.$year;
	}
	
	
	public function db2ui($dbValue=null){
		if($dbValue===null) $dbValue = $this->value;
		return $this->formatDate($dbValue);
	}
	
	
	public function db2input($dbValue)
	{
		return $this->formatDate($dbValue);
	}
	
	public function input2db($inputValue)
	{
		//$arr = explode('.', substr($inputValue,0,10) );
		$arr = preg_split( "/[-.]+/", $inputValue ,3);
		
		if(count($arr)!=3){
			return '';
		}
		else{
			list($day,$mon,$year) = $arr;
		}
		$day = intval($day);
		$mon = intval($mon);

		if($day<10)
			$day = '0'.$day;
		if($mon<10)
			$mon = '0'.$mon;

		return $year.'-'.$mon.'-'.$day;
	}
}
