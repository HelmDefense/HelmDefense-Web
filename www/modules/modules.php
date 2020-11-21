<?php
Utils::$modules["static"] = new Mod("StaticModule", false);
Utils::$modules["error"] = new Mod("ErrorModule", false);

class Mod {
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
	public function __construct($class, $db) {
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
