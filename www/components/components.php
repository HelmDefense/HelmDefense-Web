<?php
(new Comp("header", "Header", "<link rel='stylesheet' href='/data/css/nav.css' />"))->register();
(new Comp("footer", "Footer"))->register();
(new Comp("markdowntext", "MarkdownText", array("<script src='/data/plugins/prism/prism.js'></script>", "<link rel='stylesheet' href='/data/plugins/prism/prism.css' />", "<link rel='stylesheet' href='/data/css/markdown.css' />")))->register();
(new Comp("markdowneditor", "MarkdownEditor", array("<link rel='stylesheet' href='https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css'>", "<script src='https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js'></script>", "<script src='/data/plugins/prism/prism.js'></script>", "<link rel='stylesheet' href='/data/plugins/prism/prism.css' />", "<link rel='stylesheet' href='/data/css/markdown.css' />", "<link rel='stylesheet' href='/data/css/markdown-editor.css' />")))->register();
(new Comp("wikisidebar", "WikiSidebar", "<link rel='stylesheet' href='/data/css/wiki.css' />", true))->register();
(new Comp("wikipagepreview", "WikiPagePreview", "<link rel='stylesheet' href='/data/css/wiki.css' />", true))->register();
(new Comp("forumpostlist", "ForumPostList", null, true))->register();
(new Comp("forumsidebar", "ForumSidebar", "<link rel='stylesheet' href='/data/css/forum.css' />"))->register();
(new Comp("captcha", "Captcha", "<script src='https://www.google.com/recaptcha/api.js?onload=loadCaptcha&render=explicit' async defer></script>"))->register();

class Comp extends Element {
	/**
	 * @var string[]
	 */
	private static $componentsTypes = array("View", "Model", "Controller", "Component");

	/**
	 * @param string $name
	 * @param string $class
	 * @param string[]|string $resources
	 * @param bool $db
	 */
	public function __construct($name, $class, $resources = null, $db = false) {
		parent::__construct($name, $class, $resources, $db);
	}

	/**
	 * @inheritDoc
	 */
	public function include() {
		$com = "components/com_$this->name/$this->class";
		foreach (self::$componentsTypes as $type) {
			include_once "components/generic/$type.php";
			include_once "$com$type.php";
		}
	}

	/**
	 * @return void
	 */
	public function register() {
		Utils::$components[$this->name] = $this;
	}
}
