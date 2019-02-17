<?php
class Invite {
    public function getInviteCode($id) { //get invite code from class id
        $hash = Hash::unique();
        $hashCheck = $this->_db->get('class', array('name','=',$id));

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