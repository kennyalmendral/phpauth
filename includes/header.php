<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="<?php echo Config::get('site_info/description'); ?>">

	<title><?php echo page_title(); ?></title>

	<link rel="icon" href="favicon.ico">

	<link rel="stylesheet" href="vendors/font-awesome-4.7.0/font-awesome.min.css">
	<link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">

	<?php if (is_auth_page()): ?>
		<link rel="stylesheet" href="css/auth.css">
	<?php endif; ?>
</head>

<body class="<?php echo page_class(); ?>">
	<div id="preloader"></div>

	<?php if (!is_auth_page()): ?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			<div class="container">
				<a class="navbar-brand" href="<?php echo Config::get('site_info/url'); ?>" title="<?php echo Config::get('site_info/name'); ?>"><img src="images/logo-white.png" alt="<?php echo Config::get('site_info/name'); ?>"></a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbar">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="index.php">Dashboard</a>
						</li>
					</ul>

					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>

							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="update.php">Update Profile</a>
								<a class="dropdown-item" href="change-password.php">Change Password</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="logout.php">Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	<?php endif; ?>
