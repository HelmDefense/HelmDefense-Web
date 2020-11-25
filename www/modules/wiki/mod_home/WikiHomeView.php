<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class WikiHomeView extends View {
	public function homePage($homeText, $pages, $entities, $levels) { ?>
			<h2>Wiki Helm Defense</h2>
			<div>
				<p>Bienvenue sur le Wiki de Helm Defense.</p>
				<?php
					$home = Utils::loadComponent("markdowntext", false, $homeText);
					$home->generateRender();
					$home->display();
				?>
				<h3>Pages récentes</h3>
				<div>
					<?php var_dump($pages); ?>
				</div>
				<h3>Quelques entités</h3>
				<div>
					<?php var_dump($entities); ?>
				</div>
				<h3>Quelques niveaux</h3>
				<div>
					<?php var_dump($levels); ?>
				</div>
			</div>
	<?php }
}
