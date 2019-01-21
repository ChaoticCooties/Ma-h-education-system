<?php
require_once 'init.php';

ini_set('display_errors', 'On'); //PHP Configuration (For Errors locally)

define('MATH_ROOT', './'); //root of the entire directory
define('APP_ROOT', '../app/'); //Root to "App" Directory
define('VIEW_ROOT', APP_ROOT . 'views/page'); //Path to App/Views/page
define('BASE_URL', 'http://localhost/ma+h/' ); //Base Page

$db = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password')); //will convert to use with helper class
?>