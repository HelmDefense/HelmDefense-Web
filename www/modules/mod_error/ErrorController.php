<?php
namespace Module;

use Utils;

class ErrorController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new ErrorModel(), new ErrorView());
	}

	/**
	 * @param string $msg
	 * @param string|null $page
	 */
	public function error404($msg, $page) {
		$this->title = "404 " . Utils::$response_status[404];
		$this->view->error(
				404,
				Utils::$response_status[404],
				"Il semblerait que vous vous soyez perdu.e dans des contrées trop lointaines...",
				$msg,
				"404",
				$this->view->searchResults($this->model->searchFor($page))
		);
	}

	/**
	 * @param int $code
	 * @param string $status
	 * @param string $msg
	 */
	public function error($code, $status, $msg) {
		$this->title = "$code $status";
		$this->view->error($code, $status, "Vous ne passerez pas !", $msg);
	}
}
