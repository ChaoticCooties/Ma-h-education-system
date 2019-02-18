<?php
require_once '../core/start.php';

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'name' => 'username', 		//name label
				'required' => true, 		//required in form
				'min' => 3, 				//minimum char length
				'max' => 20,				//maximum char length (with DB)
				'unique' => 'users' 		//unique to user table
			),
			'password' 	=> array(
				'name' => 'password', 		//name label
				'required' => true, 		//required in form
				'min' => 6,					//minimum char length
				'disp_text' => 'Password'	//Display Text Type
			), 
			'password_again' => array(
				'name' => 'password_again', //name label
				'required' => true,			//required in form
				'min' => 6,					//minimum char length
				'matches' => 'password', 	//matches password
				'disp_text' => 'Password' 	//Display Text Type
			), 
			'name' => array(
				'name' => 'name', 		//name label
				'required' => true,			//required in form
				'min' => 2,					//minimum char length
				'max' => 50					//maximum char length
			), 
		));

		if($validation->passed()) {
			$user = new User();

			$salt = ""; //Hash::salt(16) | can't fix this shit yet will come back later changepassword

			try {

				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'name' => Input::get('name'),
					'joined' => date('Y-m-d H:i:s'), //Year-Month-Day Hour:Minute:seconds
					'role' => 1
				));

				Session::flash('home', 'Registry successful, You may now Login!');
				Redirect::to('home.php');

			} catch(Exception $e) { //error if registering (will change)
				die($e->getMessage());
			}
		} else {
			foreach($validation->errors() as $error) {
				echo '<div class="fail"><p>',$error, '</p></div>';
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en"> 
	<head>
	    <title>Register</title>

	    <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/bootstrap.min.css">

	    <!-- FontAwesome CSS -->
	    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/font-awesome.min.css">

	    <!-- Styles -->
	    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/login.css">
</head>

<form action="" method="POST">
	<div class="container">
		<h1> Register </h1>
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
		<label for="password"> Password</label>
		<input type="password" name="password" id="password">
		<label for="password_again">Confirm password</label>
		<input type="password" name="password_again" value="" id="password_again">
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>">
		<button type="submit">Register</button>
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	
</form>