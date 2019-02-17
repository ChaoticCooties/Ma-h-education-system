<?php
require_once '../core/start.php';
require APP_ROOT . 'views/templates/header.php';
$user = new User();
if(!$user->isLoggedIn()) { //check if logged in
	Redirect::to('index.php'); //else redirect
}
if(Input::exists()) {
	if(Token::check(Input::get('token'))) { //csrf protection
		$validate = new Validate(); //form validation
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' 	=> true,
				'min' 		=> 6
			),
			'password_new' 	=> array(
				'required' 	=> true,
				'min' 		=> 6
			),
			'password_new_again' => array(
				'required' 	=> true,
				'min' 		=> 6,
				'matches' 	=> 'password_new'
			)
		));
		if($validation->passed()) {
			
			//change password
			if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) { //verify current password
				echo 'Your current password is wrong.';
			} else {
				$salt = ''; //Hash::salt(16) | can't fix this shit yet will come back later register
				$user->update(array( //update db with changepassword
					'password' => Hash::make(Input::get('password_new'), $salt),
					'salt' => $salt
				));
				Session::flash('home', 'Your password has been changed!');
				Redirect::to('index.php');
			}
		} else {
			foreach($validation->errors() as $error) { 
				echo $error, '<br/>'; //echo errors
			}
		}
	}
}
?>

		<div class="row list-row">
			<div class="row">
				<div class="col-12">
					<form action="" method="POST">
						<div class="field">
							<label for="password current">Current Password</label>
							<input type="password" name="password_current" id="password_current">
						</div>

						<div class="field">
							<label for="password_new">New Password</label>
							<input type="password" name="password_new" id="password_new">
						</div>

						<div class="field">
							<label for="password_new_again">Confirm New Password</label>
							<input type="password" name="password_new_again" id="password_new_again">
						</div>

						<input type="submit" value="Change">
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
					</form>
	            </div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .list-row -->
	</div><!-- .container -->
</div><!-- .outer-container -->