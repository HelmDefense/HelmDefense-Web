<?php

abstract class Element {
	/**
	 * @var string
	 */
	private $class;
	/**
	 * @var string[]
	 */
	private $resources;
	/**
	 * @var bool
	 */
	private $db;

	/**
	 * @param string $class
	 * @param string[]|string $resources
	 * @param bool $db
	 */
	protected function __construct($class, $resources = array(), $db = false) {
		$this->class = $class;
		$this->resources = is_array($resources) ? $resources : array($resources);
		$this->db = $db;
	}

	/**
	 * @return string
	 */
	public function className() {
		return $this->class;
	}

	/**
	 * @return string[]
	 */
	public function getResources() {
		return $this->resources;
	}

	/**
	 * @return bool
	 */
	public function needsDatabase() {
		return $this->db;
	}
}
