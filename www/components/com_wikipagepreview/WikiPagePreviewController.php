<?php
namespace Component;

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

	public function generatePagePreview($idPage, $heading) {
		$this->view->generatePagePreview($this->model->getPreview($idPage), $heading);
	}
}