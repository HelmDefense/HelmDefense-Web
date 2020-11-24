<?php
Utils::$modules["static"] = new Mod("static", "StaticModule");
Utils::$modules["error"] = new Mod("error", "ErrorModule");
Utils::$modules["wiki/"] = //new Mod("home", "WikiHomeModule", true, "wiki"); // Thanks to the comment, the default wiki module is wiki/page
Utils::$modules["wiki/page"] = new Mod("page", "WikiPageModule", true, "wiki");

class Mod {
	/**
	 * @var string
	 */
	private $name;
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
	 * @param string $name
	 * @param string $class
	 * @param bool $db
	 * @param string|null $section
	 */
	public function __construct($name, $class, $db = false, $section = null) {
		$this->name = $name;
		$this->class = $class;
		$this->db = $db;
		$this->section = $section;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
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
