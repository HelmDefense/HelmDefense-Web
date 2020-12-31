"use strict";

/**
 * Core object of all Utils JavaScript functions
 */
const Utils = {};

/**
 * Miscellaneous utils
 */
Utils.misc = {};

/**
 * The URL of the website
 * @type {string}
 */
Utils.misc.SITE_URL = "https://helmdefense.theoszanto.fr/";

/**
 * The URL of the API
 * @type {string}
 */
Utils.misc.API_URL = "https://api.helmdefense.theoszanto.fr/";
// Utils.misc.API_URL = "http://helmdefense-api/";

/**
 * The window object as jQuery
 * @type {*|Window.jQuery|HTMLElement}
 */
Utils.misc.jWindow = $(window);

/**
 * Check deep equality between two values
 * @template T
 * @param {T} val1 - The first value
 * @param {T} val2 - The second value
 * @return {boolean} - Whether the two values are equals or not
 */
Utils.misc.equals = function(val1, val2) {
	if (Array.isArray(val1) && Array.isArray(val2)) {
		if (!Utils.misc.arrayEquals(val1, val2))
			return false;
	} else if (typeof val1 === "object" && typeof val2 === "object") {
		if (!Utils.misc.objectEquals(val1, val2))
			return false;
	} else if (val1 !== val2)
		return false;
	return true;
};

/**
 * Check deep equality between two objects
 * @param {Object} obj1 - The first object
 * @param {Object} obj2 - The second object
 * @return {boolean} - Whether the two objects are equals or not
 */
Utils.misc.objectEquals = function(obj1, obj2) {
	let keys = Object.keys(obj2);
	for (let key in obj1) {
		if (!(key in obj2))
			return false;
		keys.splice(keys.indexOf(key), 1);
		if (!Utils.misc.equals(obj1[key], obj2[key]))
			return false;
	}
	return keys.length === 0;
};

/**
 * Check deep equality between two arrays
 * @param {Array} arr1 - The first array
 * @param {Array} arr2 - The second array
 * @return {boolean} - Whether the two arrays are equals or not
 */
Utils.misc.arrayEquals = function(arr1, arr2) {
	if (arr1.length !== arr2.length)
		return false;
	for (let i = 0; i < arr1.length; i++) {
		if (!Utils.misc.equals(arr1[i], arr2[i]))
			return false;
	}
	return true;
};

/**
 * Custom collections redefined
 */
Utils.collections = {};

/**
 * Test equality between two values
 * @callback equalsCheck
 * @template T
 * @param {T} first - The first value
 * @param {T} second - The second value
 * @return {boolean} - Whether the two values are equals or not
 */

/**
 * A map that can accept a method to check keys equality
 * @template K, V
 */
Utils.collections.Map = class extends Map {
	/**
	 * Create a new map
	 * @param {equalsCheck<K>} [equals] - A key equality check method. If absent, the default method check strict equality (`===`)
	 */
	constructor(equals) {
		super();
		this.content = [];
		this.equals = equals || ((a, b) => a === b);
	}

	/**
	 * Remove all entries from this map
	 */
	clear() {
		this.content.length = 0;
	}

	/**
	 * Delete the entries with the given key
	 * @param {K} key - The key of the entry to delete
	 * @return {boolean} - Whether such an entry was present or not
	 */
	delete(key) {
		let oldSize = this.size;
		this.content = this.content.filter(item => !this.equals(item[0], key));
		return this.size !== oldSize;
	}

	/**
	 * Retrieve a list of key-value pairs with all entries from this map
	 * @return {<K, V>[][]} - The entries of the map
	 */
	entries() {
		return this.content;
	}

	/**
	 * @callback forEachEntry
	 * @template K, V, T
	 * @param {V} value - The value of the entry
	 * @param {K} key - The key of the entry
	 * @param {Utils.collections.Map<K, V>} map - The complete map
	 * @this {T}
	 */

	/**
	 * Apply this action for all entries of the map
	 * @template K, V, T
	 * @param {forEachEntry<K, V, T>} action - The action to execute
	 * @param {T} [thisArg] - The argument to use as `this`
	 */
	forEach(action, thisArg = this) {
		this.content.forEach(item => action.apply(thisArg, [item[1], item[0], this]));
	}

	/**
	 * Retrieve the value associated to the given key, or `undefined` if the key is not in the map.
	 * **Note:** The key may be mapped to value `undefined` so you could check with {@link has map.has(key)} if the key is present
	 * @param {K} key - The key to search for
	 * @return {V|undefined} - The associated value, or `undefined`
	 */
	get(key) {
		for (let item of this.content)
			if (this.equals(item[0], key))
				return item[1];
		return undefined;
	}

	/**
	 * Check if a key is present in the map
	 * @param {K} key - The key to search for
	 * @return {boolean} - Whether the key exists or not
	 */
	has(key) {
		for (let item of this.content)
			if (this.equals(item[0], key))
				return true;
		return false;
	}

	/**
	 * Extract a list of the keys of this map
	 * @return {K[]} - An array with all keys of this map
	 */
	keys() {
		return this.content.map(item => item[0]);
	}

	/**
	 * Define the value mapped to a key
	 * @param {K} key - The key to define
	 * @param {V} value - The value to map to the key
	 * @return {Utils.collections.Map} - Itself, to allow chained calls
	 */
	set(key, value) {
		for (let item of this.content) {
			if (this.equals(item[0], key)) {
				item[1] = value;
				return this;
			}
		}
		this.content.push([key, value]);
		return this;
	}

	/**
	 * Get the number of entries of this map
	 * @return {number} - The size of the map
	 */
	get size() {
		return this.content.length;
	}

	/**
	 * Extract a list of the values of this map
	 * @return {V[]} - An array with all values of this map
	 */
	values() {
		return this.content.map(item => item[1]);
	}
};

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
 * @param {jQuery|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
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
};

/**
 * Display a primary alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {jQuery|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.primary = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("primary", message, dismissible, unique, container);
};

/**
 * Display a secondary alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {jQuery|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.secondary = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("secondary", message, dismissible, unique, container);
};

/**
 * Display a success alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {jQuery|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.success = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("success", message, dismissible, unique, container);
};

/**
 * Display a danger alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {jQuery|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.danger = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("danger", message, dismissible, unique, container);
};

/**
 * Display a warning alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {jQuery|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.warning = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("warning", message, dismissible, unique, container);
};

/**
 * Display an info alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {jQuery|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.info = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("info", message, dismissible, unique, container);
};

/**
 * Display a light alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {jQuery|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.light = function(message, dismissible = false, unique = false, container = null) {
	Utils.alerts.message("light", message, dismissible, unique, container);
};

/**
 * Display a dark alert
 * @param {string} message - The message to display in the alert
 * @param {boolean} dismissible - Whether the alert should be dismissible or not
 * @param {boolean} unique - Whether the alert should not appear twice or not
 * @param {jQuery|null} container - Where to put the alert, if null, the value used is {@link Utils.alerts.MESSAGE_CONTAINER}
 * @see Utils.alerts.message
 */
Utils.alerts.dark = function(message, dismissible=false, unique=false, container=null) {
	Utils.alerts.message("dark", message, dismissible, unique, container);
};

/**
 * All functions related to Bootstrap's pagination
 */
Utils.pagination = {};

/**
 * A page of a {@link Pagination} object
 * @typedef {Object} Page
 * @property {number} num - The page number
 * @property {string} name - The page name
 * @property {boolean} selected - Whether the page was previously selected
 */

/**
 * @callback paginationCallback
 * @param {Page} page - The current page
 * @return {boolean} - Whether to re-render the pagination or not
 */

/**
 * A representation of a custom pagination
 * @see Utils.pagination.show
 */
Utils.pagination.Pagination = class {
	/**
	 * Create a new pagination
	 * @param {jQuery} container - Where to render this pagination
	 * @param {string[]} pages - The list of the pages
	 * @param {paginationCallback} callback - The callback for the user interactions
	 * @param {number} defaultPage - The selected page
	 * @param {boolean} triggerOnCreation - Whether to call the callback on creation or not
	 * @param {boolean} ignoreWhenSelected - Whether to call the callback only when the clicked element wasn't selected or not
	 * @param {string} customClass - The custom class to append to the pagination
	 */
	constructor(container, pages, callback, defaultPage, triggerOnCreation, ignoreWhenSelected, customClass) {
		this.container = container;
		this.pages = pages;
		this.callback = callback;
		this.currentPage = this.isValidPage(defaultPage) ? defaultPage : 1;
		this.ignoreWhenSelected = ignoreWhenSelected;
		this.customClass = customClass;
		/**
		 * @type {Page[]}
		 */
		this.display = [];

		if (triggerOnCreation)
			this.pageChanged();
		else
			this.render();
	}

	/**
	 * Render the pagination in it's container
	 */
	render() {
		this.display.length = 0;
		this.displayPage(this.currentPage, true);
		if (!this.displayPage(this.currentPage - 1))
			this.displayPage(this.currentPage + 2);
		if (!this.displayPage(this.currentPage + 1))
			this.displayPage(this.currentPage - 2);

		this.display.sort((p1, p2) => p1.num - p2.num);

		let pagination = $(document.createElement("ul"));
		pagination.addClass("pagination custom-pagination");
		pagination.addClass(this.customClass);

		let prevElem = $(document.createElement("li"));
		prevElem.addClass("page-item custom-pagination-prev");
		if (this.currentPage === 1)
			prevElem.addClass("disabled");
		else
			prevElem.on("click", e => {
				e.preventDefault();
				this.pageChanged(this.currentPage + 1);
			});
		prevElem.html(`<a class="page-link" href="#${this.toAnchorDisplay(this.currentPage - 1)}">&laquo;</a>`);
		pagination.append(prevElem);

		for (let page of this.display) {
			let pageElem = $(document.createElement("li"));
			pageElem.addClass("page-item custom-pagination-item");
			if (page.selected)
				pageElem.addClass("active");
			pageElem.html(`<a class="page-link" href="#${this.toAnchorDisplay(page.num)}">${page.name}</a>`);
			pageElem.on("click", e => {
				e.preventDefault();
				this.pageChanged(page.num, page);
			});
			pagination.append(pageElem);
		}

		let nextElem = $(document.createElement("li"));
		nextElem.addClass("page-item custom-pagination-next");
		if (this.currentPage === this.pages.length)
			nextElem.addClass("disabled");
		else
			nextElem.on("click", e => {
				e.preventDefault();
				this.pageChanged(this.currentPage + 1);
			});
		nextElem.html(`<a class="page-link" href="#${this.toAnchorDisplay(this.currentPage + 1)}">&raquo;</a>`);
		pagination.append(nextElem);

		this.container.html(pagination);
	}

	/**
	 * Execute the callback using the currentPage number or the given page
	 * @param {number} num - The new page number
	 * @param {Page|null} [page] - The page
	 */
	pageChanged(num = this.currentPage, page = null) {
		if (this.ignoreWhenSelected && page?.selected)
			return;
		if (this.callback(page || {num: num, name: this.pages[num - 1], selected: false})) {
			this.currentPage = num;
			this.render();
		}
	}

	/**
	 * Add the page with the number `num` to the display buffer if possible
	 * @param {number} num - The number of the page to display
	 * @param {boolean} [selected] - The selection state
	 * @return {boolean} - If the action was possible
	 */
	displayPage(num, selected = false) {
		if (this.isValidPage(num)) {
			this.display.push({num: num, name: this.pages[num - 1], selected: selected});
			return true;
		}
		return false;
	}

	/**
	 * Check that a page number is valid (the page exists)
	 * @param {number} num - The number to verify
	 * @return {boolean} - Whether or not the number is valid
	 */
	isValidPage(num) {
		return num > 0 && num <= this.pages.length;
	}

	/**
	 * Format the page number into a fake anchor
	 * @param {number} num - The page number
	 * @return {string} - The formatted page name as an anchor or an empty string if page was invalid
	 */
	toAnchorDisplay(num) {
		return this.isValidPage(num) ? this.pages[num - 1].toLowerCase().replaceAll(" ", "-") : "";
	}
};

/**
 * Create a new pagination with the given options
 * @param {Object} options - The options for this pagination
 * @param {jQuery} options.container - Where to render this pagination
 * @param {string[]} options.pages - The list of the pages
 * @param {paginationCallback} options.callback - The callback for the user interactions
 * @param {number} [options.defaultPage] - The selected page
 * @param {boolean} [options.triggerOnCreation] - Whether to call the callback on creation or not
 * @param {boolean} [options.ignoreWhenSelected] - Whether to call the callback only when the clicked element wasn't selected or not
 * @param {string} [options.customClass] - The custom class to append to the pagination
 * @see Utils.pagination.Pagination
 */
Utils.pagination.show = function(options) {
	if (!options.pages.length)
		return;
	new Utils.pagination.Pagination(
			options.container,
			options.pages,
			options.callback,
			options.defaultPage || 1,
			options.triggerOnCreation,
			options.ignoreWhenSelected,
			options.customClass
	);
};

/**
 * All functions related to jQuery's AJAX
 */
Utils.ajax = {};

/**
 * The cache used by {@link Utils.ajax.getWithCache}
 */
Utils.ajax.CACHE = new Utils.collections.Map(Utils.misc.objectEquals);

/**
 * @callback ajaxCallback
 * @param {any} data - The request's response
 * @param {"abort"|"error"|"notmodified"|"parsererror"|"success"|"timeout"|"cached"|"requested"} status - The request's status
 * @param {XMLHttpRequest} xhr - The request object
 * @return {boolean} - Whether to cache the result for futur requests or not.
 * **Note:** Pending requests to the same URL will still issue with `requested` status
 */

/**
 * Retrieve a resource from the cache or make an AJAX GET request if resource is absent
 * @param {Object} options - The options for this request
 * @param {string} options.url - The URL of the resource
 * @param {ajaxCallback} options.callback - The function to call with the request's response
 * @param {Object} [options.data] - The data of the request
 * @param {string} [options.type] - The type of the response data
 * @param {boolean} [options.toApi] - Whether to contact the API
 * @return {XMLHttpRequest} - The request
 */
Utils.ajax.getWithCache = function(options) {
	if (options.toApi)
		options.url = Utils.misc.API_URL + options.url;
	if (!options.data)
		options.data = {};

	let key = {url: options.url, data: options.data};
	if (Utils.ajax.CACHE.has(key)) {
		let cache = Utils.ajax.CACHE.get(key);
		if ("response" in cache) {
			options.callback(cache.response, "cached", cache.request);
			return cache.request;
		}
		return cache.request.always(data => options.callback(data, "requested", cache.request));
	}

	let request = $.get(options.url, options.data, (data, status, xhr) => {
		if (options.callback(data, status, xhr))
			Utils.ajax.CACHE.get(key).response = data;
		else
			Utils.ajax.CACHE.delete(key);
	}, options.type);
	Utils.ajax.CACHE.set(key, {request: request});
	return request;
};

/**
 * All functions related to Bootstrap's tooltips
 */
Utils.tooltip = {};

/**
 * Add a tooltip on the specified element
 * @param {jQuery|string} element - The targeted element
 * @param {string} text - The text of the tooltip
 * @param {"auto"|"top"|"right"|"left"|"bottom"} [placement] - The placement of the tooltip
 * @param {boolean} [html] - Whether the tooltip text contains HTML or not
 */
Utils.tooltip.add = function(element, text, placement = "auto", html = false) {
	let el = $(element);
	el.attr("data-toggle", "tooltip").attr("data-placement", placement).attr("title", text);
	if (html)
		el.attr("data-html", "true");
	el.tooltip();
};
