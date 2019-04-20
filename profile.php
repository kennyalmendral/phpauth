<?php 

require_once 'init.php';

if ( ! $username = Input::get('user')) {
	Redirect::to('index.php');
} else {
	$user = new User($username);

	if ( ! $user->exists())
		Redirect::to(404);
	else
		$data = $user->data();
?>

<?php get_header(); ?>

<div class="container main-container">
	<div class="row">
		<div class="profile col-md-12">
			<h1 class="page-title"><?php echo escape($data->name); ?></h1>

			<p><strong>Username:</strong> <?php echo escape($data->username); ?></p>
			<p><strong>Role:</strong> <?php echo $user->hasPermission('admin') ? 'Administrator' : 'User'; ?></p>
		</div>
	</div>
</div>

<?php get_footer(); ?>

<?php } ?>
