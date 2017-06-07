<?php
/**
 * Controller
 *
 * Main controller class.
 *
 * @package Kvickt
 * @subpackage System
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/
 * @author Kenth Hagström <info@kenthhagstrom.se>
 * @version 1.0
 */
abstract class Controller {

	public $view;
	protected $model;

	function __construct() {
		$this->view = new View();
	}

	abstract function index();
}