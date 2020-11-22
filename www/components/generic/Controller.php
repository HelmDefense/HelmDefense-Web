<?php
namespace Component;

/**
 * Generic component controller
 * @package Component
 */
abstract class Controller {
	/**
	 * @var Model Component model
	 */
	protected $model;
	/**
	 * @var View Component view
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
	 * Launch component rendering
	 */
	public final function enableRenderMode() {
		$this->view->preRender();
	}

	/**
	 * End component rendering
	 */
	public final function disableRenderMode() {
		$this->view->postRender();
	}

	/**
	 * Get the component display
	 * @return string|null The component display, or null if the component hasn't been rendered yet
	 */
	public final function display() {
		return $this->view->display();
	}
}
