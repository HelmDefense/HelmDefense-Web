<?php
namespace Module;

use stdClass;
use Utils;

include_once "modules/generic/Model.php";

class WikiPageModel extends Model {

	public function getEntityPage($entity) {
		return Utils::httpGetRequest("v1/entities/$entity");
	}

}