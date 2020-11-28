<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class SearchView extends View {

	public function searchPage() { ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-9">
					<h2>Wiki Helm Defense</h2>
					<div id="search-container">
						<img src="">
						<h3>Recherche</h3>
						<form method="post">
							<label class="sr-only" for="search">votre recherche...</label>
							<input id="search" name="search" type="text" placeholder="" required />
							<input type="hidden" name="check" value="check"/>
							<input type="hidden" name="typeSearch" value="typeSearch" />
						</form>
					</div>

					<div>
						<h3>Résultats de recherche</h3>
						<div>
							<?php
							?>
						</div>
					</div>
				</div>
				<div class="col-3">
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
				<div class="col-9">
					<h2>Wiki Helm Defense</h2>
					<div class="row">
						<div id="search-container">
							<img src="">
							<h3>Recherche</h3>
							<input id="search" name="recherche" type="text" placeholder="" required />
						</div>
					</div>

					<div class="row">
						<h3>Résultats de recherche</h3>
						<div id="result-container" class="">
							<?php foreach ($result as $value) {
								$preview = Utils::loadComponent("wikipagepreview", false, $value, "h4");
								$preview->generateRender();
								$preview->display();
							} ?>
						</div>
					</div>
				</div>

				<div class="col-3">
					<?php
					$sidebar = Utils::loadComponent("wikisidebar");
					$sidebar->generateRender();
					$sidebar->display();
					?>
				</div>
			</div>
		</div>
	<?php }
}