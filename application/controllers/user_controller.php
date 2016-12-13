<?php

class User_Controller extends Controller {

	function __construct() {
		parent::__construct();

		$this->model = new User_Model();

		$this->auth = new Auth;
		$this->redirect = new Redirect;

		$this->view->loggedin = Session::get('logged_in');
		$this->view->title = 'User Controller';
	}

	function activate() {

		// If the user is already logged in there is no need to activate an account
		if( true === $this->auth->ok() ) {
			$this->redirect->to( 'user' ); // TODO Redirect elsewhere?
		}

		// Has the form been sent or not
		if( count( $_POST ) > 0 ) {
			if ( true == $this->model->activate_account( $_POST['code'] ) ) {
				// TODO Display message or redirect to login?
				$this->redirect->to( 'user', 'login' );
			}
		}
		$this->view->render('user/activate' );
	}

	function index() {
		$this->login();
	}

	function login() {
		if ( count( $_POST ) > 0 ) {
			$this->model->authenticate();
		} else {
			if( true === $this->auth->ok() ) {
				$this->view->title = 'Logged in';
			} else {
				$this->view->title = 'Log in to your account';
			}
			$this->view->render('user/index' );
		}
	}

	function logout() {
		$this->model->logout();
	}

	function register() {
		if ( count( $_POST ) > 0 ) {
			$this->model->register();
		} else {
			$this->view->title = 'Sign up for a FREE account!';
			$this->view->render('user/register' );
		}
	}

	function view( $id = 0 ) {
		$user_id = (int)$id;
		if( $user_id != 0 ) {
			$this->view->userdata = $this->model->list_single( $user_id );
		} else {
			$this->view->userdata = $this->model->list_all();
		}
		$this->view->render('user/view');
	}
}