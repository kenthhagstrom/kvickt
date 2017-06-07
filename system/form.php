<?php
/**
 * Form
 *
 * Manage all data handling through forms.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
class Form {

	private $errors = [];
	private $data = [];

	public $action;

	// Set where to post form data, controller and action
	function __construct( $controller, $action ) {

		$this->set_action( $controller, $action );

		// Generate form token
		$this->token = Session::get('token');
		if( empty( $this->token ) ) {
			$this->token = bin2hex( random_bytes( 32 ) );
			Session::set( 'token', $this->token );
		}
	}

	function __destruct() {
		$this->clear();
	}

	function error( $field ) {
		$errors = Session::get('errors');
		if ( count( $errors ) > 0 ) {
			if ( isset( $errors[ $field ] ) ) {
				return $errors[ $field ];
			}
		}
	}

	function value( $field ) {
		$data = Session::get('form');
		if ( count( $data ) > 0 ) {
			if ( isset( $data[ $field ] ) ) {
				return $data[ $field ];
			}
		}
	}

	/**
	 * Token
	 *
	 * @return string A randomly generated string
	 */
	function token() {
		return $this->token;
	}

	/**
	 * Set form action
	 *
	 * @param string $controller The controller that will process form data
	 * @param string $action     The controller method that will handle form data
	 */
	function set_action( $controller, $action ) {
		$this->action = SITE_URL . $controller . DS . $action;
	}

	/**
	 * Clear stored form error messages and input data
	 */
	function clear() {
		Session::delete('errors');
		Session::delete('form');
	}
}