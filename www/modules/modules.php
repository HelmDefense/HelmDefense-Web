<?php
// Global modules
Utils::$modules["static"] = new Mod("static", "Static");
Utils::$modules["error"] = new Mod("error", "Error", "<link rel='stylesheet' href='/data/css/error.css' />");

// Wiki modules
Utils::$modules["wiki/entity"] = // We fake "entity" module to redirect to "home" module
Utils::$modules["wiki/level"] = // We fake "level" module to redirect to "home" module
Utils::$modules["wiki/"] = new Mod("home", "WikiHome", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");
Utils::$modules["wiki/page"] = new Mod("page", "WikiPage", "<link rel='stylesheet' href='/data/css/wiki.css' />", true, "wiki");
Utils::$modules["wiki/search"] = new Mod("search", "WikiSearch", array("<link rel='stylesheet' href='/data/css/wiki.css' />", "<link rel='stylesheet' href='/data/css/form.css' />"), true, "wiki");

// User modules
Utils::$modules["user/"] = // We fake "user" module to redirect to "profile" module
Utils::$modules["user/settings"] = // We fake "settings" module to redirect to "profile" module
Utils::$modules["user/profile"] = new Mod("profile", "UserProfile", "<link rel='stylesheet' href='/data/css/profile.css' />", true, "user");
Utils::$modules["user/logout"] = // We fake "logout" module to redirect to "login" module
Utils::$modules["user/login"] = new Mod("login", "UserLogin", "<link rel='stylesheet' href='/data/css/user.css' />", true, "user");
Utils::$modules["user/signin"] = new Mod("signin", "UserSignin", "<link rel='stylesheet' href='/data/css/user.css' />", true, "user");

// Forum modules
Utils::$modules["forum/talk"] = // We fake "talk" module to redirect to "home" module
Utils::$modules["forum/rate"] = // We fake "rate" module to redirect to "home" module
Utils::$modules["forum/strat"] = // We fake "strat" module to redirect to "home" module
Utils::$modules["forum/"] = new Mod("home", "ForumHome", "<link rel='stylesheet' href='/data/css/forum.css' />", true, "forum");
Utils::$modules["forum/post"] = new Mod("post", "ForumPost", "<link rel='stylesheet' href='/data/css/forum.css' />", true, "forum");

// Panel modules
Utils::$modules["panel/"] = new Mod("home", "PanelHome", "<link rel='stylesheet' href='/data/css/panel.css' />", false, "panel");
Utils::$modules["panel/redac"] = new Mod("redac", "PanelRedac", "<link rel='stylesheet' href='/data/css/panel.css' />", true, "panel");

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
	public function __construct($name, $class, $resources = null, $db = false, $section = null) {
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
