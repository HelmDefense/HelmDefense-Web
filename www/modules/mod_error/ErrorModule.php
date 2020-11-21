<?php
include_once "modules/generic/Module.php";
include_once "ErrorController.php";

class ErrorModule extends Module {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new ErrorController());
	}

	/**
	 * @inheritDoc
	 */
	public function execute() {
		$error = Utils::getMany(array(
				"code" => "500",
				"status" => Utils::$response_status[500],
				"msg" => "Une erreur est survenue",
				"page"
		), true);

		if (!array_key_exists($error->code, Utils::$response_status)) {
			$error->code = 500;
			$error->status = Utils::$response_status[500];
		}

		if ($error->code == 404)
			$this->controller->error404($error->msg, $error->page);
		else
			$this->controller->error($error->code, $error->status, $error->msg);

		http_response_code($error->code);
	}
}
