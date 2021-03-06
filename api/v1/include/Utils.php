<?php
include_once "check_include.php";
include_once "modules/modules.php";
include_once "Connection.php";

class Utils {
	/**
	 * @var bool
	 */
	private static $isConnectionInit = false;

	/**
	 * @var string[]
	 */
	public static $modules = array();

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
	 * @var string|null Server configuration
	 */
	private static $config = null;

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
	 * @return string[]
	 */
	static function getMany($vals) {
		$values = array();
		foreach ($vals as $val => $def) {
			if (is_int($val))
				$values[$def] = self::get($def);
			else
				$values[$val] = self::get($val, $def);
		}
		return $values;
	}

	/**
	 * @param string $val
	 * @param string|null $msg
	 * @return string
	 */
	static function getRequired($val, $msg = null) {
		$value = Utils::get($val);
		if (is_null($value))
			Utils::error(400, is_null($msg) ? "Missing GET parameter $val" : $msg);
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
	 * @return string[]
	 */
	static function postMany($vals) {
		$values = array();
		foreach ($vals as $val => $def) {
			if (is_int($val))
				$values[$def] = self::post($def);
			else
				$values[$val] = self::post($val, $def);
		}
		return $values;
	}

	/**
	 * @param string $val
	 * @param string|null $msg
	 * @return string
	 */
	static function postRequired($val, $msg = null) {
		$value = Utils::post($val);
		if (is_null($value))
			Utils::error(400, is_null($msg) ? "Missing POST parameter $val" : $msg);
		return $value;
	}

	/**
	 * @param string|null $mod
	 * @param bool $display_errors
	 * @return mixed
	 */
	static function loadModule($mod = null, $display_errors = false) {
		if (is_null($mod))
			$mod = self::get("modules");

		if (is_null($mod) || !array_key_exists($mod, self::$modules))
			self::error(404, "Module not found");

		$mod_class = self::$modules[$mod];
		include_once "modules/mod_$mod/$mod_class.php";
		self::initConnection($display_errors);
		return new $mod_class();
	}

	/**
	 * @param bool $display_errors
	 */
	static function initConnection($display_errors = false) {
		if (self::$isConnectionInit)
			return;

		if (!Connection::init($e)) {
			if ($display_errors)
				echo "<pre>$e</pre>";
			Utils::error(500, "Database connection error");
		}
		self::$isConnectionInit = true;
	}

	/**
	 * Load the config from the `config.json` file
	 * @see Utils::config()
	 */
	static function loadConfig() {
		$config = self::file($_SERVER["DOCUMENT_ROOT"] . "/../config.json");
		if (!is_null($config))
			self::$config = json_decode($config);
	}

	/**
	 * Retrieve a value from the server config
	 * @param string $path The path of the config resource (use a dot to access objects' properties)
	 * @param mixed|null $def The default value if the resource doesn't exists
	 * @return mixed The retrieved value or $def
	 */
	static function config($path, $def = null) {
		// Load config if needed
		if (is_null(self::$config))
			self::loadConfig();
		// Split path
		$parts = explode(".", $path);
		$config = self::$config;
		// Explore the config to find the requested value
		foreach ($parts as $part) {
			if (isset($config->$part))
				$config = $config->$part;
			else
				return $def;
		}
		return $config;
	}

	/**
	 * @param array $array
	 * @return stdClass
	 */
	static function toStdClass($array) {
		$object = new stdClass();
		foreach ($array as $key => $value) {
			if (is_array($value))
				$value = Utils::toStdClass($value);
			$object->$key = $value;
		}
		return $object;
	}

	/**
	 * @param int $code
	 * @param string $msg
	 */
	static function error($code = 500, $msg = "No information available") {
		if (!array_key_exists($code, self::$response_status))
			$code = 500;

		http_response_code($code);
		echo json_encode(array(
				"error" => true,
				"code" => $code,
				"status" => self::$response_status[$code],
				"msg" => $msg
		));
		die;
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
			Utils::error(500, "SQL request error (" . $query->errorInfo()[2] . ")");
		return $multiple ? $query->fetchAll($fetch_style) : $query->fetch($fetch_style);
	}

	/**
	 * Read a file to get the content
	 * @param string $filename The file to read
	 * @param string $start Additional string to insert before the returned file content
	 * @param string $end Additional string to insert after the returned file content
	 * @return string|null The file content surrounded with start and end if the file exists, null otherwise
	 * @see file_exists(), file_get_contents()
	 */
	static function file($filename, $start = "", $end = "") {
		return file_exists($filename) ? $start . file_get_contents($filename) . $end : null;
	}
}
