<?php
namespace Module;

use Utils;

include_once "WikiPageModel.php";
include_once "WikiPageView.php";
include_once "modules/generic/Controller.php";

class WikiPageController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new WikiPageModel(), new WikiPageView());
	}

	/**
	 * @inheritDoc
	 */
	public function getHead() {
		return $this->view->getHead($this->model->getHeadFilename(), $this->model->getStyle());
	}

	/**
	 * @inheritDoc
	 */
	public function getTitle() {
		return $this->model->getName();
	}

	public function entityPage(){

	}
}