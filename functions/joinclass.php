<?php

require '../core/start.php';

if(empty($_GET['class'])) {
    $class = false;
}
else {
    $joinCode = $_GET['class']; //localhost/ma+h/functions/joinclass.php?class=""
    $user = new User();
    if($user->joinClass($user->data()->id,$joinCode)) {
        echo "Success";
    } else {
        echo "Failure";
    }
}