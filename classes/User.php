<?php
class User {
	private $_db,  	//properties
			$_data, //all users data
			$_sessionName,//store session name
			$_cookieName, //store cookie name
			$_isLoggedIn; //whether if user is logged in 

	public function __construct($user = null) {
		$this->_db = DB::getInstance(); //connect to DB

		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');

		if(!$user) {
			if(Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);

				if($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					$this->find($user);$this->_isLoggedIn = TRUE;
				}
			}
		} else { //if defined user
			$this->find($user);
		}

	}

	public function update($fields = array(), $id = null) {

		if(!$id && $this->isLoggedIn()) { //update current user's id
			$id = $this->data()->id;
		}

		if(!$this->_db->update('users', $id, $fields)) {
			throw new Exception('There was an error updating.');
		}
	}

	public function create($fields = array()) { //create user
		if(!$this->_db->insert('users', $fields)) {
			throw new Exception('There was a problem creating an account.');
		}
	}

	public function find($user = null) { //find user by id
		if($user) {
			$field = (is_numeric($user)) ? 'id' : 'username'; //id otherwise username
			$data = $this->_db->get('users', array($field, '=', $user));

			if($data->count()) {	
				$this->_data = $data->first();
				return true;
			} 
		}

		return false;
	}

	public function login($username = null, $password = null, $remember = false) { //login

		if(!$username && !$password && $this->exists()) { //check if logged in
			Session::put($this->_sessionName, $this->data()->id); //set session for user
		} else {
			$user = $this->find($username);
			if($user) {
				if($this->data()->password === Hash::make($password, $this->data()->salt)) {
					Session::put($this->_sessionName, $this->data()->id);

					if($remember) { //if ticked then everything will be run
						$hash = Hash::unique(); //check inside of database see if userid exists already
						$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

						if(!$hashCheck ->count()) { //if not then insert hash to database
							$this->_db->insert('users_session', array(
								'user_id' 	=> $this->data()->id,
								'hash'		=> $hash
							));
						} else {
							$hash = $hashCheck->first()->hash; //otherwise set hash that is in database
						}

						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}

					return true;
		   		}
			}
		}

		return false;
	}

	public function hasPermission($key) {
		$group = $this->_db->get('groups', array('id', '=', $this->data()->role));
		
		if($group->count()) { //check if its in a role or not
			$permissions = json_decode($group->first()->permissions, true); //convert from json to php array
			
			//if($permissions[$key] == true) { NULL problem which WILL cause problems down the line
				//return true;}
			return !empty($permissions[$key]);
		}

		return false;
	}

	public function examReady($userID) {
        $progressArr = $this->_db->get('student_progress', array('studentID','=',$userID));
        if($progressArr->count()) {
            $lessonNo = $progressArr->first()->lessonNo;
            if($lessonNo == 5) {
                return true;
            }
        }

        return false;
	}
	
	public function hasPlacement($userID) {
		$progressArr = $this->_db->get('student_progress', array('studentID','=',$userID));
		if($progressArr->count()) {
			return true;
		} 

		return false;
	}

	public function joinClass($id,$code) {
        $class = $this->_db->get('class', array('code','=',$code));

        if($class->count()) {
            $classCheck = $this->_db->get('user_class', array('id','=',$id)); //check if user is in a class already.

            if(!$classCheck) { //add into db if not in class
                $this->_db->insert('user_class', array (
                    'userID'    => $id,
                    'classID'   => $class
				));
				
				return true;
            }
		}
		
		return false;
	}
	
	public function idToClassID($id = null) {
		$user_classArr = $this->_db->get('user_class', array('userID','=',$id));
		if($user_classArr->count()){
			$classID = $user_classArr->first()->classID;
			return $classID;
		}
	}

	public function getClassCode($id) { //get invite code from class id
        $classArr = $this->_db->get('class', array('classID','=',$id));

        if($classArr->count()) {//return code if present //set code if not present
			$hash = $classArr->first()->code; 
			return $hash;
        }
    }

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}

	public function logout() {

		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id)); //delete session from db

		Session::delete($this->_sessionName); //delete php session
		Cookie::delete($this->_cookieName); //delete has cookie
	}

	public function data() { //can't use _data variable outside class
		return $this->_data;
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}
}