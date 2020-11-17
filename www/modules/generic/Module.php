<?php

/**
 * Generic module
 */
abstract class Module {
	/**
	 * @var Controller Module controller
	 */
	protected $controller;

	/**
	 * Create the module
	 * @param Controller $controller
	 */
	public function __construct($controller) {
		$this->controller = $controller;
	}

	/**
	 * Run the module and get output
	 * @return stdClass The module output
	 */
	public function run() {
		$this->execute();

		$output = new stdClass();
		$output->head = $this->controller->getHead();
		$output->title = $this->controller->getTitle();
		$output->body = $this->controller->getBody();
		return $output;
	}

	/**
	 * Execute the module
	 */
	public abstract function execute();
}