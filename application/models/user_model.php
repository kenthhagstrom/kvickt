<?php

class User_Model extends Model {

	function __construct() {
		parent::__construct();

		$this->hash = new Hash;
		$this->redirect = new Redirect;
	}

	function list_all() {
		return $this->db->select( 'SELECT * FROM user' );
	}

	function list_single( $id ) {
		return $this->db->select( 'SELECT * FROM user WHERE id=:userid', array( ':userid' => $id ) );
	}

	function activate_account( $code ) {

		$sql = 'SELECT id, user_id FROM status WHERE code=:code AND active=0';
		$sth = $this->db->prepare( $sql );
		$sth->bindValue( ':code', $code, PDO::PARAM_STR );
		$sth->execute();
		$data = $sth->fetchAll( PDO::FETCH_ASSOC );

		if ( count( $data ) > 0 ) {
			$user_id = $data[0]['user_id'];
		} else {
			return false;
		}

		$sql = 'UPDATE status SET active=1 WHERE user_id=:id';
		$sth = $this->db->prepare( $sql );
		$sth->bindValue( ':id', $user_id, PDO::PARAM_INT );
		$sth->execute();
		return true;
	}

	function authenticate() {

		// Initialize arays
		$errors = [];
		$form = [];

		// Create new Authorize object
		$auth = new Auth();

		$query = $this->db->prepare( "SELECT id,username,password FROM user WHERE username=:username" );
		$query->bindValue( ":username", $_POST['username'], PDO::PARAM_STR );
		$query->execute();
		$data = $query->fetch( PDO::FETCH_ASSOC );

		// If not a s ingle row is returned, the username is invalid
		if( $data['username'] !== $_POST['username'] ) {
			$errors['username'] = 'There is no user with that username in our database!';
		}

		// ...username valid, set form data value
		$form['username'] = $data['username'];

		// Check password length
		if ( strlen( $_POST['password'] ) == 0 ) {
			$errors['password'] = 'You must enter your password!';
		}

		// Check if password is correct
		if ( false == $this->hash->verify( $_POST['password'], $data['password'] ) ) {
			$errors['password'] = 'The password entered is not correct!';
		}

		// Set user id
		$user_id = (int)$data['id'];

		// Check if the user account has previously has been activated
		$query = $this->db->prepare( 'SELECT count(*) FROM user JOIN status ON user.id=status.user_id WHERE status.active=1 AND user.id=:user_id' );
		$query->bindValue( ':user_id', $user_id, PDO::PARAM_INT );
		$query->execute();
		if( $query->fetchColumn() != 1 ) {
			// Account needs to be activated, redirect
			$errors['activation'] = 'Your account has not been activated.';
			$this->redirect->to( 'user', 'activate' );
		}

		Session::set('errors', $errors );
		Session::set('form', $form );

		// If there are any errors the user is redirected to the login page
		if ( count( $errors ) > 0 ) {
			$this->redirect->to( 'user', 'login' );
		}

		// Authenticate the user
		$auth->approve( $user_id );

		// Remove temporary data
		Session::delete('token');
		Session::delete('errors');
		Session::delete('form');

		// Redirect user to dashboard
		$this->redirect->to( 'dashboard' );
	}

	function logout() {
		$auth = new Auth;
		$auth->revoke();
		$this->redirect->to();
	}

	function edit_save() {

		$id = Session::get('user_id');
		$id = (int)$id;

		$errors = [];
		$form = [];

		// Username must be alphanumerical
		if ( false === filter_var( $_POST['name'], FILTER_SANITIZE_STRING ) ) {
			$errors['name'] = 'Name must be alphabetic.';
		}
		$form['name'] = filter_var( $_POST['name'], FILTER_SANITIZE_STRING );

		if ( sizeof( $errors ) > 0 ) {
			Session::set( 'errors', $errors );
			Session::set( 'form', $form );
			$this->redirect->to( 'user', 'edit' );
		} else {

			$post = array(
				'name' => $_POST['name']
			);
			$this->db->update( 'user', $post, "`id`={$id}" );
		}
	}

	function delete( $id ) {

		$user_id = (int)$id;

		// FIXME Seriously... Let anyone delete anything... ADD CONTROL!!!
		$this->db->delete( 'user', "id='$id'");
	}

	private function is_username_available( $username ) {
		$sql = 'SELECT username FROM user WHERE username=:username';
		$sth = $this->db->prepare( $sql );
		$sth->bindValue( ':username', $username, PDO::PARAM_STR );
		$sth->execute();
		$row_count = count( $sth->fetchAll( PDO::FETCH_ASSOC ) );
		if ( $row_count > 0 ) {
			return false;
		}
		return true;
	}

	private function is_email_available( $email ) {
		$sql = 'SELECT email FROM user WHERE email=:email';
		$sth = $this->db->prepare( $sql );
		$sth->bindValue( ':email', $_POST['email'] );
		$sth->execute();
		$row_count = count( $sth->fetchAll( PDO::FETCH_ASSOC ) );
		if ( $row_count > 0 ) {
			return true;
		}
		return false;
	}

	function get_userdata( $field_name ) {
		$field = filter_var( $field_name, FILTER_SANITIZE_STRING );
		$user_id = Session::get('user_id');
		$sth = $this->db->prepare( "SELECT $field FROM user WHERE id=:user_id" );
		$sth->bindValue( ":user_id", $user_id, PDO::PARAM_STR );
		$sth->execute();
		$data = $sth->fetch( PDO::FETCH_ASSOC );
		return $data[$field];
	}

	function register() {

		$errors = [];
		$form = [];

		$token = Session::get('token');
		if ( $token !== $_POST['token'] ) {
			$errors['errors']['token'] = 'Are you being naughty? Form token is invalid.';
			Session::set( 'errors', $errors );
			$this->redirect->to( 'user', 'register' );
		}

		// Username must be alphanumerical
		if ( false === ctype_alnum( $_POST['username'] ) ) {
			$errors['username'] = 'Username must be alphanumerical.';
		}

		// Check if username is available
		if( false === $this->is_username_available( $_POST['username']) ) {
			$errors['username'] = 'Username has already been taken, sorry.';
		}

		// Username must be at least 3 characters
		if ( count_chars( $_POST['username'] ) < 3  || $_POST['username'] == '' ) {
			$errors['username'] = 'Username is too short, 3 characters is a minimum.';
		}

		$form['username'] = filter_var( $_POST['username'], FILTER_SANITIZE_STRING );

		// Email address must be valid
		if ( false === filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) {
			$errors['email'] = 'You must enter a valid email address!';
		}

		// Check if email has already been registered
		//if ( false == $this->is_email_available( $_POST['email'] ) ) {
		//	$errors['errors']['email'] = 'This email address has already been registered, try logging in instead.';
		//}

		$form['email'] = filter_var( $_POST['email'], FILTER_SANITIZE_STRING );

		// Passwords must match
		if( $_POST['password'] !== $_POST['verify_password'] ) {
			$errors['password'] = 'Passwords does not match.';
		}

		// Password can't be blank
		if ( '' == $_POST['password'] ) {
			$errors['password'] = 'You must specify a password for your account.';
		}

		if ( sizeof( $errors ) > 0 ) {
			Session::set( 'errors', $errors );
			Session::set( 'form', $form );
			$this->redirect->to( 'user', 'register' );
		} else {

			// Generate password hash
			$hashed_password = $this->hash->make( $_POST['password'] );

			// Generate random activation string
			$activation_code = bin2hex( random_bytes(3) );

			// Insert user data into the database
			$sth = $this->db->prepare( 'INSERT INTO user (username,email,password) VALUES (:username,:email,:password)' );
			$sth->bindValue( ":username", $_POST['username'], PDO::PARAM_STR );
			$sth->bindValue( ":email", $_POST['email'], PDO::PARAM_STR );
			$sth->bindValue( ":password", $hashed_password, PDO::PARAM_STR );
			$sth->execute();

			// Get ID from the last row inserted
			$user_id = $this->db->lastInsertId();

			// Insert the activation code into the database table
			$sth = $this->db->prepare( 'INSERT INTO status (code,user_id) VALUES (:code,:user_id)' );
			$sth->bindValue( ":code", $activation_code, PDO::PARAM_STR );
			$sth->bindValue( ":user_id", $user_id, PDO::PARAM_INT );
			$sth->execute();

			// Create and send message with activation code to the user
			$msg = "Go to <a href='".SITE_URL."user/activate/'>Our Awesome Website</a> and enter your activation code to ativate your accont. Your code is: $activation_code";
			if( mail( $_POST['email'], 'Activate your account', $msg ) ) {
				// TODO Make sending emails prettier
			}

			// Clear temporary data, in case there are any left-overs from the form sending process
			Session::delete('token');
			Session::delete('errors');
			Session::delete('form');

			// Redirect user to activation page
			$this->redirect->to( 'user', 'activate' );
		}
	}
}