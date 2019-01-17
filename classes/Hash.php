<?php
class Hash { //security stuff. sha256 encryption with salt
	public static function make($string, $salt = '') { //hash encoding
		return hash('sha256', $string . $salt);
	} 

	public static function salt($length) {
		//hash match is buggy with this salt creation, changing salt to varbinary() is temp fix.
		return mcrypt_create_iv($length); 
	}

	public static function unique() {
		return self::make(uniqid());
	}
}