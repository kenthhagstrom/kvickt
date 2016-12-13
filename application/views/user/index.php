<?php $this->render('template/header'); ?>

<ul>
	<li><a href="/">Main Page</a></li>
	<?php if ( true !== Session::get('logged_in') ) : ?>
		<li>Login</li>
		<li><a href="/user/register">Register</a></li>
	<?php else: ?>
		<li><a href="/dashboard">Dashboard</a></li>
		<li><a href="../user/logout">Logout</a></li>
	<?php endif; ?>
</ul>

<h1><?php echo $this->title; ?></h1>

<?php if ( true !== $this->loggedin ) : ?>
	<?php $this->render('form/login'); ?>
<?php else: ?>
	<p>Logged in</p>
<?php endif; ?>

<?php $this->render('template/footer'); ?>