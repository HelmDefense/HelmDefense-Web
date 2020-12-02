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
		if(is_null($type))
			$page = $this->model->getPreview($idPage);
		else if($type == "level")
			$page = $this->model->getLevel($idPage);
		else if($type == "entity")
			$page = $this->model->getEntity($idPage);
		else
			Utils::error(400, "type de page incorrect");
		$this->view->generatePagePreview($page, $heading);
	}
}