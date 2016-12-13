<?php $this->render('template/header'); ?>

<ul>
	<li>Main Page</li>
	<?php if ( true !== Session::get('logged_in') ) : ?>
		<li><a href="/user/login">Login</a></li>
		<li><a href="/user/register">Register</a></li>
	<?php else: ?>
		<li><a href="/dashboard">Dashboard</a></li>
		<li><a href="/user/logout">Logout</a></li>
	<?php endif; ?>
</ul>

<h1><?php echo $this->title; ?></h1>
<p><?php echo $this->message; ?></p>

<?php $this->render('template/footer'); ?>