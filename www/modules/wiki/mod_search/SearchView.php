<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class SearchView extends View {
	public function searchPage() { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9">
						<h2>Wiki Helm Defense</h2>
						<div class="wiki-body">
							<?php $this->form(); ?>
						</div>
					</div>
					<div class="col-xl-3 wiki-sidebar-container col-12">
						<?php
							$sidebar = Utils::loadComponent("wikisidebar");
							$sidebar->generateRender();
							$sidebar->display();
						?>
					</div>
				</div>
			</div>
	<?php }

	public function resultPage($result, $search, $type) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9">
						<h2>Wiki Helm Defense</h2>
						<div class="wiki-body">
							<?php $this->form($search, $type); ?>
							<div id="resultDiv" class="col">
								<h3>Résultats de recherche pour "<?= htmlspecialchars($search) ?>" (<?= $this->displayType($type) ?>)</h3>
								<div id="result-container" class="wiki-pagepreview-parent">
									<?php
									if (count($result))
										foreach ($result as $value) {
											$preview = Utils::loadComponent("wikipagepreview", false, $value, $type, "h4");
											$preview->generateRender();
											$preview->display();
										}
									else
										echo "<p class='p-3'>Aucun résultat de recherche</p>";
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 wiki-sidebar-container col-12">
						<?php
						$sidebar = Utils::loadComponent("wikisidebar");
						$sidebar->generateRender();
						$sidebar->display();
						?>
					</div>
				</div>
			</div>
	<?php }

	private function form($search = "", $type = "page") { ?>
			<form id="search-form">
				<div id="recherche" class="d-flex">
					<img id="loupe" src="/data/img/loupe.svg" alt="" />
					<h3>Recherche</h3>
				</div>
				<label class="sr-only" for="search">Votre recherche...</label>
				<div class="position-relative">
					<input id="search" name="search" type="text" placeholder="" value="<?= $search ?>" required autofocus />
					<input class="submit-search" type="image" src="/data/img/arrow.svg" alt="->" onclick="$('#search-form').submit()" />
				</div>
				<h3 class="titleTypeSearch">Type de recherche</h3>
				<div class="row">
					<div class="col-12 col-md-auto">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="type-page" name="type" class="custom-control-input" value="page" <?php if ($type == "page") echo "checked"; ?> />
							<label class="custom-control-label" for="type-page">Pages</label>
						</div>
					</div>
					<div class="col-12 col-md-auto">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="type-entity" name="type" class="custom-control-input" value="entity" <?php if ($type == "entity") echo "checked"; ?> />
							<label class="custom-control-label" for="type-entity">Entités</label>
						</div>
					</div>
					<div class="col-12 col-md-auto">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="type-level" name="type" class="custom-control-input" value="level" <?php if ($type == "level") echo "checked"; ?> />
							<label class="custom-control-label" for="type-level">Niveaux</label>
						</div>
					</div>
				</div>
				<script>
					$("#search-form").on("submit", e => {
						e.preventDefault();
						const type = $("input[name=type]:checked").val();
						const search = encodeURIComponent($("#search").val().replaceAll("/", "%2F").replaceAll("\\", "%5C"));
						if (type && search)
							window.location.href = `/wiki/search/${type}/${search}`;
					});
				</script>
			</form>
	<?php }

	private function displayType($type) {
		switch ($type) {
			case "page":
				return "Pages";
			case "level":
				return "Niveaux";
			case "entity":
				return "Entités";
			default:
				return "";
		}
	}
}
