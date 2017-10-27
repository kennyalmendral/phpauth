<?php ob_start(); ?>

<?php require_once 'init.php'; ?>

<?php get_header(); ?>

<?php

$user = new User();

if ( ! $user->isLoggedIn())
	Redirect::to('index.php');

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
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

				Session::flash('home', "You're details have been updated.");
				Redirect::to('index.php');
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
		<label for="name">Name</label>
		<input type="text" name="name" value="<?php echo escape($user->data()->name); ?>">
	</div>

	<div>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<input type="submit" value="Update">
	</div>
</form>

<?php get_footer(); ?>
