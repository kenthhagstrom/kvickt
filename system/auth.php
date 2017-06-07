<?php
/**
 * Auth
 *
 * User authentication.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
class Auth {

	function __construct() {
		$this->hash = new Hash();
	}

	public function approve( $user_id ) {
		$user_id = (int)$user_id;
		$user_agent_hash = $this->hash->make( $_SERVER['HTTP_USER_AGENT'] );
		Session::set( 'user_agent', $user_agent_hash );
		Session::set( 'logged_in', true );
		Session::set( 'user_id', $user_id );

	}

	public function revoke() {
		Session::destroy();
	}

	public function ok() {

		// Verify client User Agent
		$ua = Session::get('user_agent');
		if ( false === $this->hash->verify( $_SERVER['HTTP_USER_AGENT'], $ua ) ) {
			Session::destroy();
			return false;
		}

		// Check logged_in value
		if ( ( false === Session::get('logged_in') ) ) {
			Session::destroy();
			return false;
		}
		return true;
	}
}