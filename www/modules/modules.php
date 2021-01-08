<?php
// Global modules
Utils::$modules["static"] = new Mod("static", "StaticModule");
Utils::$modules["error"] = new Mod("error", "ErrorModule", "<link rel='stylesheet' href='/data/css/error.css' />");

// Wiki modules
Utils::$modules["wiki/entity"] = // We fake "entity" module to redirect to "home" module
Utils::$modules["wiki/level"] = // We fake "level" module to redirect to "home" module
Utils::$modules["wiki/"] = new Mod("home", "WikiHomeModule", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");
Utils::$modules["wiki/page"] = new Mod("page", "WikiPageModule", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");
Utils::$modules["wiki/search"] = new Mod("search", "WikiSearchModule", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");

class Mod extends Element {
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string|null
	 */
	private $section;

	/**
	 * @param string $name
	 * @param string $class
	 * @param string[]|string $resources
	 * @param bool $db
	 * @param string|null $section
	 */
	public function __construct($name, $class, $resources = array(), $db = false, $section = null) {
		parent::__construct($class, $resources, $db);
		$this->name = $name;
		$this->section = $section;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
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
