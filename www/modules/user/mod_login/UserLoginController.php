<?php
namespace Module;

class UserLoginController extends Controller {
	public function __construct() {
		parent::__construct(new UserLoginModel(),new UserLoginView());
	}

	public function loginPage($error = 0) {
		$this->view->login($error);
	}

	public function login($name, $password) {
		$result = $this->model->userConnect($name, $password);
		if ($result) {
			$this->view->login($result);
		} else {
			header("Location: /");
			exit(303);
		}
	}

	public function logout() {
		$this->model->userDisconnect();
		header("Location: /");
		exit(303);
	}
}
