<?php ob_start(); ?>

<?php require_once 'init.php'; ?>

<?php get_header(); ?>

<?php

if (Session::exists('registered'))
	echo '<p class="flash">' . Session::flash('registered') . '</p>';

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true
			),
			'password' => array(
				'required' => true
			)
		));

		if ($validation->passed()) {
			$user = new User();
			$remember = (Input::get('remember') == 'on') ? true : false;

			$login = $user->login(Input::get('username'), Input::get('password'), $remember);

			if ($login)
				Redirect::to('index.php');
			else
				echo '<p class="error">Invalid username/password combination</p>';
		} else {
			show_errors($validation->errors());
		}
	}
}

?>

<form action="" method="post">
	<div>
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autocomplete="off">
	</div>

	<div>
		<label for="password">Password</label>
		<input type="password" name="password" id="password">
	</div>

	<div>
		<label for="remember"><input type="checkbox" name="remember" id="remember"> Remember me</label>
	</div>

	<div>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<input type="submit" value="Login">
		<a href="register.php" class="register">Create an account</a>
	</div>
</form>

<?php get_footer(); ?>
