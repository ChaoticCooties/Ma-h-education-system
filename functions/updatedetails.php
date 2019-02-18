<?php
require_once '../core/start.php';
require APP_ROOT . 'views/templates/header.php';
$user = new User();
if(!$user->isLoggedIn()) {
	Redirect::to('home.php');
}
if(Input::exists()) { //csrf protection
	if(Token::check(Input::get('token'))) {
		$validate = new Validate(); //validation
		$validation = $validate->check($_POST, array(
			//fields in $_POST
			'name' => array(
				'required' 	=> true,
				'min' 		=> 2,
				'max' 		=> 50
			)
		));
		if($validation->passed()) {
			
			try {
				$user->update(array( //update
					'name' => Input::get('name') //fields in $_POST
				));
				//session:flash
				Redirect::to('profile.php');
			} catch(Exception $e) {
				die($e->getMessage()); //exception object in php
			}
		} else {
			foreach($validation->errors() as $error) {
				echo $error, '<br/>';
			}
		}
	}
}
?>

<form action="" method="post">
	<div class="field">
		<label for="name">Name</label>
			<input type="text" name="name" value="<?php echo escape($user->data()->name); ?>">

			<input type="submit" value="Update">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	</div>
</form>