<?php
Utils::$modules["static"] = new Mod("StaticModule");
Utils::$modules["error"] = new Mod("ErrorModule");
Utils::$modules["wiki/"] = Utils::$modules["wiki/page"] = new Mod("WikiPageModule", true, "wiki");

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
	 * @var string|null
	 */
	private $section;

	/**
	 * @param string $class
	 * @param bool $db
	 * @param string|null $section
	 */
	public function __construct($class, $db = false, $section = null) {
		$this->class = $class;
		$this->db = $db;
		$this->section = $section;
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

	/**
	 * @return bool
	 */
	public function isGlobal() {
		return is_null($this->section);
	}

	/**
	 * @return string|null
	 */
	public function getSection() {
		return $this->section;
	}
}
