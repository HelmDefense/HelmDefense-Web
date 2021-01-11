<?php
namespace Component;

use Utils;

include_once "components/generic/Controller.php";
include_once "ForumPostListModel.php";
include_once "ForumPostListView.php";

class ForumPostListController extends Controller {
	public function __construct() {
		parent::__construct(new ForumPostListModel(), new ForumPostListView());
	}

	public function generatePostList($type, $limit, $page, $navigable) {
		$posts = $this->model->postList($type, $limit, $page);
		if (is_null($posts))
			Utils::error(404, "Type de post inconnu");
		switch ($type) {
		case "talk":
			$this->view->displayTalkList($posts->result);
			break;
		case "rate":
			$this->view->displayRateList($posts->result);
			break;
		case "strat":
			$this->view->displayStratList($posts->result);
			break;
		}
		if ($navigable)
			$this->view->displayNavigation($type, $limit, $page, $posts->count);
	}
}
