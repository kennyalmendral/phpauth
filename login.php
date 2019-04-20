<?php ob_start(); ?>

<?php require_once 'init.php'; ?>

<?php get_header(); ?>

<?php

if (is_user_logged_in()) {
	Redirect::to('index.php');
}

$error = null;
$form_errors = array();

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new UserValidation();

		$validation = $validate->check(Input::all(), array(
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

			if ($login) {
				Redirect::to('index.php');
			} else {
				$error = 'Invalid username and password combination.';
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

	<form action="" method="post" class="form-login">
		<?php if ($error != null): ?>
			<div class="form-group">
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Oh snap!</strong> <?php echo $error; ?>
				</div>
			</div>
		<?php endif; ?>
		
		<div class="form-group">
			<div class="input-group">
				<div class="input-group-prepend">
					<label class="input-group-text" for="username"><i class="fa fa-user"></i></label>
				</div>

				<input type="text" name="username" id="username" class="form-control <?php echo array_key_exists('username', $form_errors) ? 'is-invalid' : ''; ?>" placeholder="Username" autocomplete="off" value="<?php echo escape(Input::get('username')); ?>">
				<div class="invalid-feedback"><?php echo $form_errors['username']; ?></div>
			</div>
		</div>

		<div class="form-group">
			<div class="input-group">
				<div class="input-group-prepend">
					<label class="input-group-text" for="password"><i class="fa fa-lock"></i></label>
				</div>

				<input type="password" name="password" id="password" class="form-control <?php echo array_key_exists('password', $form_errors) ? 'is-invalid' : ''; ?>" placeholder="Password">
				<div class="invalid-feedback"><?php echo $form_errors['password']; ?></div>
			</div>
		</div>

		<div class="form-group">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="remember" name="remember">
				<label class="custom-control-label" for="remember">Remember me</label>
			</div>
		</div>

		<div class="form-group buttons">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<input type="submit" class="btn btn-primary" value="Login">
		</div>
	</form>

	<div class="bottom">
		<a href="register.php">No account yet? Register here &raquo;</a>
	</div>
</div>

<?php get_footer(); ?>
