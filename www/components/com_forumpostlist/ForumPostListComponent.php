<?php
namespace Component;

class ForumPostListComponent extends Component {
	private $type;
	private $limit;
	private $page;
	private $navigable;

	public function __construct($type = "talk", $limit = 10, $page = 1, $navigable = false) {
		parent::__construct(new ForumPostListController());
		$this->type = $type;
		$this->limit = $limit;
		$this->page = $page;
		$this->navigable = $navigable;
	}

	/**
	 * @inheritDoc
	 */
	protected function calculateRender() {
		$this->controller->generatePostList($this->type, $this->limit, $this->page, $this->navigable);
	}
}
