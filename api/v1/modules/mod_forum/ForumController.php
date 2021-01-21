<?php
include_once "include/check_include.php";
include_once "ForumModel.php";
include_once "ForumView.php";

class ForumController {
	private $model;
	private $view;

	public function __construct() {
		$this->model = new ForumModel();
		$this->view = new ForumView();
	}

	public function types() {
		$this->view->json($this->model->types());
	}

	public function list($type, $limit, $page) {
		if ($limit <= 0)
			Utils::error(400, "Invalid limit");
		if ($page <= 0)
			Utils::error(400, "Invalid page");
		$offset = ($page - 1) * $limit;
		$posts = $this->model->list($type, $limit, $offset);
		if (is_null($posts))
			Utils::error(404, "Unknown post type");
		$this->view->json($posts);
	}

	public function get($type, $id, $limit, $page) {
		if ($limit <= 0)
			Utils::error(400, "Invalid limit");
		if ($page <= 0)
			Utils::error(400, "Invalid page");
		$offset = ($page - 1) * $limit;
		$post = $this->model->get($type, $id, $limit, $offset);
		if (is_null($post))
			Utils::error(404, "Unknown post type");
		if (!$post)
			Utils::error(404, "Invalid post or msg id");
		$this->view->json($post);
	}
}
