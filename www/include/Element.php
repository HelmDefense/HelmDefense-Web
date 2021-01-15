<?php

abstract class Element {
	/**
	 * @var string
	 */
	protected $name;
	/**
	 * @var string
	 */
	protected $class;
	/**
	 * @var string[]
	 */
	protected $resources;
	/**
	 * @var bool
	 */
	protected $db;

	/**
	 * @param string $name
	 * @param string $class
	 * @param string[]|string $resources
	 * @param bool $db
	 */
	protected function __construct($name, $class, $resources = null, $db = false) {
		$this->name = $name;
		$this->class = $class;
		$this->resources = is_array($resources) ? $resources : (is_null($resources) ? array() : array($resources));
		$this->db = $db;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
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

	/**
	 * @return void
	 */
	public abstract function include();
}
