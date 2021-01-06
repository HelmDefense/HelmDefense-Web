<?php
namespace Module;

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
			$name = $this->model->searchInfo("nom", "");
			$this->view->displayProfile();
		}
	}
}
