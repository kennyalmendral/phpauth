<?php ob_start(); ?>

<?php require_once 'init.php'; ?>

<?php get_header(); ?>

<?php

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'users'
			),
			'password' => array(
				'required' => true,
				'min' => 6
			),
			'password_again' => array(
				'required' => true,
				'matches' => 'password'
			),
			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			)
		));

		if ($validation->passed()) {
			$user = new User();
			$salt = Hash::salt();

			try {
				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'name' => Input::get('name'),
					'joined' => date('Y-m-d H:i:s'),
					'group' => 2
				));

				Session::flash('registered', "You've been registered and can now log in.");
				Redirect::to('login.php');
			} catch (Exception $e) {
				die($e->getMessage());
			}
		} else {
			show_errors($validation->errors());
		}
	}
}

?>

<form action="" method="post">
	<div>
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
	</div>

	<div>
		<label for="password">Password</label>
		<input type="password" name="password" id="password">
	</div>

	<div>
		<label for="password-again">Repeat Password</label>
		<input type="password" name="password_again" id="password-again">
	</div>

	<div>
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>">
	</div>

	<div>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<input type="submit" name="submit" value="Register">
	</div>
</form>

<?php get_footer(); ?>
