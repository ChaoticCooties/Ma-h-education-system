<?php
class Insert extends User {
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
	
	public function getInviteCode($classID) { //get invite code from class id
        $hash = Hash::unique();
        $hashCheck = $this->_db->get('class', array('name','=',$classID));

        if(!$hashCheck->count()) { //set code if not present
        $this->_db->insert('class', array(
            'name'  => $class,
            'code'  => $hash
        ));
        } else {
            $hash = $hashCheck->first()->code; //return code if present
        }

        return $hash;
    }
}