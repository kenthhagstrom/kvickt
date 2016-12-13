<form action="<?php echo SITE_URL . 'user/activate'; ?>" method="post" name="account_activation">
	<label>Activation Code</label>
	<input name="code" type="text" placeholder="Enter activation code"><br>
	<span class="error"><?php print isset( $errors['code'] ) ? $errors['code']: ''; ?></span>
	<br><input type="submit" value="Activate Account">
</form>