<?php ob_start(); ?>

<?php require_once 'init.php'; ?>

<?php get_header(); ?>

<?php $user = new User(); ?>

<?php if ($user->isLoggedIn()): ?>
	<h2>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo $user->data()->name; ?></a>!</h2>

	<ul>
		<li><a href="update.php">Update Information</a></li>
		<li><a href="change_password.php">Change Password</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
<?php else: ?>
	<?php Redirect::to('login.php'); ?>
<?php endif; ?>

<?php get_footer(); ?>
