<?php
namespace Module;

use Utils;

include_once "modules/generic/View.php";

class WikiPageView extends View {
	public function classicPage($data) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9 wiki-body pt-5">
						<div class="row">
							<div class="col-6">
								<img class="w-100" src="<?= $data->img ?>" alt="<?= $data->title ?>" />
								<h2><?= htmlspecialchars($data->title) ?></h2>
							</div>
							<div class="col-6">
								<div class="border border-light px-5">
									<h2>Description</h2>
									<?php
									$content = Utils::loadComponent("markdowntext", false, $data->content);
									$content->generateRender();
									$content->display();
									?>
								</div>
								<h4>
									Crée par <strong><?= htmlspecialchars($data->name) ?></strong> le <?= Utils::formatDate($data->created_at) ?>
									<?php if ($data->edited_at) echo " - Modifié le " . Utils::formatDate($data->edited_at); ?>
								</h4>
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

	public function entityPage($entity) { ?>
			<div>
				<div id="info">
					<h3>Description</h3>
					<p><?= $entity->description ?></p>

					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col">Type d'unité</th>
								<th scope="col">Type de dégpâts</th>
								<th scope="col">Dimension</th>
								<th scope="col">Cibles</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<?= $entity->type ?>
								</td>
								<td>
									<?php
									$stat = $entity->type == "hero" ? "stats" : "tier1";
									if (isset($entity->$stat->shoot_range)) {
										if (isset($entity->$stat->atk_range))
											echo "Polyvalent simple";
										else
											echo "Distance simple";
									}
									else
										echo "Mêlée simple";
									?>
								</td>
								<td>
									<?= $entity->size->width ?>
								</td>
								<td>
									<?php

									?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
	<?php }
}
