<?php $form = new Form( 'user', 'activate' ); ?>

<form action="<?php echo $form->action; ?>" method="post">

	<input type="hidden" name="token" value="<?php echo $form->token; ?>">
	<span class="error"><?php echo $form->error('token'); ?></span>

	<label>Activation Code</label>
	<input name="code" type="text" placeholder="activation code" value="<?php echo $form->value('code'); ?>"><br />
	<span class="error"><?php echo $form->error('code'); ?></span>

	<br><input type="submit" value="Activate Account">
</form>