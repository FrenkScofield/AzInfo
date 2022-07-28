<?php

class Field_Lang extends Field_Select {
	
	protected function getOptions()
	{
		$config = _getAppData('config');
		$langs = $config['main']['languages'];
		$langOpts = array();
		foreach($langs as $l)
		{
			$langOpts[$l] = strtoupper($l);
		}
		$this->options = $langOpts;
		$this->_gotOptions = true;
	}
}