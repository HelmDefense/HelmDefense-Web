<div class="download d-flex align-items-center">
	<div class="mx-auto text-center">
		<h2 class="col-12">commencez l'aventure</h2>
		<p class="col-12">Maintenant</p>
		<a id="download" href="#popup" class="btn main-btn">Télécharger le jeu</a>
	</div>
</div>
<div id="popup" class="position-absolute align-items-center d-none">
	<div id="popup-content" class="container">
		<div class="versions-selector row align-items-center align-content-stretch">
			<div class="col-12 col-lg-4 text-center">
			    <p id="latest" class="btn main-btn mb-0">Dernière version</p>
			</div>
			<div class="col-12 col-lg-8">
			    <div id="versions"></div>
			</div>
		</div>
		<div id="release">
			<h2 class="name m-0"></h2>
			<div class="body markdown p-4"></div>
			<p class="text-center publish-date">Publication : <span class="publish"></span></p>
			<div class="text-center">
			    <a class="btn main-btn dl" href="">Télécharger cette version</a>
			</div>
		</div>
	</div>
</div>

<script>
	const popup = $("#popup");
	const download = $("#download");

	// Open popup on click on download button
	download.click(e => {
		e.preventDefault();
		e.stopImmediatePropagation();
		popup.removeClass("d-none");
		// Append #popup to the URL
		window.history.pushState("popup", null, "#popup");
	});
	// Or if the URL ends with #popup
	if (window.location.href.endsWith("#popup"))
		popup.removeClass("d-none");

	// Close popup on click anywhere except on the popup
	Utils.misc.jWindow.click(e => {
		// Check if popup is visible and verify the click is inside the popup content
		if (popup.hasClass("d-none") || e.target.id === "popup-content" || $(e.target).parents("#popup-content").length)
			return;
		e.preventDefault();
		popup.addClass("d-none");
		// Remove the #popup from the URL
		if (window.history.state === "popup")
			window.history.back();
		else
			window.history.pushState(null, null, "/download");
	});

	// Toggle the popup when using back / next browser arrow buttons
	Utils.misc.jWindow.on("popstate", () => {
		if (window.location.href.endsWith("#popup"))
			// Show popup
			popup.removeClass("d-none");
		else
			// Hide popup
			popup.addClass("d-none");
	});

	const release = $("#release");
	$.get("https://api.github.com/repos/HelmDefense/HelmDefense/releases" /* github/gh-ost */, versions => {
		let releases = Utils.pagination.show({
			container: $("#versions"),
			pages: versions.map(version => version.tag_name),
			callback: page => {
				/**
				 * @type {{
				 *  tag_name: string,
				 *  name: string,
				 *  published_at: string,
				 *  body: string,
				 *  assets: {browser_download_url: string, name: string}[]
				 * }}
				 */
				let version = versions.filter(version => version.tag_name === page.name)[0];
				if (version === undefined)
					return false;
				release.find(".name").text(version.name);
				$.post(`${Utils.misc.API_URL}v1/markdown`, {text: version.body}, result => release.find(".body").html(result.markdown));
				let publish_date = new Date(version.published_at);
				release.find(".publish").text(`${("0" + publish_date.getDate()).slice(-2)}/${("0" + (publish_date.getMonth() + 1)).slice(-2)}/${publish_date.getFullYear()}`);
				release.find(".dl").attr("href", version.assets[0].browser_download_url).attr("download", version.assets[0].name);
				return true;
			},
			triggerOnCreation: true,
			ignoreWhenSelected: true,
			customClass: "justify-content-center mb-0"
		});
		$("#latest").click(() => {
			if (releases.currentPage === 1)
				return;
			releases.pageChanged(1);
		});
	});
</script>
