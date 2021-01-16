<?php
namespace Component;

class MarkdownEditorModel extends Model {
	private $defaultConfig = array(
			"blockStyles" => array(
					"italic" => "_"
			),
			"forceSync" => true,
			"parsingConfig" => array(
					"allowAtxHeaderWithoutSpace" => true
			),
			"spellChecker" => false,
			"status" => false
	);

	public function editorConfig($defaultText, $options) {
		$config = array_replace_recursive($this->defaultConfig, $options);
		$config["initialValue"] = $defaultText;
		return $config;
	}
}
