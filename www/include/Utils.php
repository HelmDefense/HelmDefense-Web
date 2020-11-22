<?php
include_once "check_include.php";
include_once "modules/modules.php";
include_once "components/components.php";
include_once "Connection.php";

class Utils {
	/**
	 * @var bool
	 */
	private static $isConnectionInit = false;

	/**
	 * @var Mod[]
	 */
	public static $modules = array();

	/**
	 * @var Comp[]
	 */
	public static $components = array();

	/**
	 * @var string[]
	 */
	public static $response_status = array(
			100 => "Continue",
			101 => "Switching Protocols",
			102 => "Processing",
			103 => "Early Hints",

			200 => "OK",
			201 => "Created",
			202 => "Accepted",
			203 => "Non-Authoritative Information",
			204 => "No Content",
			205 => "Reset Content",
			206 => "Partial Content",
			207 => "Multi-Status",
			208 => "Already Reported",
			226 => "IM Used",

			300 => "Multiple Choices",
			301 => "Moved Permanently",
			302 => "Found",
			303 => "See Other",
			304 => "Not Modified",
			305 => "Use Proxy",
			306 => "Switch Proxy",
			307 => "Temporary Redirect",
			308 => "Permanent Redirect",

			400 => "Bad Request",
			401 => "Unauthorized",
			402 => "Payment Required",
			403 => "Forbidden",
			404 => "Not Found",
			405 => "Method Not Allowed",
			406 => "Not Acceptable",
			407 => "Proxy Authentication Required",
			408 => "Request Timeout",
			409 => "Conflict",
			410 => "Gone",
			411 => "Length Required",
			412 => "Precondition Failed",
			413 => "Payload Too Large",
			414 => "URI Too Long",
			415 => "Unsupported Media Type",
			416 => "Range Not Satisfiable",
			417 => "Expectation Failed",
			418 => "I'm a teapot",
			421 => "Misdirected Request",
			422 => "Unprocessable Entity",
			423 => "Locked",
			424 => "Failed Dependency",
			425 => "Too Early",
			426 => "Upgrade Required",
			428 => "Precondition Required",
			429 => "Too Many Requests",
			431 => "Request Header Fields Too Large",
			451 => "Unavailable For Legal Reasons",

			500 => "Internal Server Error",
			501 => "Not Implemented",
			502 => "Bad Gateway",
			503 => "Service Unavailable",
			504 => "Gateway Timeout",
			505 => "HTTP Version Not Supported",
			506 => "Variant Also Negotiates",
			507 => "Insufficient Storage",
			508 => "Loop Detected",
			510 => "Not Extended",
			511 => "Network Authentication Required"
	);

	/**
	 * @param string $val
	 * @param string|null $def
	 * @return string|null
	 */
	static function get($val, $def = null) {
		return isset($_GET[$val]) ? $_GET[$val] : $def;
	}

	/**
	 * @param string[] $vals
	 * @param bool $stdClass
	 * @return string[]|stdClass
	 */
	static function getMany($vals, $stdClass = false) {
		$values = array();
		foreach ($vals as $val => $def) {
			if (is_int($val))
				$values[$def] = self::get($def);
			else
				$values[$val] = self::get($val, $def);
		}
		return $stdClass ? self::toStdClass($values) : $values;
	}

	/**
	 * @param string $val
	 * @param string|null $msg
	 * @return string
	 */
	static function getRequired($val, $msg = null) {
		$value = self::get($val);
		if (is_null($value))
			self::error(400, is_null($msg) ? "Valeur du paramètre GET requis \"$val\" manquante" : $msg);
		return $value;
	}

	/**
	 * @param string $val
	 * @param string|null $def
	 * @return string|null
	 */
	static function post($val, $def = null) {
		return isset($_POST[$val]) ? $_POST[$val] : $def;
	}

	/**
	 * @param string[] $vals
	 * @param bool $stdClass
	 * @return string[]|stdClass
	 */
	static function postMany($vals, $stdClass = false) {
		$values = array();
		foreach ($vals as $val => $def) {
			if (is_int($val))
				$values[$def] = self::post($def);
			else
				$values[$val] = self::post($val, $def);
		}
		return $stdClass ? self::toStdClass($values) : $values;
	}

	/**
	 * @param string $val
	 * @param string|null $msg
	 * @return string
	 */
	static function postRequired($val, $msg = null) {
		$value = self::post($val);
		if (is_null($value))
			self::error(400, is_null($msg) ? "Valeur du paramètre POST requis \"$val\" manquante" : $msg);
		return $value;
	}

	/**
	 * @param string|null $mod_name
	 * @param bool $display_errors
	 * @return \Module\Module
	 */
	static function loadModule($mod_name = null, $display_errors = false) {
		if (is_null($mod_name)) {
			$mod_name = self::getRequired("module");
			$section = self::get("section");
			if (!is_null($section))
				$mod_name = "$section/$mod_name";
		}

		if (!array_key_exists($mod_name, self::$modules))
			self::error(404, "Module \"$mod_name\" introuvable");

		$mod = self::$modules[$mod_name];
		$mod_class = $mod->className();
		$mod_section = $mod->isGlobal() ? "" : $mod->getSection() . "/";
		include_once "modules/${mod_section}mod_$mod_name/$mod_class.php";
		if ($mod->needsDatabase())
			self::initConnection($display_errors);
		$full_mod_class = "\\Module\\$mod_class";
		return new $full_mod_class();
	}

	/**
	 * @param string $com_name
	 * @param bool $display_errors
	 * @return \Component\Component
	 */
	static function loadComponent($com_name, $display_errors = false) {
		if (!array_key_exists($com_name, self::$components))
			self::error(404, "Composant \"$com_name\" introuvable");

		$com = self::$components[$com_name];
		$com_class = $com->className();
		include_once "components/com_$com_name/$com_class.php";
		if ($com->needsDatabase())
			self::initConnection($display_errors);
		$full_com_class = "\\Component\\$com_class";
		return new $full_com_class();
	}

	/**
	 * @param bool $display_errors
	 */
	static function initConnection($display_errors = false) {
		if (self::$isConnectionInit)
			return;

		if (!Connection::init($e)) {
			$msg = "Erreur lors de la connexion à la base de données";
			if ($display_errors)
				$msg .= "<pre class='text-white'>" . $e->getMessage() . "</pre>";
			self::error(500, $msg);
		}
		self::$isConnectionInit = true;
	}

	/**
	 * @param array $array
	 * @return stdClass
	 */
	static function toStdClass($array) {
		$object = new stdClass();
		foreach ($array as $key => $value) {
			if (is_array($value))
				$value = self::toStdClass($value);
			$object->$key = $value;
		}
		return $object;
	}

	/**
	 * @param int $code
	 * @param string $msg
	 * @param array $params
	 */
	static function error($code = 500, $msg = "Une erreur est survenue", $params = array()) {
		if (!array_key_exists($code, self::$response_status))
			$code = 500;

		if (array_key_exists("error", self::$modules)) {
			array_splice($_GET, 0);
			$_GET["module"] = "error";
			$_GET["code"] = $code;
			$_GET["status"] = self::$response_status[$code];
			$_GET["msg"] = $msg;
			foreach ($params as $key => $val)
				$_GET[$key] = $val;
			include "index.php";
			die;
		}

		http_response_code($code);
		die("<pre>$code " . self::$response_status[$code] . ": $msg</pre>");
	}

	/**
	 * @param PDO $bdd
	 * @param string $requete
	 * @param array $params
	 * @param bool $multiple
	 * @param int $fetch_style
	 * @return stdClass|array|false
	 */
	static function executeRequest($bdd, $requete, $params = array(), $multiple = true, $fetch_style = PDO::FETCH_OBJ) {
		$query = $bdd->prepare($requete);
		if (!$query->execute($params))
			self::error(500, "Erreur lors de l'exécution d'une requête SQL");
		return $multiple ? $query->fetchAll($fetch_style) : $query->fetch($fetch_style);
	}

	/**
	 * @param string $filename
	 * @param string $start
	 * @param string $end
	 * @return string|null
	 */
	static function file($filename, $start = "", $end = "") {
		return file_exists($filename) ? $start . file_get_contents($filename) . $end : null;
	}
}
