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
						<div class="masterDiv">
							<div id="recherche" class="container d-flex">
								<img id="loupe" src="/data/img/Loupe.svg" alt="">
								<h3>Recherche</h3>
							</div>
							<form method="post">
								<label class="sr-only" for="search">votre recherche...</label>
								<input id="search" name="search" type="text" placeholder="" required />
								<input type="hidden" name="check" value="check"/>
								<input type="hidden" name="typeSearch" value="typeSearch" />
							</form>
						</div>
					</div>

					<div id="resultDiv" class="row masterDiv">
						<h3>Résultats de recherche</h3>
						<div>
							<?php
							?>
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

	public function resultPage($result, $search, $typeSearch) { ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-xl-9">
					<h2>Wiki Helm Defense</h2>
					<div class="row">
						<div class="masterDiv">
							<div id="recherche" class="container d-flex">
								<img id="loupe" src="/data/img/Loupe.svg" alt="">
								<h3>Recherche</h3>
							</div>
							<form method="post">
								<label class="sr-only" for="search">votre recherche...</label>
								<input id="search" name="search" type="text" placeholder="" required />
								<input type="hidden" name="check" value="check"/>
								<input type="hidden" name="typeSearch" value="typeSearch" />
							</form>
						</div>
					</div>

					<div id="resultDiv" class="row masterDiv">
						<h3>Résultats de recherche</h3>
						<div id="result-container" class="d-flex">
							<?php foreach ($result as $value) { ?>
								<div class="wiki-pagepreview-container">
								<?php $preview = Utils::loadComponent("wikipagepreview", false, $value, null, "h4");
								$preview->generateRender();
								$preview->display(); ?>
								</div>
							<?php } ?>
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
}