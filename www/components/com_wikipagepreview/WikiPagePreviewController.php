<?php
namespace Component;

use Utils;

include_once "components/generic/Controller.php";
include_once "WikiPagePreviewModel.php";
include_once "WikiPagePreviewView.php";

class WikiPagePreviewController extends Controller {

	/**
	 * WikiPagePreviewController constructor.
	 */
	public function __construct() {
		parent::__construct(new WikiPagePreviewModel(), new WikiPagePreviewView());
	}

	public function generatePagePreview($idPage, $type, $heading) {
		switch ($type) {
		case "page":
			$page = $this->model->getPreview($idPage);
			break;
		case "level":
			$page = $this->model->getLevel($idPage);
			break;
		case "entity":
			$page = $this->model->getEntity($idPage);
			break;
		default:
			Utils::error(400, "type de page incorrect");
		}
		$this->view->generatePagePreview($page, $type, $heading);
	}
}