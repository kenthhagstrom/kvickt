<?php
/**
 * Core
 *
 * The system core class, where all the magic happens.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
class Core {

	public $start;
	private $url = [];
	private $controller = null;

	function __construct() {
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$this->start = $time;
		Session::start();
	}

	function __destruct() {
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $this->start), 4);
		echo 'Loading: '.$total_time.' seconds.';
	}

	function run() {
		$this->get_url();
		$this->load_controller();
		$this->call_controller_method();
	}

	private function get_url() {
		$url = isset( $_GET['url'] ) ? $_GET['url'] : null;
		$url = rtrim( $url, '/' );
		$url = filter_var( $url, FILTER_SANITIZE_URL );
		$this->url = explode( '/', $url );
	}

	private function load_controller() {

		// Load the requested controller
		if ( empty( $this->url[0] ) ) {

			// Default controller
			$this->controller = new Index_Controller;

		} else {

			// Construct the controller name
			$controller = ucfirst( strtolower( $this->url[0] ) ) . '_Controller';

			// Check if the requested controller exists
			if ( class_exists( $controller ) ) {

				$this->controller = new $controller;

			} else {

				trigger_error( 'Error loading controller.', E_USER_NOTICE );
			}
		}
	}

	private function call_controller_method() {

		// Check request length
		$length = count( $this->url );

		if ( $length > 1 ) {
			if ( ! method_exists( $this->controller, $this->url[1] ) ) {
				trigger_error( 'Error loading action.', E_USER_NOTICE );
			}
		}

		/**
		 * NOTE array_shift could be used to force ALL action parameters to be of the
		 *      array type. This way the restriction on the total parameter count
		 *      would be gone. Currently the restriction is 3 parameters.
		 */
		switch ( $length ) {
			case 5:
				$this->controller->{$this->url[1]}( $this->url[2], $this->url[3], $this->url[4] );
			break;
			case 4:
				$this->controller->{$this->url[1]}( $this->url[2], $this->url[3] );
			break;
			case 3:
				$this->controller->{$this->url[1]}( $this->url[2] );
			break;
			case 2:
				$this->controller->{$this->url[1]}();
			break;
			default:
				$this->controller->index();
			break;
		}
	}
}