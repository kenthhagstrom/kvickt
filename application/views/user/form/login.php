<?php $form = new Form( 'user', 'login' ); ?>

<form action="<?php echo $form->action; ?>" method="post">

	<input type="hidden" name="token" value="<?php echo $form->token; ?>">
	<span class="error"><?php echo $form->error('token'); ?></span>

	<label>Username</label>
	<input name="username" type="text" placeholder="username" value="<?php echo $form->value('username'); ?>"><br />
	<span class="error"><?php echo $form->error('username'); ?></span>

	<label>Password</label>
	<input name="password" type="password" placeholder="username" value="<?php echo $form->value('password'); ?>"><br />
	<span class="error"><?php echo $form->error('password'); ?></span>

	<br><input type="submit" value="Login">
</form>

<p>Want access to all the good stuff? <a href="/user/register">Sign up for a FREE account</a>!</p>