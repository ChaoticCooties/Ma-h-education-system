<?php 
class Config {
	public static function get($path = null) {
		if($path) {
				$config = $GLOBALS['config'];
				$path = explode('/', $path);

				foreach($path as $bit) { //set as $bit for each path
					if(isset($config[$bit])) { //If config exists, use config
						$config = $config[$bit]; //if it doesn't exist, use localhost

					}
				}

				return $config;
		}

		return false;
	}
}