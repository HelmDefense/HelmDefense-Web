<?php
namespace Module;

/**
 * Generic module controller
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
	 * @var string The page title
	 */
	protected $title;

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
	 * Get the module page title
	 * @return string|null Page title
	 */
	public final function getTitle() {
		return $this->title;
	}
}
