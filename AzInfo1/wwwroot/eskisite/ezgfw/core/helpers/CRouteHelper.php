<?php

class CRouteHelper extends CHelper {

	public static $routes = null;
	public static $reverseRoutes = null;
	
	public static function getRoutes() {
		if(is_array(self::$routes)){
			return self::$routes;
		}
		
		$return = array();
		$config = _getAppData('config',true);
		$routes = isset($config['main']['routes'])? $config['main']['routes'] :array();
		$languages = $config['main']['languages'];
		$languageRouting = $config['main']['languageRouting'];
		
		foreach ($routes as $key => $val) {
			$key1 = $key;
			$val1 = $val;
			
			if ($languageRouting) {
				$found = false;
				foreach ($languages as $l) {
					if (strpos($key1, $l . '/') !== false) {
						$found = true;
						break;
					}
				}
				
				if ($found) {
					$return[$key1] = $val1;
				} else {
					foreach ($languages as $l) {						
						$return[$l . '/' . $key1] = $l . '/' . $val1;
					}
				}
			}else {
				$return[$key1] = $val1;
			}
		}
		self::$routes = $return;
		return $return;
	}

	public static function getReverseRoutes() {
		if(is_array(self::$reverseRoutes)){
			return self::$reverseRoutes;
		}
		$routes = self::getRoutes();		
		$reverseRoutes = array();
		
		foreach ($routes as $key => $val) {			
			if (preg_match('/[^\(][.+?{\:]/', $key)) {
				continue;
			}
			
			$uriRegex = $val;
			$to = $key;

			if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE) {

				preg_match_all('/\(.+?\)/', $key, $keyRefs);
				preg_match_all('/\$.+?/', $val, $valRefs);

				$keyRefs = $keyRefs[0];

				$goodValRefs = array();
				foreach ($valRefs[0] as $ref) {
					$tempKey = substr($ref, 1);
					if (is_numeric($tempKey)) {
						--$tempKey;
						$goodValRefs[$tempKey] = $ref;
					}
				}

				foreach ($goodValRefs as $tempKey => $ref) {
					if (isset($keyRefs[$tempKey])) {
						$uriRegex = str_replace($ref, $keyRefs[$tempKey], $uriRegex);
					}
				}

				$uriRegex = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $uriRegex));

				$ph = 1;				
				$replace_arr = array();
				foreach ($keyRefs as $str) {					
					$replace_arr[] = '$' . $ph;
					$ph++;
				}
				foreach ($replace_arr as $i => $str) {
					$to = str_replace($keyRefs[$i], $str, $to);
				}
			}
			$reverseRoutes[$uriRegex] = $to;
		}
		self::$reverseRoutes = $reverseRoutes;
		return $reverseRoutes;
	}

	public static function parseRoute($rs, $reverse = false) {
		$rs = trim($rs, '/');

		$routes = $reverse ? self::getReverseRoutes() : self::getRoutes();

		if (isset($routes[$rs])) {
			return $routes[$rs];
		}

		foreach ($routes as $key => $val) {
			$key = str_replace(array(':any', ':num'), array('.+', '[0-9]+'), $key);
			if (preg_match('#^' . $key . '$#', $rs)) {
				if (strpos($val, '$') !== FALSE && strpos($key, '(') !== FALSE) {
					$val = preg_replace('#^' . $key . '$#', $val, $rs);
				}
				return $val;
			}
		}
		return $rs;
	}

	public static function parseReverseRoute($rs) {
		return self::parseRoute($rs, true);
	}
}