<?php 
class Cookie {
	public static function exists($name) { //whether a cookie exists
		return (isset($_COOKIE[$name])) ? true : false;
	}

	public static function get($name) { //acquire cookie
		return $_COOKIE[$name];
	}

	public static function put($name, $value, $expiry) { //place cookie on browser
		if(setcookie($name, $value, time() + $expiry, '/')) {
			return true;
		}

		return false;
	}

	public static function delete($name) { //reset with negative value can't just remove
		self::put($name, '', time() - 1);
	}
}