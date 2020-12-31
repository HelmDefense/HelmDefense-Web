<?php
Utils::$components["header"] = new Comp("HeaderComponent", "<link rel='stylesheet' href='/data/css/nav.css' />");
Utils::$components["footer"] = new Comp("FooterComponent");
Utils::$components["markdowntext"] = new Comp("MarkdownTextComponent", array("<script src='/data/plugins/prism/prism.js'></script>", "<link rel='stylesheet' href='/data/plugins/prism/prism.css' />", "<link rel='stylesheet' href='/data/css/markdown.css' />"));
Utils::$components["wikisidebar"] = new Comp("WikiSidebarComponent", "<link rel='stylesheet' href='/data/css/wiki.css' />", true);
Utils::$components["wikipagepreview"] = new Comp("WikiPagePreviewComponent", "<link rel='stylesheet' href='/data/css/wiki.css' />", true);

class Comp {
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
	 * @param string $class
	 * @param string[]|string $resources
	 * @param bool $db
	 */
	public function __construct($class, $resources = array(), $db = false) {
		$this->class = $class;
		$this->resources = is_array($resources) ? $resources : array($resources);
		$this->db = $db;
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
}
