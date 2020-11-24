<?php
namespace Module;

include_once "modules/generic/View.php";

class WikiHomeView extends View {
	public function homePage($pages, $entities, $levels) { ?>
			<h2>Wiki Helm Defense</h2>
			<div>
				<p>Bienvenue sur le Wiki de Helm Defense.</p>
				<p></p>
			</div>
	<?php }
}
