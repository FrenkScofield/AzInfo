<?php 

class CXml
{
	public $__name='XML_ROOT';
	public $__data=null;
	public $__attrs=array();	
	public $__children=array();
		
	public $__xml_parser;
	public $__curRef = null;
	public $__parent = null;
	
	public function __construct( & $parent = null)
	{
		$this->__parent = $parent;		
	}
	
	public function __get($name)
	{
		$arr = array();
		foreach($this->__children as $key=>$obj)
		{
			if($name==$obj->__name)
			{
				$arr[] = & $this->__children[$key];
			}
		}
		
		if(count($arr)==1)
		{
			return $arr[0];
		}
		return $arr;
	}
	
	public function getData()
	{
		return $this->__data;
	}
	
	public function getAttrs()
	{
		return $this->__attrs;
	}
	
	public function getChildren()
	{
		return $this->__children;
	}
	
	public function getAttr($key)
	{
		return isset($this->__attrs[$key]) ? $this->__attrs[$key] :false;
	}	
	
}
