<?php
class Session {
	public static function exists($name) {
		return(isset($_SESSION[$name])) ? true : false; //check if there's session name, return true else false
	}
	public static function put($name, $value) { //put session feature
		return $_SESSION[$name] = $value;
	}

	public static function get($name) { //get session feature
		return $_SESSION[$name];
	}

	public static function delete($name) { //delete session feature
		if(self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}

	public static function flash($name, $string='') { //one time echo feature
		if(self::exists($name)) {
			$session = self::get($name);
			self::delete($name);
			return $session;
		} else {
			self::put($name, $string);
		}
		return '';
	}
}