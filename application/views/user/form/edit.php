<?php $form = new Form( 'user', 'edit' ); ?>

<form action="<?php echo $form->action; ?>" method="post">

	<input type="hidden" name="token" value="<?php echo $form->token; ?>">
	<span class="error"><?php echo $form->error('token'); ?></span>

	<label>Username</label><p>// TODO Get user data from db</p>

	<label>Your Name</label>
	<input name="name" type="text" placeholder="Your name" value="<?php print isset($this->name) ? $this->name : $form->value('name'); ?>"><br />
	<span class="error"><?php echo $form->error('name'); ?></span>

	<br><input type="submit" value="Update">
</form>