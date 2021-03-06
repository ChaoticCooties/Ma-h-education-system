<?php 
class Token {
	public static function generate() { //generate token (view page source) to prevent CSRF attacks.
		return Session::put(Config::get('session/token_name'), md5(uniqid()));
	}

	public static function check($token) { //validate token
		$tokenName = Config::get('session/token_name');

		//does browser token = session token generated by system
		if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		} 

		return false;
	}
}