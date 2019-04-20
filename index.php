<?php ob_start(); ?>

<?php require_once 'init.php'; ?>

<?php get_header(); ?>

<?php $user = new User(); ?>

<?php if (!$user->isLoggedIn()): ?>
	<?php Redirect::to('login.php'); ?>
<?php endif; ?>

<div class="container main-container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-title">Dashboard</h1>

			<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo $user->data()->name; ?></a>! What do you want to do today?</p>
			<ul>
				<li><a href="update.php">Update Profile</a></li>
				<li><a href="change-password.php">Change Password</a></li>
			</ul>
		</div>
	</div>
</div>

<?php get_footer(); ?>
