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

<div class="profile">
	<h2><?php echo escape($data->name); ?></h2>
	<p><strong>Username:</strong> <?php echo escape($data->username); ?></p>
	<p><strong>Role:</strong> <?php echo $user->hasPermission('admin') ? 'Administrator' : 'User'; ?></p>
</div>

<?php get_footer(); ?>

<?php } ?>
