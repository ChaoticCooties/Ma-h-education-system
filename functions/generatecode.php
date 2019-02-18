<?php
require "../core/start.php";

$user = new User();

$classID = $user->idToClassID($user->data()->id);


echo "Your invite link is ";
echo BASE_URL . "functions/joinclass.php?class=" . '"' . $user->getClassCode($classID) . '"';

?>