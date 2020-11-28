<?php
namespace Component;

include_once "components/generic/Component.php";
include_once "WikiPagePreviewController.php";

class WikiPagePreviewComponent extends Component {

	public function __construct() {
		parent::__construct(new WikiPagePreviewController());
	}

	/**
	 * @inheritDoc
	 */
	protected function calculateRender() {
		// TODO: Implement calculateRender() method.
	}
}