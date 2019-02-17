<?php

if(empty($_GET['class'])) {
    $class = false;
}
else {
    $joinCode = $_GET['class'] //localhost/ma+h/functions/joinclass.php?class=""
    joinClass($user->_data->id,$joinCode)
}