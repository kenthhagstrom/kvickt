<?php
// TODO Move this code out of here!
$errors = Session::get( 'errors' );
Session::set('errors', null );
$form = Session::get('form');

$token = Session::get('token');
if( empty( $token ) ) {
	$token = [];
	$token['hash'] = bin2hex( random_bytes( 32 ) );
	$token['time'] = time();
	Session::set( 'token', $token );
}
// TODO Expire token after X amount of time
// TODO Create a form builder class, this is ugly

?>

<form action="<?php echo SITE_URL . 'user/login'; ?>" method="post">
	<label>Username</label>
	<input name="username" type="text" placeholder="Enter your username" value="<?php print isset( $form['username'] ) ? $form['username'] : ''; ?>"><br>
	<span class="error"><?php print isset( $errors['username'] ) ? $errors['username']: ''; ?></span>

	<label>Password</label>
	<input name="password" type="password" placeholder="Enter your password"><br/>
	<span class="error"><?php print isset( $errors['password'] ) ? $errors['password']: ''; ?></span>

	<br><input type="submit" value="Login">
</form>

<p>Want access to all the good stuff? <a href="/user/register">Sign up for a FREE account</a>!</p>

<?php Session::delete('errors'); ?>
<?php Session::delete('form'); ?>