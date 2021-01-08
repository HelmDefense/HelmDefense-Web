<?php
namespace Component;

include_once "components/generic/Component.php";
include_once "ForumPostListController.php";

class ForumPostListComponent extends Component {
	private $type;
	private $limit;
	private $offset;
	private $navigable;

	public function __construct($type = "talk", $limit = null, $offset = null, $navigable = false) {
		parent::__construct(new ForumPostListController());
		$this->type = $type;
		$this->limit = $limit;
		$this->offset = $offset;
		$this->navigable = $navigable;
	}

	/**
	 * @inheritDoc
	 */
	protected function calculateRender() {
		$this->controller->generatePostList($this->type, $this->limit, $this->offset, $this->navigable);
	}
}
