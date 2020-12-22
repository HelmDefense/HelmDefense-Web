/**
 * Core object of all Utils JavaScript functions
 */
const Utils = {};

/**
 * All functions related to Bootstrap's alerts
 */
Utils.alerts = {};

/**
 * The default CSS selector of the alert messages container
 * @type {string}
 */
Utils.alerts.MESSAGE_CONTAINER = "#message-container";

/**
 * The message cache for unique alerts
 * @type {string[]}
 */
Utils.alerts.MESSAGE_CACHE = [];

/**
 * Display a message using Bootstrap's alert of given type
 * @param {("primary"|"secondary"|"success"|"danger"|"warning"|"info"|"light"|"dark")} type - The alert type
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {HTMLElement|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.primary
 * @see Utils.alerts.secondary
 * @see Utils.alerts.success
 * @see Utils.alerts.danger
 * @see Utils.alerts.warning
 * @see Utils.alerts.info
 * @see Utils.alerts.light
 * @see Utils.alerts.dark
 */
Utils.alerts.message = function(type, message, dismissible, unique, container = null) {
	let id = `${type}-${message}`;
	if (unique) {
		if (Utils.alerts.MESSAGE_CACHE.includes(id))
			return;
		Utils.alerts.MESSAGE_CACHE.push(id);
	}
	let alert = $(document.createElement("div"));
	alert.text(message);
	alert.addClass(`alert alert-${type}`);
	if (dismissible) {
		alert.addClass("alert-dismissible fade show");
		alert.append("<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span></button>");
		unique && alert.on("closed.bs.alert", () => Utils.alerts.MESSAGE_CACHE.splice(Utils.alerts.MESSAGE_CACHE.indexOf(id), 1));
	}
	(container || $(Utils.alerts.MESSAGE_CONTAINER)).append(alert);
}

/**
 * Display a primary alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {HTMLElement|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.primary = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("primary", message, dismissible, unique, container);
}

/**
 * Display a secondary alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {HTMLElement|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.secondary = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("secondary", message, dismissible, unique, container);
}

/**
 * Display a success alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {HTMLElement|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.success = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("success", message, dismissible, unique, container);
}

/**
 * Display a danger alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {HTMLElement|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.danger = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("danger", message, dismissible, unique, container);
}

/**
 * Display a warning alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {HTMLElement|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.warning = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("warning", message, dismissible, unique, container);
}

/**
 * Display an info alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {HTMLElement|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.info = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("info", message, dismissible, unique, container);
}

/**
 * Display a light alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {HTMLElement|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.light = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("light", message, dismissible, unique, container);
}

/**
 * Display a dark alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {HTMLElement|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.dark = function(message, dismissible=false, unique=false, container=null) {
	Utils.alerts.message("dark", message, dismissible, unique, container);
}
