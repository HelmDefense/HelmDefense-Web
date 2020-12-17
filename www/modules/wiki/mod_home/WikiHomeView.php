<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class WikiHomeView extends View {
	public function homePage($homeText, $pages, $entities, $levels) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9">
						<h2>Wiki Helm Defense</h2>
						<div class="wiki-body">
							<p>Bienvenue sur le Wiki de Helm Defense.</p>
							<div class="text-justify">
								<?php
								$home = Utils::loadComponent("markdowntext", false, $homeText);
								$home->generateRender();
								$home->display();
								?>
							</div>
							<h3 class="section-title">Pages récentes</h3>
							<div class="wiki-pagepreview-parent">
								<?php $this->pagePreviewList($pages); ?>
							</div>
							<h3 class="section-title">Quelques entités</h3>
							<div class="wiki-pagepreview-parent">
								<?php $this->pagePreviewList($entities, "entity"); ?>
							</div>
							<h3 class="section-title">Quelques niveaux</h3>
							<div class="wiki-pagepreview-parent">
								<?php $this->pagePreviewList($levels, "level"); ?>
							</div>
						</div>
					</div>
					<div class="wiki-sidebar-container col-12 col-xl-3">
						<?php
						$sidebar = Utils::loadComponent("wikisidebar");
						$sidebar->generateRender();
						$sidebar->display();
						?>
					</div>
				</div>
			</div>
	<?php }

	public function pageList($pages, $type) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9">
						<h2>Wiki Helm Defense</h2>
						<div class="wiki-body">
							<h3 class="section-title"><?= $type == "entity" ? "Entités" : "Niveaux" ?></h3>
							<div class="wiki-pagepreview-parent">
								<?php $this->pagePreviewList($pages, $type); ?>
							</div>
						</div>
					</div>
					<div class="wiki-sidebar-container col-12 col-xl-3">
						<?php
						$sidebar = Utils::loadComponent("wikisidebar");
						$sidebar->generateRender();
						$sidebar->display();
						?>
					</div>
				</div>
			</div>
	<?php }

	private function pagePreviewList($list, $type = "page") {
		foreach ($list as $item) {
			$preview = Utils::loadComponent("wikipagepreview", false, $item, $type, "h4");
			$preview->generateRender();
			$preview->display();
		}
	}
}
