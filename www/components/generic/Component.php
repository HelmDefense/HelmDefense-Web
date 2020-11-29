<?php
namespace Component;

/**
 * Generic component
 * @package Component
 */
abstract class Component {
	/**
	 * @var Controller Component controller
	 */
	protected $controller;

	/**
	 * Create the component
	 * @param Controller $controller
	 */
	protected function __construct($controller) {
		$this->controller = $controller;
	}

	/**
	 * Generate the render of the component
	 */
	public final function generateRender() {
		$this->controller->enableRenderMode();

		$this->calculateRender();

		$this->controller->disableRenderMode();
	}

	/**
	 * Calculate the render of the component
	 */
	protected abstract function calculateRender();

	/**
	 * Display the component
	 */
	public final function display() {
		echo $this->controller->display();
	}
}
