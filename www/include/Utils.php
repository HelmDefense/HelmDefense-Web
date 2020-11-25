<?php

use Component\Component;
use Module\Module;

include_once "check_include.php";
include_once "modules/modules.php";
include_once "components/components.php";
include_once "Connection.php";

/**
 * Utils static class that contains many utility functions
 * @see Utils::get(), Utils::post(), Utils::session()
 * @see Utils::loadModule(), Utils::loadComponent()
 * @see Utils::error()
 * @see Utils::API_URL, Utils::SITE_URL
 */
class Utils {
	/**
	 * The URL of the website
	 * @see Utils::API_URL
	 */
	const SITE_URL = "https://helmdefense.theoszanto.fr/";

	/**
	 * The URL of the API
	 * @see Utils::SITE_URL
	 */
	const API_URL = "https://api.helmdefense.theoszanto.fr/";

	/**
	 * @var bool Whether the connection has been initialized or not
	 * @see Utils::initConnection(), Connection::init()
	 */
	private static $isConnectionInit = false;

	/**
	 * @var Mod[] Registered modules
	 * @see Utils::loadModule()
	 * @see Module, Mod
	 */
	public static $modules = array();

	/**
	 * @var Comp[] Registered components
	 * @see Utils::loadComponent()
	 * @see Component, Comp
	 */
	public static $components = array();

	/**
	 * @var string[] List of common HTTP response status by code
	 * @see Utils::error()
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
	 * Private constructor to mark this class as static
	 */
	private function __construct() {}

	/**
	 * Return the value for the key `$val` in the array `$arr` if it exists, `$def` otherwise
	 * @param array $arr The array to explore
	 * @param mixed $val The key to search for
	 * @param mixed|null $def The value to return if the key isn't it the array
	 * @return mixed|null The value associated, or the default one if the key is absent
	 * @see Utils::arrMany(), Utils::arrRequired()
	 * @see Utils::get(), Utils::post(), Utils::session(), Utils::extra()
	 */
	static function arr($arr, $val, $def = null) {
		return isset($arr[$val]) ? $arr[$val] : $def;
	}

	/**
	 * Return an associative array (or `stdClass`) of values from an array
	 * @param array $arr The array to explore
	 * @param mixed[] $vals The keys to search for, and the default values associated, if any
	 * @param bool $stdClass Whether to return an stdClass or not (an array is used by default)
	 * @return mixed[]|stdClass The values associated to keys in the array, or the default values of some were absent
	 * @see Utils::arr(), Utils::arrRequired()
	 * @see Utils::getMany(), Utils::postMany(), Utils::sessionMany(), Utils::extraMany()
	 */
	static function arrMany($arr, $vals, $stdClass = false) {
		$values = array();
		foreach ($vals as $val => $def) {
			// Check if the value is an int, then there is no associated default value
			if (is_int($val))
				$values[$def] = self::arr($arr, $def);
			else
				$values[$val] = self::arr($arr, $val, $def);
		}
		// Return the data into the specified format
		return $stdClass ? self::toStdClass($values) : $values;
	}

	/**
	 * Return the value for the key `$val` in the array `$arr` if it exists, or end with an error message `$msg` otherwise
	 * @param array $arr The array to explore
	 * @param mixed $val The key to search for
	 * @param string|null $msg The error message if the key is absent
	 * @return mixed The value associated
	 * @see Utils::arr(), Utils::arrMany()
	 * @see Utils::getRequired(), Utils::postRequired(), Utils::sessionRequired(), Utils::extraRequired()
	 */
	static function arrRequired($arr, $val, $msg = null) {
		$value = self::arr($arr, $val);
		// If the value doesn't exists, stop with an error
		if (is_null($value))
			self::error(400, is_null($msg) ? "Valeur requise \"$val\" manquante" : $msg);
		return $value;
	}

	/**
	 * Shortcut for `Utils::arr($_GET, $val, $def)`
	 * @param string $val The key to search for
	 * @param string|null $def The value to return if the key isn't it the array
	 * @return string|null The value associated, or the default one if the key is absent
	 * @see Utils::arr(), $_GET
	 */
	static function get($val, $def = null) {
		return self::arr($_GET, $val, $def);
	}

	/**
	 * Shortcut for `Utils::arrMany($_GET, $vals, $stdClass)`
	 * @param string[] $vals The keys to search for, and the default values associated, if any
	 * @param bool $stdClass Whether to return an stdClass or not (an array is used by default)
	 * @return string[]|stdClass The values associated to keys in the array, or the default values of some were absent
	 * @see Utils::arrMany(), $_GET
	 */
	static function getMany($vals, $stdClass = false) {
		return self::arrMany($_GET, $vals, $stdClass);
	}

	/**
	 * Shortcut for `Utils::arrRequired($_GET, $val, $msg)`
	 * @param string $val The key to search for
	 * @param string|null $msg The error message if the key is absent
	 * @return string The value associated
	 * @see Utils::arrRequired(), $_GET
	 */
	static function getRequired($val, $msg = null) {
		return self::arrRequired($_GET, $val, is_null($msg) ? "Valeur du paramètre GET requis \"$val\" manquante" : $msg);
	}

	/**
	 * Shortcut for `Utils::arr($_POST, $val, $def)`
	 * @param string $val The key to search for
	 * @param string|null $def The value to return if the key isn't it the array
	 * @return string|null The value associated, or the default one if the key is absent
	 * @see Utils::arr(), $_POST
	 */
	static function post($val, $def = null) {
		return self::arr($_POST, $val, $def);
	}

	/**
	 * Shortcut for `Utils::arrMany($_POST, $vals, $stdClass)`
	 * @param string[] $vals The keys to search for, and the default values associated, if any
	 * @param bool $stdClass Whether to return an stdClass or not (an array is used by default)
	 * @return string[]|stdClass The values associated to keys in the array, or the default values of some were absent
	 * @see Utils::arrMany(), $_POST
	 */
	static function postMany($vals, $stdClass = false) {
		return self::arrMany($_POST, $vals, $stdClass);
	}

	/**
	 * Shortcut for `Utils::arrRequired($_POST, $val, $msg)`
	 * @param string $val The key to search for
	 * @param string|null $msg The error message if the key is absent
	 * @return string The value associated
	 * @see Utils::arrRequired(), $_POST
	 */
	static function postRequired($val, $msg = null) {
		return self::arrRequired($_POST, $val, is_null($msg) ? "Valeur du paramètre POST requis \"$val\" manquante" : $msg);
	}

	/**
	 * Shortcut for `Utils::arr($_SESSION, $val, $def)`
	 * @param string $val The key to search for
	 * @param string|null $def The value to return if the key isn't it the array
	 * @return string|null The value associated, or the default one if the key is absent
	 * @see Utils::arr(), $_SESSION
	 */
	static function session($val, $def = null) {
		return self::arr($_SESSION, $val, $def);
	}

	/**
	 * Shortcut for `Utils::arrMany($_SESSION, $vals, $stdClass)`
	 * @param string[] $vals The keys to search for, and the default values associated, if any
	 * @param bool $stdClass Whether to return an stdClass or not (an array is used by default)
	 * @return string[]|stdClass The values associated to keys in the array, or the default values of some were absent
	 * @see Utils::arrMany(), $_SESSION
	 */
	static function sessionMany($vals, $stdClass = false) {
		return self::arrMany($_SESSION, $vals, $stdClass);
	}

	/**
	 * Shortcut for `Utils::arrRequired($_SESSION, $val, $msg)`
	 * @param string $val The key to search for
	 * @param string|null $msg The error message if the key is absent
	 * @return string The value associated
	 * @see Utils::arrRequired(), $_SESSION
	 */
	static function sessionRequired($val, $msg = null) {
		return self::arrRequired($_SESSION, $val, is_null($msg) ? "Valeur de la variable de session requise \"$val\" manquante" : $msg);
	}

	/**
	 * Parse the extra route parameters contained into the `extra` GET parameter
	 * @return string[] The extra parameters (an empty array is returned when the extra parameter is absent)
	 */
	static function parseExtra() {
		$extra = self::get("extra");
		// Check if the value was present
		if (is_null($extra) || empty($extra))
			return array();
		return explode("/", $extra);
	}

	/**
	 * Shortcut for `Utils::arr(Utils::parseExtra(), $index, $def)`
	 * @param int $index The index of the extra route parameter to search for
	 * @param string|null $def The value to return if the index isn't it the array
	 * @return string|null The value associated, or the default one if the index is absent
	 * @see Utils::arr(), Utils::parseExtra()
	 */
	static function extra($index, $def = null) {
		return self::arr(self::parseExtra(), $index, $def);
	}

	/**
	 * Return the array of extra route parameters with given `$indexes`
	 * @param int[] $indexes The indexes to search for, and the default string values associated, if any
	 * @return mixed[]|stdClass The values associated to keys in the array, or the default values of some were absent
	 * @see Utils::arrMany(), Utils::parseExtra()
	 */
	static function extraMany($indexes) {
		$values = array();
		foreach ($indexes as $index => $def) {
			// Check if a default string value is present, otherwise there is no associated default value
			if (is_string($def))
				$values[$index] = self::extra($index, $def);
			else
				$values[$def] = self::extra($def);
		}
		return $values;
	}

	/**
	 * Shortcut for `Utils::arrRequired(Utils::parseExtra(), $index, $msg)`
	 * @param int $index The index of the extra route parameter to search for
	 * @param string|null $msg The error message if the index is absent
	 * @return string The value associated
	 * @see Utils::arrRequired(), Utils::parseExtra()
	 */
	static function extraRequired($index, $msg = null) {
		return self::arrRequired(self::parseExtra(), $index, is_null($msg) ? "Valeur de la route additionnelle requise \"$index\" manquante" : $msg);
	}

	/**
	 * Load a specific module. The load process do the following:
	 * * If `$mod_full_name` is `null`:
	 *     * Retrieve the required GET parameter `module` (if none is present, an error occur)
	 *     * Retrieve the optional GET parameter `section`
	 *     * Build the full module name "section/module"
	 * * Verify that the module exists (if not, an error occur)
	 * * Get the module descriptor from the full name
	 * * Include the module
	 * * If the module needs to access to the database:
	 *     * Initialize database connection
	 * * Create the module with the arguments and return the instance
	 * @param string|null $mod_full_name The full module name, including the section separated with a slash
	 * @param bool $display_errors Whether to display additional informations about errors
	 * @param mixed ...$args Additional arguments to pass to the module constructor
	 * @return Module The created module instance
	 * @see Utils::$modules, Module
	 */
	static function loadModule($mod_full_name = null, $display_errors = false, ...$args) {
		// Retrieve module from GET parameters if none passed
		if (is_null($mod_full_name)) {
			// Get required module
			$mod_full_name = self::getRequired("module");
			// Get optional section
			$section = self::get("section");
			if (!is_null($section)) // Combine both
				$mod_full_name = "$section/$mod_full_name";
		}

		// Verify that the module is valid
		if (!array_key_exists($mod_full_name, self::$modules))
			self::error(404, "Module \"$mod_full_name\" introuvable");

		// Retrieve the module descriptor object
		$mod = self::$modules[$mod_full_name];
		$mod_name = $mod->getName();
		$mod_class = $mod->className();
		$mod_section = $mod->isGlobal() ? "" : $mod->getSection() . "/";

		// Include module
		include_once "modules/${mod_section}mod_$mod_name/$mod_class.php";
		// Initialise database connection only if needed
		if ($mod->needsDatabase())
			self::initConnection($display_errors);

		// Create the module and return it
		$full_mod_class = "\\Module\\$mod_class";
		return new $full_mod_class(...$args);
	}

	/**
	 * Load a specific component. The load process do the following:
	 * * Verify that the component exists (if not, an error occur)
	 * * Get the component descriptor from the name
	 * * Include the component
	 * * If the component needs to access to the database:
	 *     * Initialize database connection
	 * * Create the component with the arguments and return the instance
	 * @param string $com_name The component name
	 * @param bool $display_errors Whether to display additional informations about errors
	 * @param mixed ...$args Additional arguments to pass to the component constructor
	 * @return Component The created component instance
	 * @see Utils::$components, Component
	 */
	static function loadComponent($com_name, $display_errors = false, ...$args) {
		// Verify that the component is valid
		if (!array_key_exists($com_name, self::$components))
			self::error(404, "Composant \"$com_name\" introuvable");

		// Retrieve the component descriptor object
		$com = self::$components[$com_name];
		$com_class = $com->className();

		// Include component
		include_once "components/com_$com_name/$com_class.php";
		// Initialise database connection only if needed
		if ($com->needsDatabase())
			self::initConnection($display_errors);

		// Create the component and return it
		$full_com_class = "\\Component\\$com_class";
		return new $full_com_class(...$args);
	}

	/**
	 * Initialize the connection. This function does nothing if the connection has already been initialized
	 * @param bool $display_errors Whether to display additional informations about errors
	 * @see Utils::$isConnectionInit
	 * @see Connection::init()
	 */
	static function initConnection($display_errors = false) {
		// Verify if connection was already initialized
		if (self::$isConnectionInit)
			return;

		// Initialize connection
		if (!Connection::init($e)) {
			// Stop if an error occur
			$msg = "Erreur lors de la connexion à la base de données";
			if ($display_errors)
				$msg .= "<pre class='text-white'>" . $e->getMessage() . "</pre>";
			self::error(500, $msg);
		}

		// Save that the connection has been initialized
		self::$isConnectionInit = true;
	}

	/**
	 * Transform an array into a stdClass object. Note that this function is recursive
	 * @param array $array The array to transform
	 * @return stdClass A new stdClass with the same content as the initial array
	 * @see stdClass
	 */
	static function toStdClass($array) {
		$object = new stdClass();
		// Iterate through the array
		foreach ($array as $key => $value) {
			// Recursively call the function if the value is an array
			if (is_array($value))
				$value = self::toStdClass($value);
			$object->$key = $value;
		}
		// Return the final stdClass
		return $object;
	}

	/**
	 * Create an error and stop the execution by calling the `error` module
	 * @param int $code The HTTP response code, used to determine the status
	 * @param string $msg The error message to display
	 * @param array $params Additional parameters to pass to the error module
	 * @see Utils::$response_status, http_response_code()
	 */
	static function error($code = 500, $msg = "Une erreur est survenue", $params = array()) {
		// Verify that the code is valid
		if (!array_key_exists($code, self::$response_status))
			$code = 500;

		// Check that the error module exists to avoid infinite recursive loop
		// Note: We assume here that the error module cannot throw any error
		if (array_key_exists("error", self::$modules)) {
			// Clear the GET parameters
			array_splice($_GET, 0);

			// Fake an error module call
			$_GET["module"] = "error";
			$_GET["code"] = $code;
			$_GET["status"] = self::$response_status[$code];
			$_GET["msg"] = $msg;
			// Add additional parameters
			foreach ($params as $key => $val)
				$_GET[$key] = $val;

			// Include the index with the new GET parameters
			include "index.php";
			// Don't continue initial request
			die;
		}

		// Otherwise, die with the code, status and message as default behaviour
		http_response_code($code);
		die("<pre>$code " . self::$response_status[$code] . ": $msg</pre>");
	}

	/**
	 * Execute a database request with the given parameters
	 * @param PDO $db The PDO object representing the database connection
	 * @param string $request The SQL query string that may contains parameters token
	 * @param array $params The parameters array
	 * @param bool $multiple Whether or not the request should return multiple rows
	 * @param int $fetch_style The PDO fetch style
	 * @return stdClass|array|false The SQL results for the query, or false if not multiple and no results are returned
	 * @see PDO::prepare()
	 * @see PDOStatement::execute(), PDOStatement::fetch(), PDOStatement::fetchAll()
	 */
	static function executeRequest($db, $request, $params = array(), $multiple = true, $fetch_style = PDO::FETCH_OBJ) {
		// Prepare the request
		$query = $db->prepare($request);
		// Execute it with the parameters and handle possibles SQL errors
		if (!$query->execute($params))
			self::error(500, "Erreur lors de l'exécution d'une requête SQL<pre class='text-white'>" . $query->errorInfo()[2] . "</pre>");
		// Fetch and return the data in the requested format
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
