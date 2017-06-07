<?php
/**
 * Autoload
 *
 * Automagically load files when needed.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
class Autoload {

	static function load_class( $class_name ) {
		$class_name = strtolower( $class_name );
		if ( file_exists( SYS_PATH . $class_name . EXT ) ) {
			include SYS_PATH . $class_name . EXT;
		}
	}

	static function load_controller( $class_name ) {
		$class_name = strtolower( $class_name );
		if ( file_exists( APP_PATH . 'controllers' . DS . $class_name . EXT ) ) {
			include APP_PATH . 'controllers' . DS . $class_name . EXT;
		}
	}

	static function load_model( $class_name ) {
		$class_name = strtolower( $class_name );
		if ( file_exists( APP_PATH . 'models' . DS . $class_name . EXT ) ) {
			include APP_PATH . 'models' . DS . $class_name . EXT;
		}
	}
}

/**
 * SPL Autoload
 *
 * Automagically include required files, only when they are
 * needed by the framework.
 */
spl_autoload_register( ['Autoload', 'load_class'] );
spl_autoload_register( ['Autoload', 'load_controller'] );
spl_autoload_register( ['Autoload', 'load_model'] );