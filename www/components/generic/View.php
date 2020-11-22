<?php
namespace Component;

/**
 * Generic component view
 * @package Component
 */
abstract class View {
	/**
	 * @var string|null The buffer content
	 */
	private $buffer = null;

	/**
	 * Start output buffering
	 */
	public final function preRender() {
		ob_start();
	}

	/**
	 * End output buffering
	 */
	public final function postRender() {
		$this->buffer = ob_get_clean();
	}

	/**
	 * @return string|null The rendered content or null if the component hasn't been rendered yet
	 */
	public final function display() {
		return $this->buffer;
	}
}
