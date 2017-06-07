<?php

class Index_Model extends Model {

	function __construct() {
		parent::__construct();
	}

	function get_welcome_message() {
		$data = 'This page is brought to you by <strong>'.get_class().'</strong>, it\'s here just to show functionality.';
		return $data;
	}
}