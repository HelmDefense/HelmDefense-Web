<?php
namespace Module;

/**
 * Generic view
 * @package Module
 */
abstract class View {
	/**
	 * @var string The buffer content
	 */
	private $buffer;

	/**
	 * Create view and start output buffering
	 */
	public final function __construct() {
		ob_start();
	}

	/**
	 * End output buffering and return buffer content
	 * @return string The buffer content
	 */
	public final function display() {
		if (!($buffer = ob_get_clean()))
			return $this->buffer;
		return $this->buffer = $buffer;
	}
}
