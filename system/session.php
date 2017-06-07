<?php
/**
 * Session
 *
 * Session manager.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
class Session {

	static function start() {
		@session_start();
	}

	static function set( $key, $value ) {
		$_SESSION[ $key ] = $value;
	}

	static function get( $key ) {
		if ( isset( $_SESSION[ $key ] ) ) {
			return  $_SESSION[ $key ];
		}
		return null;
	}

	static function delete( $key ) {
		if( isset($_SESSION[ $key ]) ) {
			unset( $_SESSION[ $key ] );
		}
	}

	static function destroy() {
		session_destroy();
	}
}