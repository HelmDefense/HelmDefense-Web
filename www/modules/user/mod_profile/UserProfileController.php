<?php
namespace Module;

use Utils;

include_once "UserProfileModel.php";
include_once "UserProfileView.php";
include_once "modules/generic/Controller.php";

class UserProfileController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new UserProfileModel(), new UserProfileView());
	}

	function displayProfileUser($needUrlCorrection) {
		if($needUrlCorrection) {
			UserProfileView::defaultToProfile();
		}
		else {
			$user = $this->model->searchInfo();
			if(is_null($user))
				Utils::redirect("/user/login");
			$this->view->displayProfile($user);
		}
	}

	function displaySettingsUser() {
		$user = $this->model->searchInfo();
		$this->view->displaySettings($user);
	}

}
