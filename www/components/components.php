<?php
Utils::$components["header"] = new Comp("HeaderComponent", "<link rel='stylesheet' href='/data/css/nav.css' />");
Utils::$components["footer"] = new Comp("FooterComponent");
Utils::$components["markdowntext"] = new Comp("MarkdownTextComponent", array("<script src='/data/plugins/prism/prism.js'></script>", "<link rel='stylesheet' href='/data/plugins/prism/prism.css' />", "<link rel='stylesheet' href='/data/css/markdown.css' />"));
Utils::$components["markdowneditor"] = new Comp("MarkdownEditorComponent", array("<link rel='stylesheet' href='https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css'>", "<script src='https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js'></script>", "<script src='/data/plugins/prism/prism.js'></script>", "<link rel='stylesheet' href='/data/plugins/prism/prism.css' />", "<link rel='stylesheet' href='/data/css/markdown.css' />", "<link rel='stylesheet' href='/data/css/markdown-editor.css' />"));
Utils::$components["wikisidebar"] = new Comp("WikiSidebarComponent", "<link rel='stylesheet' href='/data/css/wiki.css' />", true);
Utils::$components["wikipagepreview"] = new Comp("WikiPagePreviewComponent", "<link rel='stylesheet' href='/data/css/wiki.css' />", true);

class Comp extends Element {
	/**
	 * @param string $class
	 * @param string[]|string $resources
	 * @param bool $db
	 */
	public function __construct($class, $resources = array(), $db = false) {
		parent::__construct($class, $resources, $db);
	}
}
