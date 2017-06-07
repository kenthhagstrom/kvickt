<?php
/**
 * Hash
 *
 * Hash encode strings.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
class Hash {

	/**
	 * Generate hash
	 *
	 * @access public
	 * @param string $data The data to hash encode
	 * @return string
	 */
	public function make( $data, $options = ['cost'=>10] ) {
		return password_hash( $data, PASSWORD_BCRYPT, $options );
	}

	/**
	 * Verify hash string
	 *
	 * @access public
	 * @param string $data The string to verify
	 * @param string $hash A generated hash string
	 */
	public function verify( $data, $hash ) {
		return password_verify( $data, $hash );
	}
}