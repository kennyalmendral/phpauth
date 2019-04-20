<?php ob_start(); ?>

<?php require 'init.php'; ?>

<?php get_header(); ?>

<?php

$user = new User();

if ( ! $user->isLoggedIn()) {
	Redirect::to('index.php');
}

$error = null;
$form_errors = array();

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new UserValidation();

		$validation = $validate->check(Input::all(), array(
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
				$error = "The current password you've entered is invalid.";
			} else {
				$salt = Hash::salt();

				$user->update(array(
					'password' => Hash::make(Input::get('new_password'), $salt),
					'salt' => $salt
				));

				Session::flash('password_changed', 'Your password has been changed successfully.');

				Redirect::to('change-password.php');
			}
		} else {
			$form_errors = $validation->errors();
		}
	}
}

?>

<div class="container main-container">
	<div class="row">
		<div class="profile col-md-12">
			<h1 class="page-title">Change Password</h1>

			<form action="" method="post" class="form">
				<?php if (Session::exists('password_changed')): ?>
					<div class="form-group">
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Well done!</strong> <?php echo Session::flash('password_changed'); ?>
						</div>
					</div>
				<?php elseif ($error != null): ?>
					<div class="form-group">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Oh snap!</strong> <?php echo $error; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="form-group">
					<label for="current-password">Current Password</label>

					<input type="password" name="current_password" id="current-password" class="form-control <?php echo array_key_exists('current_password', $form_errors) ? 'is-invalid' : ''; ?>">
					<div class="invalid-feedback"><?php echo str_replace('Current_password', 'Current Password', $form_errors['current_password']); ?></div>
				</div>

				<div class="form-group">
					<label for="new-password">New Password</label>

					<input type="password" name="new_password" id="new-password" class="form-control <?php echo array_key_exists('new_password', $form_errors) ? 'is-invalid' : ''; ?>">
					<div class="invalid-feedback"><?php echo str_replace('New_password', 'New Password', $form_errors['new_password']); ?></div>
				</div>

				<div class="form-group">
					<label for="new-password-again">Repeat New Password</label>

					<input type="password" name="new_password_again" id="new-password-again" class="form-control <?php echo array_key_exists('new_password_again', $form_errors) ? 'is-invalid' : ''; ?>">
					<div class="invalid-feedback"><?php echo str_replace('New_password_again', 'Repeat New Password', $form_errors['new_password_again']); ?></div>
				</div>

				<div class="form-group">
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
					<input type="submit" class="btn btn-primary" value="Update">
				</div>
			</form>
		</div>
	</div>
</div>

<?php get_footer(); ?>
