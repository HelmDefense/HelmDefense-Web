<?php
// Global modules
Utils::$modules["static"] = new Mod("static", "StaticModule");
Utils::$modules["error"] = new Mod("error", "ErrorModule", "<link rel='stylesheet' href='/data/css/error.css' />");

// Wiki modules
Utils::$modules["wiki/entity"] = // We fake "entity" module to redirect to "home" module
Utils::$modules["wiki/level"] = // We fake "level" module to redirect to "home" module
Utils::$modules["wiki/"] = new Mod("home", "WikiHomeModule", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");
Utils::$modules["wiki/page"] = new Mod("page", "WikiPageModule", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");
Utils::$modules["wiki/search"] = new Mod("search", "SearchModule", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");
Utils::$modules["user/logout"] = // We fake "logout" module to redirect to "login" module
Utils::$modules["user/login"] = new Mod("login", "UserLoginModule", "<link rel='stylesheet' href='/data/css/user.css' />", true, "user");
Utils::$modules["user/signin"] = new Mod("signin", "UserSigninModule", array(), true, "user");

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
	 * @var string[]
	 */
	private $resources;
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
	 * @param string[]|string $resources
	 * @param bool $db
	 * @param string|null $section
	 */
	public function __construct($name, $class, $resources = array(), $db = false, $section = null) {
		$this->name = $name;
		$this->class = $class;
		$this->resources = is_array($resources) ? $resources : array($resources);
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
	 * @return string[]
	 */
	public function getResources() {
		return $this->resources;
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
