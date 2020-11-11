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
	public function getViewDisplay() {
		return $this->view->display();
	}
}
