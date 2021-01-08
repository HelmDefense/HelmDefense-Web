<?php
namespace Component;

use Utils;

include_once "components/generic/Component.php";
include_once "WikiPagePreviewController.php";

class WikiPagePreviewComponent extends Component {
	private $idPage;
	private $heading;
	private $type;

	public function __construct($idPage = null, $type = "page", $heading = "h3") {
		parent::__construct(new WikiPagePreviewController());
		$this->type = $type;
		$this->idPage = $idPage;
		$this->heading = $heading;
	}

	/**
	 * @inheritDoc
	 */
	protected function calculateRender() {
		if (is_null($this->idPage))
			Utils::error(404, "Page inconnue");
		else
			$this->controller->generatePagePreview($this->idPage, $this->type, $this->heading);
	}
}
