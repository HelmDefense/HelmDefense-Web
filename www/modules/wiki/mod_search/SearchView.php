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
					<div class="row">
						<?php $this->form() ?>
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

	public function resultPage($result, $search, $typeSearch) { ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-xl-9">
					<h2>Wiki Helm Defense</h2>
					<div class="row">
							<?php $this->form($search, $typeSearch) ?>
					</div>

					<div id="resultDiv" class="col">
						<h3>Résultats de recherche pour "<?= $search ?>" (<?= $this->displayType($typeSearch) ?>)</h3>
						<div id="result-container" class="wiki-pagepreview-parent">
							<?php
							if(count($result))
								foreach ($result as $value) {
									$preview = Utils::loadComponent("wikipagepreview", false, $value, $typeSearch, "h4");
									$preview->generateRender();
									$preview->display();
								}
							else {
								echo "aucun résultat de recherche";
							}?>
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

	private function form($search = "", $typeSearch = "page") { ?>
			<form method="post">
				<div id="recherche" class="container d-flex">
					<img id="loupe" src="/data/img/Loupe.svg" alt="">
					<h3>Recherche</h3>
				</div>
				<label class="sr-only" for="search">votre recherche...</label>
				<input id="search" name="search" type="text" placeholder="" value="<?= $search ?>" required />
				<input type="hidden" name="check" value="check"/>

				<h3 class="titleTypeSearch">Type de recherche</h3>
				<div class="custom-control custom-radio custom-control-inline radioButton ">
					<input type="radio" id="customRadio2" name="typeSearch" class="custom-control-input" value="page" <?php if($typeSearch == "page") echo "checked"; ?> >
					<label class="custom-control-label" for="customRadio2">Pages</label>
				</div>
				<div class="custom-control custom-radio custom-control-inline radioButton">
					<input type="radio" id="customRadio3" name="typeSearch" class="custom-control-input" value="entity" <?php if($typeSearch == "entity") echo "checked"; ?> >
					<label class="custom-control-label" for="customRadio3">Entités</label>
				</div>
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="customRadio4" name="typeSearch" class="custom-control-input" value="level" <?php if($typeSearch == "level") echo "checked"; ?> >
					<label class="custom-control-label" for="customRadio4">Niveaux</label>
				</div>
			</form>
	<?php }

	private function displayType($typeSearch) {
		switch ($typeSearch) {
			case "page":
				return "Page";
			case "level":
				return "Niveau";
			case "entity":
				return "Entité";
			default:
				return "";
		}
	}
}