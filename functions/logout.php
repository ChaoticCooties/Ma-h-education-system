<?php
require_once 'core/init.php';

$user = new User();
$user ->logout();

Session::flash('home', 'You have successfully logged out!');
Redirect::to('home.php');