<?php
Utils::$components["header"] = new Comp("HeaderComponent");
Utils::$components["footer"] = new Comp("FooterComponent");
Utils::$components["markdowntext"] = new Comp("MarkDownTextComponent");

class Comp {
	/**
	 * @var string
	 */
	private $class;
	/**
	 * @var bool
	 */
	private $db;

	/**
	 * @param string $class
	 * @param bool $db
	 */
	public function __construct($class, $db = false) {
		$this->class = $class;
		$this->db = $db;
	}

	/**
	 * @return string
	 */
	public function className() {
		return $this->class;
	}

	/**
	 * @return bool
	 */
	public function needsDatabase() {
		return $this->db;
	}
}
