<?php ob_start(); ?>

<?php require 'init.php'; ?>

<?php get_header(); ?>

<?php

$user = new User();

if ( ! $user->isLoggedIn())
	Redirect::to('index.php');

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'current_password' => array(
				'required' => true,
				'min' => 6
			),
			'new_password' => array(
				'required' => true,
				'min' => 6,
			),
			'new_password_again' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'new_password'
			),
		));

		if ($validation->passed()) {
			if (Hash::make(Input::get('current_password') . $user->data()->salt) != $user->data()->password) {
				echo 'Your current password is wrong.';
			} else {
				$salt = Hash::salt();
				$user->update(array(
					'password' => Hash::make(Input::get('new_password'), $salt),
					'salt' => $salt
				));

				Session::flash('home', 'Your password has been changed.');
				Redirect::to('index.php');
			}
		} else {
			show_errors($validation->errors());
		}
	}
}

?>

<form action="" method="post">
	<div>
		<label for="current_password">Current Password</label>
		<input type="password" name="current_password" id="current-password">
	</div>
	<div>
		<label for="new_password">New Password</label>
		<input type="password" name="new_password" id="new-password">
	</div>
	<div>
		<label for="new_password_again">New Password Again</label>
		<input type="password" name="new_password_again" id="new-password-again">
	</div>
	<div>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<input type="submit" value="Change">
	</div>
</form>

<?php get_footer(); ?>
