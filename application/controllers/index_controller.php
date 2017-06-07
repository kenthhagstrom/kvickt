<?php

class Index_Controller extends Controller {

	function __construct() {
		parent::__construct();

		$this->model = new Index_Model();
	}

	function index() {
		$this->view->title = 'Main Page';
		$this->view->message = $this->model->get_welcome_message();
		$this->view->render( 'index/index' );
	}
}