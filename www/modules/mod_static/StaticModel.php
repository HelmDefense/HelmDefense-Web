<?php
include_once "modules/generic/Model.php";

class StaticModel extends Model {
	/**
	 * @var string
	 */
	private $page;

	/**
	 * @param string $page
	 */
	public function setPage($page) {
		$this->page = $page;
	}

	/**
	 * Get the page style.css file content, or null if there's no style
	 * @return string|null The page style or null if style.css file is absent
	 */
	public function getStyle() {
		return file_exists("$this->page/style.css") ? file_get_contents("$this->page/style.css") : null;
	}

	/**
	 * Get the page head.php file name, or null if there's no head
	 * @return string|null The page head file name or null if the head.php file is absent
	 */
	public function getHeadFilename() {
		return file_exists("$this->page/head.php") ? "$this->page/head.php" : null;
	}

	/**
	 * Get the page name file content, or null if there's no name
	 * @return string|null The page name or null if name file is absent
	 */
	public function getName() {
		return file_exists("$this->page/name") ? file_get_contents("$this->page/name") : null;
	}
}
