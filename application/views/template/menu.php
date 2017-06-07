<ul>
<?php if ( true !== Session::get('logged_in') ) : ?>
	<li><a href="<?php echo SITE_URL; ?>">Main Page</a></li>
	<li><a href="<?php echo SITE_URL; ?>user/register/">Register</a></li>
	<li><a href="<?php echo SITE_URL; ?>user/Login/">Login</a></li>
<?php else: ?>
	<li><a href="<?php echo SITE_URL; ?>">Main Page</a></li>
	<li><a href="<?php echo SITE_URL; ?>dashboard/">Dashboard</a></li>
	<li><a href="<?php echo SITE_URL; ?>user/edit/">Edit Profile</a></li>
	<li><a href="<?php echo SITE_URL; ?>user/logout/">Logout</a></li>
<?php endif; ?>
</ul>