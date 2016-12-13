<?php
// TODO Move this code out of here!
$errors = Session::get( 'errors' );
Session::set('errors', null );
$form = Session::get('form');

$token = Session::get('token');
if( empty( $token ) ) {
	$token = bin2hex( random_bytes( 32 ) );
	Session::set( 'token', $token );
}
// TODO Expire token after X amount of time
// TODO Create a form builder class, this is ugly
?>
<form action="../user/register" method="post">

	<input type="hidden" name="token" value="<?php echo $token; ?>">
	<span class="error"><?php print isset( $errors['errors']['token'] ) ? $errors['errors']['token']: ''; ?></span>

	<label>Select a username:</label>
	<input name="username" type="text" placeholder="Select a username" value="<?php print isset( $form['username'] ) ? $form['username']: ''; ?>"><br />
	<span class="error"><?php print isset( $errors['errors']['username'] ) ? $errors['errors']['username']: ''; ?></span>

	<label>Email</label>
	<input name="email" type="email" placeholder="Enter your email address" value="<?php print isset( $form['email'] ) ? $form['email']: ''; ?>"><br />
	<span class="error"><?php print isset( $errors['errors']['email'] ) ? $errors['errors']['email']: ''; ?></span>

	<label>Your Password</label>
	<input name="password" type="password" placeholder="Enter your password">

	<label>Confirm Password</label>
	<input name="verify_password" type="password" placeholder="Verify your password">
	<span class="error"><?php print isset( $errors['errors']['password'] ) ? $errors['errors']['password']: ''; ?></span>

	<input type="submit" name="submit_register" value="Register">
</form>

<?php Session::delete('errors'); ?>
<?php Session::delete('form'); ?>