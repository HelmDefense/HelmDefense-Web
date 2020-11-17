<?php

/**
 * Generic controller
 */
abstract class Controller {
	/**
	 * @var Model Module model
	 */
	protected $model;
	/**
	 * @var View Model view
	 */
	protected $view;

	/**
	 * Create controller
	 * @param Model $model
	 * @param View $view
	 */
	public function __construct($model, $view) {
		$this->model = $model;
		$this->view = $view;
	}

	/**
	 * Get the module output
	 * @return string The module output
	 */
	public function getBody() {
		return $this->view->display();
	}

	/**
	 * Get the module additional head elements
	 * @return string Additional elements to be added to &lt;head&gt;
	 */
	public abstract function getHead();

	/**
	 * Get the module page title
	 * @return mixed Page title
	 */
	public abstract function getTitle();
}
