<?php
namespace Module;

use Utils;

class WikiPageView extends View {
	public function classicPage($data) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9 wiki-body">
						<div class="row">
							<div class="col-12 col-lg-4">
								<img class="w-100" src="<?= $data->img ?>" alt="<?= $data->title ?>" />
								<h2 class="wiki-page-title"><?= htmlspecialchars($data->title) ?></h2>
							</div>
							<div class="col-12 col-lg-8">
								<div class="wiki-page-content">
									<?= Utils::markdown($data->content) ?>
								</div>
								<p>
									Crée par <strong><a href="/user/profile/<?= $data->author ?>"><?= htmlspecialchars($data->name) ?></a></strong> le <?= Utils::formatDate($data->created_at) ?>
									<?php if ($data->edited_at) echo " - Modifié le " . Utils::formatDate($data->edited_at); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="wiki-sidebar-container col-12 col-xl-3">
						<?= Utils::renderComponent("wikisidebar"); ?>
					</div>
				</div>
			</div>
	<?php }

	public function entityPage($entity) { ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9 wiki-body">
						<div class="row">
							<div class="col-12 col-lg-4">
								<img class="w-100" src="<?= $entity->img ?>" alt="<?= $entity->name ?>" />
								<h2 class="wiki-page-title"><?= htmlspecialchars($entity->name) ?></h2>
							</div>
							<div class="col-12 col-lg-8">
								<div class="wiki-page-content markdown">
									<h1>Description</h1>
									<?= Utils::markdown($entity->description) ?>
									<table class="text-center">
										<thead>
											<tr>
												<th scope="col">Type d'unité</th>
												<th scope="col">Type de dégâts</th>
												<th scope="col">Dimension</th>
												<th scope="col">Cible</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<?php
													switch ($entity->type) {
													case "defender":
														echo "Défenseur";
														break;
													case "attacker":
														echo "Attaquant";
														break;
													case "hero":
														echo "Héros";
														break;
													case "boss":
														echo "Boss";
														break;
													default:
														echo "Inconnu";
													}
													?>
												</td>
												<td>
													<?php
													$stat = $entity->type == "hero" ? "stats" : "tier1";
													if (isset($entity->$stat->shoot_range))
														echo isset($entity->$stat->atk_range) ? "Polyvalent" : "Distance simple";
													else
														echo "Mêlée simple";
													?>
												</td>
												<td>
													<?php
													$size = $entity->size->width;
													echo "$size case". ($size < 2 ? "" : "s");
													?>
												</td>
												<td>
													<?= ($entity->type == "defender" || $entity->type == "hero") ? "Attaquants" : "Défenseurs" ?>
												</td>
											</tr>
										</tbody>
									</table>
									<h1>Améliorations</h1>
									<h2>Statistiques</h2>
									<table class="text-center">
										<?php
										$stats = $entity->type == "hero" ? array("stats" => "Par défaut") : array("tier1" => "Tier 1", "tier2" => "Tier 2", "tier3" => "Tier 3");
										?>
										<thead>
											<tr>
												<th scope="col">Statistiques</th>
												<?php
												foreach ($stats as $s) { ?>
													<th scope="col"><?= $s ?></th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
										<?php
										$infos = array(
												array("name" => "PV", "stat" => "hp"),
												array("name" => "Dégâts", "stat" => "dmg"),
												array("name" => "Vitesse d'attaque", "stat" => "atk_spd"),
												array("name" => "Dégats par seconde", "stat" => "dmg", "func" => function($stat) { return $stat->dmg * $stat->atk_spd; }),
												array("name" => "Portée (mêlée)", "stat" => "atk_range"),
												array("name" => "Portée (distance)", "stat" => "shoot_range"),
												array("name" => "Coût à l'unité", "stat" => "cost"),
												array("name" => "Coût d'amélioration", "stat" => "unlock_cost"),
												array("name" => "Récompense", "stat" => "reward")
										);
										foreach ($infos as $info) {
											if (isset($entity->$stat->{$info["stat"]})) { ?>
											<tr>
												<td><?= $info["name"] ?></td>
												<?php foreach ($stats as $s => $_) { ?>
													<td><?= isset($info["func"]) ? call_user_func($info["func"], $entity->$s) : $entity->$s->{$info["stat"]} ?></td>
												<?php } ?>
											</tr>
											<?php }
										} ?>
										</tbody>
									</table>
									<h2>Compétences</h2>
									<dl>
										<?php
										foreach ($entity->abilities as $ability)
											if (isset($ability->description))
												echo "<dt>" . htmlspecialchars($ability->name) . "</dt><dd>" . Utils::markdown($ability->description) . "</dd>";
										?>
									</dl>
								</div>
							</div>
						</div>
					</div>
					<div class="wiki-sidebar-container col-12 col-xl-3">
						<?= Utils::renderComponent("wikisidebar"); ?>
					</div>
				</div>
			</div>
	<?php }

	public function levelPage($level) {
		Utils::addResource("<link href='/data/css/pagination.css' rel='stylesheet' />");
		?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9 wiki-body">
						<img class="wiki-level-image" src="<?= $level->img ?>" alt="<?= $level->name ?>" />
						<h2><?= $level->name ?></h2>
						<div class="wiki-page-content markdown">
							<h1>Description</h1>
							<?= Utils::markdown($level->description) ?>
						</div>
						<?= Utils::toJSObject($level, "level", "const") ?>
						<div id="map" class="d-none d-lg-block"></div>
						<div class="wiki-page-content wiki-level-info">
							<div class="row">
								<div class="col-12 col-lg-4">
									<h3>Spawns</h3>
									<?php
									$i = 1;
									foreach ($level->spawns as $spawn) {
										echo "<p class='map-spawn-legend' data-pos='$spawn->x;$spawn->y'>Spawn $i ($spawn->x ; $spawn->y)</p>";
										$i++;
									}
									?>
								</div>
								<div class="col-12 col-lg-4">
									<h3>Portes</h3>
									<?php
									$i = 1;
									foreach ($level->doors as $door) {
										echo "<p class='map-door-legend' data-pos='$door->x;$door->y'>Porte $i ($door->x ; $door->y) : $door->hp PV</p>";
										$i++;
									}
									?>
									<h3>Fin</h3>
									<p>Coordonnées (<?= $level->target->x ?> ; <?= $level->target->y ?>)</p>
								</div>
								<div class="col-12 col-lg-4">
									<h3>Nombre de vies</h3>
									<p><?= $level->lives ?></p>
									<h3>Somme de départ</h3>
									<p><?= $level->start_money ?></p>
								</div>
							</div>
						</div>
						<div class="wiki-level-waves">
							<div class="row align-items-center">
								<div class="col-12 col-lg-2">
									<h3 class="text-center">Vagues</h3>
								</div>
								<div class="col-12 col-lg-10">
									<div id="waves"></div>
								</div>
							</div>
							<div>
								<p class="wave-reward-text text-center">Récompense : <span id="wave-reward"></span></p>
								<div id="entities" class="carousel slide" data-interval="false">
									<div class="carousel-inner"></div>
									<a class="carousel-control-prev" href="#entities" data-slide="prev">
										<span class="carousel-control-prev-icon"></span>
									</a>
									<a class="carousel-control-next" href="#entities" data-slide="next">
										<span class="carousel-control-next-icon"></span>
									</a>
								</div>
							</div>
						</div>
						<script src="/data/js/wiki-level.js" async></script>
					</div>
					<div class="wiki-sidebar-container col-12 col-xl-3">
						<?= Utils::renderComponent("wikisidebar"); ?>
					</div>
				</div>
			</div>
	<?php }
}
