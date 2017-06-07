<?php

class Dashboard_Controller extends Controller {

	function __construct() {
		parent::__construct();

		$this->auth = new Auth;
		$this->redirect = new Redirect;

		if( true !== $this->auth->ok() ) {
			$this->redirect->to( 'user', 'login' );
		}
	}

	function index() {
		$this->view->title = 'Dashboard';
		$this->view->render('dashboard/index' );
	}
}