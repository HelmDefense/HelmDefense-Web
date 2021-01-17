<?php
namespace Module;

use Utils;

class UserSigninController extends Controller {
	public function __construct() {
		parent::__construct(new UserSigninModel(), new UserSigninView());
	}

	public function resetPasswordPage() {
		$this->view->resetPassword();
		$this->title = "Réinitialisation du mot de passe";
	}

	public function resetPasswordRequest($id, $password, $passwordconfirm) {
		if (is_null($id) || is_null($password) || is_null($passwordconfirm) || $password != $passwordconfirm) {
			$this->resetPasswordPage();
			return;
		}
		$email = $this->model->resetPasswordRequest($id, $password);
		if (!is_null($email))
			$email = substr_replace($email, str_repeat("*", strlen($email) - 5), 5);
		$this->view->resetPasswordRequested($email);
		$this->title = "Demande envoyée - Réinitialisation du mot de passe";
	}

	public function resetPassword($code) {
		$this->view->resetPasswordResult($this->model->resetPassword($code));
		$this->title = "État de la demande - Réinitialisation du mot de passe";
	}

	public function signinPage($id = null, $name = null, $email = null, $error = 0) {
		Utils::timeout("signin", 300);
		$this->view->signin($id, $name, $email, $error);
		$this->title = "Inscription";
	}

	public function signin($id, $name, $password, $email, $passwordConfirm) {
		Utils::timeoutCheck("signin");
		$error = 0;
		if (!preg_match("/[a-z0-9_-]{3,32}/i", $id))
			$error = 2;
		else if (is_null($id))
			$error = 3;
		else if (is_null($password))
			$error = 4;
		else if (is_null($email))
			$error = 5;
		else if (is_null($passwordConfirm))
			$error = 6;
		else if ($password != $passwordConfirm)
			$error = 7;
		else if (!preg_match("/([^@]+@[^.]+\.[^.]+)/", $email) || strlen($email) > 128)
			$error = 8;
		else if (is_null($name))
			$error = 9;

		if ($error)
			$this->signinPage($id, $name, $email, $error);
		else {
			$result = $this->model->userSignin($id, $name, $password, $email);
            if ($result) {
                $this->signinPage($id, $name, $email, $result);
            } else {
                header("Location: /user/profile");
                exit(303);
            }
		}
	}
}
