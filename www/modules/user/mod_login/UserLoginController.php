<?php
namespace Module;

use Utils;

class UserLoginController extends Controller {
	public function __construct() {
		parent::__construct(new UserLoginModel(), new UserLoginView());
	}

	public function loginPage($error = 0) {
		$this->view->login($error);
	}

	public function login($name, $password) {
		if (is_null($name))
			$this->loginPage(3);
		else if (is_null($password))
			$this->loginPage(4);
		else {
			$reason = $this->model->getBan($name);
			if ($reason === false) {
				$result = $this->model->userConnect($name, $password);
				if ($result) {
					$this->view->login($result);
				} else {
					Utils::redirect("/");
				}
			}
			else
				$this->view->login(5, $reason);
		}
	}

	public function logout() {
		$this->model->userDisconnect();
		Utils::redirect("/");
	}
}
