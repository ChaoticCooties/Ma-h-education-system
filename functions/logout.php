<?php
require_once '../core/start.php';

$user = new User();
$user ->logout();

Session::flash('home', 'You have successfully logged out!');
Redirect::to('home.php');