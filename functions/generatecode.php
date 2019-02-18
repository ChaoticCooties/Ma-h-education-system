<?php
require "../core/start.php";

$user = new User();

echo "Your invite link is ";
echo BASE_URL . "functions/joinclass.php?class=" . $user->getClassCode('alpha') . "";

?>