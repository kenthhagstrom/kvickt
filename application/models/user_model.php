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

	function authenticate() {

		$errors = [];
		$form = [];

		$auth = new Auth();

		// Check if the user account has been activated
		$sql = 'SELECT count(*) FROM user JOIN status ON user.id=status.user_id WHERE status.active=1';
		$res = $this->db->query( $sql );
		if( $res->fetchColumn() != 1 ) {
			// Account needs to be activated, redirect
		}

		if ( strlen( $_POST['password'] ) == 0 ) {
			$errors['password'] = 'No password entered.';
		}

		// Get user data
		$sth = $this->db->prepare( "SELECT id,password FROM user WHERE username=:username" );
		$sth->bindValue( ":username", $_POST['username'], PDO::PARAM_STR );
		$sth->execute();

		$data = $sth->fetchAll( PDO::FETCH_ASSOC );

		$count = count( $data );
		if ( ( $count > 0 ) ) {

			if ( false == $this->hash->verify( $_POST['password'], $data[0]['password'] ) ) {
				$errors['password'] = 'Incorrect password.';
			}

		} else {

			$errors['username'] = 'Incorrect username.';
		}

		$form['username'] = filter_var( $_POST['username'], FILTER_SANITIZE_STRING );
		Session::set('errors', $errors );
		Session::set('form', $form );

		// If there are any errors the user is redirected to the login page
		if ( count( $errors ) > 0 ) {
			$this->redirect->to( 'user', 'login' );
		}

		// All checks are passed, authenticate the user
		$auth->approve( $data[0]['id'] );

		Session::delete('token');
		Session::delete('errors');
		Session::delete('form');

		$this->redirect->to( 'dashboard' );
	}

	function logout() {
		$auth = new Auth;
		$auth->revoke();
		$this->redirect->to();
	}

	function edit_save( $data ) {

		$post = array(
			'id' => $data['id'],
			'username' => $data['username'],
			'password' => $this->hash->make( $_POST['password'] )
		);

		$this->db->update( 'user', $post, "`id`={$post['id']}" );
	}

	function delete( $id ) {

		$user_id = (int)$id;

		// FIXME Seriously... Let anyone delete anything... ADD CONTROL!!!
		$this->db->delete( 'user', "id='$id'");
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
		$sql = 'SELECT username FROM user WHERE username=:username';
		$sth = $this->db->prepare( $sql );
		$sth->bindValue( ':username', $_POST['username'], PDO::PARAM_STR );
		$sth->execute();
		$row_count = count( $sth->fetchAll( PDO::FETCH_ASSOC ) );
		if ( $row_count > 0 ) {
			$errors['errors']['username'] = 'Username has already been taken, sorry.';
		}

		// Username must be at least 3 characters
		if ( count_chars( $_POST['username'] ) < 3 ) {
			$errors['errors']['username'] = 'Username is too short, 3 characters is a minimum.';
		}

		$form['username'] = filter_var( $_POST['username'], FILTER_SANITIZE_STRING );

		// Email address must be valid
		if ( false === filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) {
			$errors['errors']['email'] = 'You must enter a valid email address!';
		}

		// Check if email has already been registered
		$sql = 'SELECT email FROM user WHERE email=:email';
		$sth = $this->db->prepare( $sql );
		$sth->bindValue( ':email', $_POST['email'], PDO::PARAM_STR );
		$sth->execute();
		$row_count = count( $sth->fetchAll( PDO::FETCH_ASSOC ) );
		if ( $row_count > 0 ) {
			$errors['errors']['email'] = 'This email address has already been registered, try logging in instead.';
		}

		$form['email'] = filter_var( $_POST['email'], FILTER_SANITIZE_STRING );

		// Passwords must match
		if( $_POST['password'] !== $_POST['verify_password'] ) {
			$errors['errors']['password'] = 'Passwords does not match.';
		}

		// Password can't be blank
		if ( '' == $_POST['password'] ) {
			$errors['errors']['password'] = 'You must specify a password for your account.';
		}

		if ( sizeof( $errors ) > 0 ) {
			Session::set( 'errors', $errors );
			Session::set( 'form', $form );
			$this->redirect->to( 'user', 'register' );
		} else {
			$hashed_password = $this->hash->make( $_POST['password'] );
			$sth = $this->db->prepare( 'INSERT INTO user (username,email,password,code) VALUES (:username,:email,:password,:code)' );
			$sth->bindValue( ":username", $_POST['username'], PDO::PARAM_STR );
			$sth->bindValue( ":email", $_POST['email'], PDO::PARAM_STR );
			$sth->bindValue( ":password", $hashed_password, PDO::PARAM_STR );
			$sth->bindValue( ":code", bin2hex( random_bytes(3) ), PDO::PARAM_STR );
			$sth->execute();
			Session::delete('token');
			$this->redirect->to( 'user', 'activate' );
		}
	}
}