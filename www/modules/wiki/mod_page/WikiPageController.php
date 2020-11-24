<?php
namespace Module;

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
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function getTitle() {
		return "Wiki";
	}

	public function page() {

	}

	public function homePage() {

	}

	public function entityPage() {

	}

	public function levelPage() {

	}
}
