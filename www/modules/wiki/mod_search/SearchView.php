<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class SearchView extends View {

	public function searchPage() { ?>
		<section>
			<h2>Wiki Helm Defense</h2>
			<div class="row">
				<div id="search-container" class="col-12 col-lg-6">
					<img src="">
					<h3>Recherche</h3>
					<form>
						<label class="sr-only" for="search">votre recherche...</label>
						<input id="search" name="recherche" type="text" placeholder="" required />
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
		</section>

	<?php }

	public function resultPage($result, $search, $typeSearch) { ?>
		<section>
			<h2>Wiki Helm Defense</h2>
			<div class="row">
				<div id="search-container" class="col-12 col-lg-6">
					<img src="">
					<h3>Recherche</h3>
					<input id="search" name="recherche" type="text" placeholder="" required />
				</div>
			</div>

			<div class="row">
				<h3>Résultats de recherche</h3>
				<div id="result-container" class="">
					<?php /*foreach ($result as $value) {
						$preview = Utils::loadComponent("wikipagepreview", false, $value);
						$preview->generateRender();
						$preview->display();
					} */?>
				</div>
			</div>
		</section>

		<aside>
			<div>
				<p>

				</p>
			</div>
			<h4>Activité récente du wiki</h4>
			<div>
				<h5></h5>
				<p>

				</p>
			</div>

			<div>
				<h5></h5>
				<p>

				</p>
			</div>

			<div>
				<h5></h5>
				<p>

				</p>
			</div>
		</aside>
	<?php }
}