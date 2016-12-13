<?php

class User_Controller extends Controller {

	function __construct() {
		parent::__construct();

		$this->model = new User_Model();

		$this->view->loggedin = Session::get('logged_in');
		$this->view->title = 'User Controller';
	}

	function activate() {
		$this->view->render('user/activate' );
	}

	function index() {
		$this->login();
	}

	function login() {
		if ( count( $_POST ) > 0 ) {
			$this->model->authenticate();
		} else {
			$this->view->title = 'Log in to your account';
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