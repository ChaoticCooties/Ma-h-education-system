<?php
require_once 'core/init.php';

ini_set('display_errors', 'On'); //PHP Configuration (For Errors locally)

define('APP_ROOT', './App/'); //Root to "App" Directory
define('VIEW_ROOT', APP_ROOT . '/views'); //Path to App/Views 
define('BASE_URL', 'http://localhost/cms/' ); //Base Page

$db = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password')); //will convert to use with helper class
?>