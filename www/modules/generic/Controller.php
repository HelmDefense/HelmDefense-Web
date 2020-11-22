<?php
namespace Module;

/**
 * Generic controller
 * @package Module
 */
abstract class Controller {
	/**
	 * @var Model Module model
	 */
	protected $model;
	/**
	 * @var View Module view
	 */
	protected $view;

	/**
	 * Create controller
	 * @param Model $model
	 * @param View $view
	 */
	protected function __construct($model, $view) {
		$this->model = $model;
		$this->view = $view;
	}

	/**
	 * Get the module output
	 * @return string The module output
	 */
	public final function getBody() {
		return $this->view->display();
	}

	/**
	 * Get the module additional head elements
	 * @return string|null Additional elements to be added to &lt;head&gt;
	 */
	public abstract function getHead();

	/**
	 * Get the module page title
	 * @return string|null Page title
	 */
	public abstract function getTitle();
}
