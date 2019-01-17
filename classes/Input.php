<?php 
class Input {
	public static function exists($type = 'POST') {
		switch($type) {
			case 'POST': 
				return (!empty($_POST)) ? true : false; //if post is not empty, true else false
			break;
			case 'GET':
				return (!empty($_GET)) ? true : false; //if post is not empty, true else false
			break;
			default:
				return false;
			break;
		}
	}

	public static function get($item) {
		if(isset($_POST[$item])) { //if theres item in post, return it
			return $_POST[$item];
		} else if(isset($_GET[$item])) { //else, return item in get
			return $_GET[$item];
		}
		return ''; //if not return empty string to prevent error
	}
}