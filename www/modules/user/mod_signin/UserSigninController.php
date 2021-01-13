<?php
namespace Module;

use Utils;

include_once "modules/generic/Controller.php";
include_once "UserSigninModel.php";
include_once "UserSigninView.php";
class UserSigninController extends Controller{
	public function __construct(){
		parent::__construct(new UserSigninModel(), new UserSigninView());
	}

	public function signinPage($error = 0){
		$this->view->signin($error);
	}

	public function signin($name, $password, $email){
		$result = $this->model->userSignin($name, $password, $email);
		if ($result){
			$this->view->signin($result);
		}else{
			header("Location: /");
			exit(303);
		}

	}
}