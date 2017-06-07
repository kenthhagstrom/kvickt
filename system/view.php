<?php
/**
 * View
 *
 * The main view.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
class View {

	function __construct() {
	}

	function render( $template_part ) {
		if ( file_exists( APP_PATH . DS . 'views' . DS . $template_part . EXT ) ) {
			require APP_PATH . DS . 'views' . DS . $template_part . EXT;
		} else {
			trigger_error( 'Error loading <strong>'. $template_part.'</strong>.', E_USER_NOTICE ); // TODO Better error handling
		}
	}
}