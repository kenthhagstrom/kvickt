<?php
/**
 * Model
 *
 * The main model.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
class Model {

	protected $db = null;

	public function __construct() {
		$this->db = new Database( DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS );
	}
}