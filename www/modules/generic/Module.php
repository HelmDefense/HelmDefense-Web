<?php
namespace Module;

use stdClass;

/**
 * Generic module
 * @package Module
 */
abstract class Module {
	/**
	 * @var Controller Module controller
	 */
	protected $controller;
	/**
	 * @var string The module title
	 */
	private $title;

	/**
	 * Create the module
	 * @param Controller $controller
	 * @param string|null $title
	 */
	protected function __construct($controller, $title = null) {
		$this->controller = $controller;
		$this->title = $title;
	}

	/**
	 * Run the module and get output
	 * @return stdClass The module output
	 */
	public final function run() {
		$this->execute();

		$output = new stdClass();
		$output->title = implode(" - ", array_filter(array($this->controller->getTitle(), $this->title)));
		$output->body = $this->controller->getBody();
		return $output;
	}

	/**
	 * Execute the module
	 */
	protected abstract function execute();
}
