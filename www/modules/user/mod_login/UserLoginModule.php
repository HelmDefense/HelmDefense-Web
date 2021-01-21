<?php
namespace Module;

use Utils;

class UserLoginModule extends Module {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new UserLoginController(), "Connexion");
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$request = Utils::get("module", "login");
		$referer = Utils::arr($_SERVER, "HTTP_REFERER", Utils::SITE_URL);
		if ($request == "logout") {
			$this->controller->logout($referer);
		} else {
			$data = Utils::postMany(array("user", "password", "referer" => Utils::SITE_URL, "check" => "invalid"), true);
			if ($data->check == "invalid")
				$this->controller->loginPage($referer);
			else
				$this->controller->login($data->user, $data->password, $data->referer);
		}
	}
}
