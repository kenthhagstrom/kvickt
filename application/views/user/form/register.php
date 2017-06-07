<?php $form = new Form( 'user', 'register' ); ?>

<form action="<?php echo $form->action; ?>" method="post">

	<input type="hidden" name="token" value="<?php echo $form->token; ?>">
	<span class="error"><?php echo $form->error('token'); ?></span>

	<label>Select a username:</label>
	<input name="username" type="text" placeholder="Select a username" value="<?php echo $form->value('username'); ?>"><br />
	<span class="error"><?php echo $form->error('username'); ?></span>

	<label>Email</label>
	<input name="email" type="email" placeholder="Enter your email address" value="<?php echo $form->value('email'); ?>"><br />
	<span class="error"><?php echo $form->error('email'); ?></span>

	<label>Your Password</label>
	<input name="password" type="password" placeholder="Enter your password">

	<label>Confirm Password</label>
	<input name="verify_password" type="password" placeholder="Verify your password">
	<span class="error"><?php echo $form->error('password'); ?></span>

	<input type="submit" name="submit_register" value="Register">
</form>