<?php 
require_once '../core/start.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {

        $validate = new Validate(); //Validate the submission 
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true),
        ));

        if($validation->passed()) {
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false; //if = on, parse thru otherwise false
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if($login) {
                Session::flash('home', 'You have successfully logged in!');
                Redirect::to('home.php');
            } else {
                echo '<div class="fail"><p>No User/Password Found, Please Try Again</p></div>';
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
        <title>Login</title>

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

<body>
<form action="" method="POST">
    <div class="container">
        <h1> Login </h1>
        <input type="text" name="username" id="username" autocomplete="off" placeholder="Username">
        <input type="password" name="password" id="password" autocomplete="off" placeholder="Password">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <button type="submit">Login</button>
        <label for="remember">
            <input type="checkbox" name="remember" id="remember"> Remember Me
            <p> -<a href="register.php">Don't have an account?</a>- </p>
        </label>
    </div>
</form>
</body>