<?php ob_start(); ?>

<?php require_once 'init.php'; ?>

<?php get_header(); ?>

<?php

$form_errors = array();

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new UserValidation();

		$validation = $validate->check(Input::all(), array(
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

				Session::flash('registered', "Your account has been created successfully.");

				Redirect::to('register.php');
			} catch (Exception $e) {
				pp($e->getMessage());
			}
		} else {
			$form_errors = $validation->errors();
		}
	}
}

?>

<div class="wrapper">
	<div class="logo">
		<a href="<?php echo Config::get('site_info/url'); ?>" title="<?php echo Config::get('site_info/name'); ?>"><img src="images/logo.png" alt="<?php echo Config::get('site_info/name'); ?>"></a>
	</div>

	<form action="" method="post" class="form-register">
		<?php if (Session::exists('registered')): ?>
			<div class="form-group">
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Well done!</strong> <?php echo Session::flash('registered'); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="form-group">
			<label for="username">Username</label>

			<input type="text" name="username" id="username" class="form-control <?php echo array_key_exists('username', $form_errors) ? 'is-invalid' : ''; ?>" autocomplete="off" value="<?php echo escape(Input::get('username')); ?>">
			<div class="invalid-feedback"><?php echo $form_errors['username']; ?></div>
		</div>

		<div class="form-group">
			<label for="password">Password</label>

			<input type="password" name="password" id="password" class="form-control <?php echo array_key_exists('password', $form_errors) ? 'is-invalid' : ''; ?>">
			<div class="invalid-feedback"><?php echo $form_errors['password']; ?></div>
		</div>

		<div class="form-group">
			<label for="password-again">Repeat Password</label>

			<input type="password" name="password_again" id="password-again" class="form-control <?php echo array_key_exists('password_again', $form_errors) ? 'is-invalid' : ''; ?>">
			<div class="invalid-feedback"><?php echo str_replace('Password_again', 'Repeat Password', $form_errors['password_again']); ?></div>
		</div>

		<div class="form-group">
			<label for="name">Name</label>

			<input type="text" name="name" id="name" class="form-control <?php echo array_key_exists('name', $form_errors) ? 'is-invalid' : ''; ?>" value="<?php echo escape(Input::get('name')); ?>">
			<div class="invalid-feedback"><?php echo $form_errors['name']; ?></div>
		</div>

		<div class="form-group buttons">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<input type="submit" name="submit" class="btn btn-primary" value="Register">
		</div>
	</form>

	<div class="bottom">
		<a href="login.php">&laquo; Back to login</a>
	</div>
</div>

<?php get_footer(); ?>
