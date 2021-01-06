<?php
namespace Module;

use Utils;

include_once "modules/generic/Controller.php";
include_once "UserLoginModel.php";
include_once "UserLoginView.php";

class UserLoginController extends Controller {

	public function __construct(){
		parent::__construct(new UserLoginModel(),new UserLoginView());
	}

	public function login($name, $password){
		if ($this->model->userConnect($name, $password)) {
			header("Location: /");
			exit(303);
		}else{
			$this->view->loginError();
		}
	}

}