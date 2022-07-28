<?php

class CException extends Exception {

	function __toString() {
		header('Content-type:text/html;charset=utf-8', true);
		$code = $this->getCode();
		if(defined('IS_LOCALHOST') && IS_LOCALHOST ) {			
			return '				
				<table style="border:1px outset #a0a0a0; padding:3px;  background:#c0c0c0;font-weight:bold;">				
				<tr><td  valign="top">Error:</td><td>'.$this->getMessage(). (!empty($code)?' ('.$code.')':'') .'</td></tr>
				
				<tr><td  valign="top">File:</td><td>'.$this->getFile().'</td></tr>
				<tr><td  valign="top">Line:</td><td>'.$this->getLine().'</td></tr>
				<tr><td valign="top">Backtrace:</td><td>'.nl2br($this->getTraceAsString()).'</td></tr>
				</table>
			';
		}else {
			return '<div style="border: 1px solid;margin: 10px 0px;padding:15px 10px 15px 50px;color: #D8000C;background-color: #FFBABA;">' . $this->getMessage(). (!empty($code)?' ('.$code.')':'') . '</div>';
		}
	}
}
