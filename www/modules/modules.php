<?php
// Global modules
Utils::$modules["static"] = new Mod("static", "Static");
Utils::$modules["error"] = new Mod("error", "Error", "<link rel='stylesheet' href='/data/css/error.css' />");

// Wiki modules
Utils::$modules["wiki/entity"] = // We fake "entity" module to redirect to "home" module
Utils::$modules["wiki/level"] = // We fake "level" module to redirect to "home" module
Utils::$modules["wiki/"] = new Mod("home", "WikiHome", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");
Utils::$modules["wiki/page"] = new Mod("page", "WikiPage", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");
Utils::$modules["wiki/search"] = new Mod("search", "WikiSearch", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");

// Forum module
Utils::$modules["forum/talk"] = // We fake "talk" module to redirect to "home" module
Utils::$modules["forum/rate"] = // We fake "rate" module to redirect to "home" module
Utils::$modules["forum/strat"] = // We fake "strat" module to redirect to "home" module
Utils::$modules["forum/"] = new Mod("home", "ForumHome", "<link rel='stylesheet' href='/data/css/forum.css' />", true, "forum");

class Mod extends Element {
	/**
	 * @var string|null
	 */
	private $section;

	/**
	 * @var string
	 */
	private $full_section;

	/**
	 * @var string[]
	 */
	private static $modulesTypes = array("View", "Model", "Controller", "Module");

	/**
	 * @param string $name
	 * @param string $class
	 * @param string[]|string $resources
	 * @param bool $db
	 * @param string|null $section
	 */
	public function __construct($name, $class, $resources = array(), $db = false, $section = null) {
		parent::__construct($name, $class, $resources, $db);
		$this->section = $section;
		$this->full_section = $this->isGlobal() ? "" : $this->section . "/";
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

	/**
	 * @inheritDoc
	 */
	public function include() {
		$mod = "modules/{$this->full_section}mod_$this->name/$this->class";
		foreach (self::$modulesTypes as $type) {
			include_once "modules/generic/$type.php";
			include_once "$mod$type.php";
		}
	}
}
