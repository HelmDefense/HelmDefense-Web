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
}