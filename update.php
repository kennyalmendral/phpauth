<?php ob_start(); ?>

<?php require_once 'init.php'; ?>

<?php get_header(); ?>

<?php

$form_errors = array();

$user = new User();

if ( ! $user->isLoggedIn()) {
	Redirect::to('login.php');
}

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new UserValidation();

		$validation = $validate->check(Input::all(), array(
			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			)
		));

		if ($validation->passed()) {
			try {
				$user->update(array(
					'name' => Input::get('name')
				));

				Session::flash('profile_updated', "Your profile has been updated successfully.");

				Redirect::to('update.php');
			} catch (Exception $e) {
				pp($e->getMessage());
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
			<h1 class="page-title">Update Profile</h1>

			<form action="" method="post" class="form">
				<?php if (Session::exists('profile_updated')): ?>
					<div class="form-group">
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Well done!</strong> <?php echo Session::flash('profile_updated'); ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="form-group">
					<label for="name">Name</label>

					<input type="text" name="name" id="name" class="form-control <?php echo array_key_exists('name', $form_errors) ? 'is-invalid' : ''; ?>" value="<?php echo escape($user->data()->name); ?>">
					<div class="invalid-feedback"><?php echo $form_errors['name']; ?></div>
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
