<?php 

class CXmlParser
{			
	public $__xml_parser;
	public $__curRef = null;
		
	public $__xml = null;
	
	public function __construct()
	{
		$this->__xml = new CXml();
		$this->__curRef = & $this->__xml;
	}
		
	// parse functions
	public function parse($xml)
	{		
        $this->__xml_parser = xml_parser_create();
        xml_set_object($this->__xml_parser, $this);
        xml_set_element_handler($this->__xml_parser,'startElement','endElement');
        xml_set_character_data_handler($this->__xml_parser,'characterData');
        $result = xml_parse($this->__xml_parser, $xml) ;
        xml_parser_free($this->__xml_parser);
        return (!$result) ? false : $this->__xml;
    }
    
	private function startElement($parser,$tagName,$attrs)
	{		
		$this->__curRef->__children[] = new CXml($this->__curRef);
		$akeys = array_keys($this->__curRef->__children);
		$key = end($akeys);
		$this->__curRef = & $this->__curRef->__children[ $key ];		
		$this->__curRef->__name = $tagName;
		$this->__curRef->__attrs = $attrs;		
	}
	private function characterData($parser, $data)
	{
        $this->__curRef->__data = $data;
    }
	private function endElement($parser,$tagName)
	{		
		$this->__curRef = & $this->__curRef->__parent ;		
    }
}
