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
					<!-- TODO La description est rédigée en Markdown et doit être traduite -->
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
									<!-- TODO Afficher le type de façon plus propre (en français, avec une majuscule, etc...) -->
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
									<!-- TODO Le pluriel si besoin -->
									<?= $entity->size->width . " case" ?>
								</td>

								<td>
									<?php
									// TODO Utiliser le type de l'entité ($entity->type) pour cela
									if ($entity->num == 1 || $entity->num == 3)
										echo "Attaquants";
									else
										echo "Défenseurs";
									?>
								</td>
							</tr>
						</tbody>
					</table>

					<!-- TODO Et pour les héros ? Potentiellement réutiliser la variable $stat déterminée plus haut pour éviter la redondence -->
					<?php if ($entity->type != "hero") { ?>
						<h3>Améliorations</h3>
						<h4>Statistiques</h4>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">Statistiques</th>
									<th scope="col">Tier1</th>
									<th scope="col">Tier2</th>
									<th scope="col">Tier3</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<!-- TODO Tu veux pas faire une boucle ? Parce que là, ta table fait près de 100 lignes déjà... -->
									<td>PV</td>
									<td><?= $entity->tier1->hp ?></td>
									<td><?= $entity->tier2->hp ?></td>
									<td><?= $entity->tier3->hp ?></td>
								</tr>

								<tr>
									<td>Dégâts</td>
									<td><?= $entity->tier1->dmg ?></td>
									<td><?= $entity->tier2->dmg ?></td>
									<td><?= $entity->tier3->dmg ?></td>
								</tr>

								<tr>
									<td>Vitesse d'attaque</td>
									<td><?= $entity->tier1->atk_spd ?></td>
									<td><?= $entity->tier2->atk_spd ?></td>
									<td><?= $entity->tier3->atk_spd ?></td>
								</tr>

								<tr>
									<td>Dégâts par seconde</td>
									<td><?= $entity->tier1->dmg * $entity->tier1->atk_spd ?></td>
									<td><?= $entity->tier2->dmg * $entity->tier2->atk_spd ?></td>
									<td><?= $entity->tier3->dmg * $entity->tier3->atk_spd ?></td>
								</tr>

								<?php if (isset($entity->$stat->atk_range)) { ?>
									<tr>
										<td>Portée (mêlée)</td>
										<td><?= $entity->tier1->atk_range ?></td>
										<td><?= $entity->tier2->atk_range ?></td>
										<td><?= $entity->tier3->atk_range ?></td>
									</tr>
								<?php }
								if (isset($entity->$stat->shoot_range)) { ?>
									<tr>
										<td>Portée (distance)</td>
										<td><?= $entity->tier1->shoot_range ?></td>
										<td><?= $entity->tier2->shoot_range ?></td>
										<td><?= $entity->tier3->shoot_range ?></td>
									</tr>
								<?php }
								if ($entity->type == "defender") { ?>
									<tr>
										<td>Coût à l'unité</td>
										<td><?= $entity->tier1->cost ?></td>
										<td><?= $entity->tier2->cost ?></td>
										<td><?= $entity->tier3->cost ?></td>
									</tr>
								<?php } ?>

								<tr>
									<td>Coût d'amélioration</td>
									<td>0</td>
									<td><?= $entity->tier2->unlock_cost ?></td>
									<td><?= $entity->tier3->unlock_cost ?></td>
								</tr>
							</tbody>
						</table>
					<?php } ?>

					<h4>Compétences</h4>
					<dl>
						<?php
						foreach ($entity->abilities as $abilityName => $ability)
							if (isset($ability->description))
								echo "<dt>$abilityName</dt><dd>$ability->description</dd>";
						?>
					</dl>
				</div>
			</div>
			<!-- TODO N'oublie pas la sidebar -->
	<?php }

	public function levelPage($level) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9 wiki-body">
						<h2><?= $level->name ?></h2>
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
}
