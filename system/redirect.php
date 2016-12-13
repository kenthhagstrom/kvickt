<?php
/**
 * Redirect
 *
 * Redirect client to a controller and action.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
class Redirect {

	/**
	 * to
	 *
	 * Redirection function.
	 *
	 * @param  string $controller A controller name
	 * @param  string $action     a controller action
	 */
	function to( $controller='', $action = '' ) {
		$c = filter_var( $controller, FILTER_SANITIZE_STRING );
		$a = filter_var( $action, FILTER_SANITIZE_STRING );

		if ( $c == '' ) {
			header('Location: ' . SITE_URL );
			exit;
		}
		header('Location: ' . SITE_URL . $c . DS . $action );
		exit;
	}

}