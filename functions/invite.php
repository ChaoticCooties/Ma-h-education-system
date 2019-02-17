<?php
    require once 'core/init.php';

    $classArr = get('user_class', array ('userID','=',$user->_data->id)); //array{userID,classID}

    if($classArr->count()) {
        return getInvitecode($classArr->first()->classID);
    }
