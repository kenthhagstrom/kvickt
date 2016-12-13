<?php $this->render('template/header'); ?>
<ul>
	<li><a href="/">Main Page</a></li>
	<?php if ( true !== Session::get('logged_in') ) : ?>
		<li><a href="/user/login">Login</a></li>
		<li>Register</li>
	<?php else: ?>
		<li><a href="/dashboard">Dashboard</a></li>
		<li><a href="/logout">Logout</a></li>
	<?php endif; ?>
</ul>

<h1><?php echo $this->title; ?></h1>

<?php if ( true !== $this->loggedin ) : ?>
	<?php $this->render('form/register'); ?>
<?php else: ?>
	<p>You're already a registered user, because it seems like you're logged in. Somebody else forgot to logout?</p>
<?php endif; ?>