<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class WikiHomeView extends View {
	public function homePage($homeText, $pages, $entities, $levels) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9">
						<h2 class="wiki-title">Wiki Helm Defense</h2>
						<div class="wiki-body">
							<p>Bienvenue sur le Wiki de Helm Defense.</p>
							<div class="text-justify">
								<?= Utils::markdown($homeText); ?>
							</div>
							<h3 class="section-title">Pages récentes</h3>
							<div class="wiki-pagepreview-parent">
								<?php $this->pagePreviewList($pages); ?>
							</div>
							<div class="wiki-link-container">
								<a class="wiki-link" href="/wiki/search">Rechercher une page</a>
							</div>
							<h3 class="section-title">Quelques entités</h3>
							<div class="wiki-pagepreview-parent">
								<?php $this->pagePreviewList($entities, "entity"); ?>
							</div>
							<div class="wiki-link-container">
								<a class="wiki-link" href="/wiki/entity">Liste des entités</a>
							</div>
							<h3 class="section-title">Quelques niveaux</h3>
							<div class="wiki-pagepreview-parent">
								<?php $this->pagePreviewList($levels, "level"); ?>
							</div>
							<div class="wiki-link-container">
								<a class="wiki-link" href="/wiki/level">Liste des niveaux</a>
							</div>
						</div>
					</div>
					<div class="wiki-sidebar-container col-12 col-xl-3">
						<?= Utils::renderComponent("wikisidebar"); ?>
					</div>
				</div>
			</div>
	<?php }

	public function pageList($pages, $type) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9">
						<h2 class="wiki-title">Wiki Helm Defense</h2>
						<div class="wiki-body">
							<h3 class="section-title mt-0"><?= $type == "entity" ? "Entités" : "Niveaux" ?></h3>
							<div class="wiki-pagepreview-parent">
								<?php $this->pagePreviewList($pages, $type); ?>
							</div>
						</div>
					</div>
					<div class="wiki-sidebar-container col-12 col-xl-3">
						<?= Utils::renderComponent("wikisidebar"); ?>
					</div>
				</div>
			</div>
	<?php }

	private function pagePreviewList($list, $type = "page") {
		foreach ($list as $item)
			echo Utils::renderComponent("wikipagepreview", $item, $type, "h4");
	}
}
