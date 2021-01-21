<?php
namespace Module;

use Utils;

class UserLoginController extends Controller {
	public function __construct() {
		parent::__construct(new UserLoginModel(), new UserLoginView());
	}

	public function loginPage($referer, $error = 0) {
		$this->view->login($referer, $error);
	}

	public function login($name, $password, $referer) {
		if (is_null($name))
			$this->loginPage($referer, 3);
		else if (is_null($password))
			$this->loginPage($referer, 4);
		else {
			$reason = $this->model->getBan($name);
			if ($reason === false) {
				$result = $this->model->userConnect($name, $password);
				if ($result) {
					$this->view->login($referer, $result);
				} else {
					if (preg_match("/^[^\/]+\/\/[^\/]+\/user\/(login|signin)(\/|$)/i", $referer))
					  $referer = "/";
				  Utils::redirect($referer);
				}
			}
			else
				$this->view->login($referer, 5, $reason);
		}
	}

	public function logout($referer) {
		$this->model->userDisconnect();
		Utils::redirect($referer);
	}
}
