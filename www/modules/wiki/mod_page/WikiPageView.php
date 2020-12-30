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
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9 wiki-body">
						<div>
							<img src= "<?= $entity->img ?>" alt="<?= $entity->name ?>">
							<h2> <?= $entity->name ?> </h2>
						</div>
						<div id="info">
							<h3>Description</h3>
							<?php
							$content = Utils::loadComponent("markdowntext", false, $entity->description);
							$content->generateRender();
							$content->display();
							?>

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
											<?php
											switch ($entity->type) {
												case "defender":
													echo "Défenseur";
													break;
												case "attacker":
													echo "Attaquant";
													break;
												case "hero":
													echo "Héro";
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

							<h3>Améliorations</h3>
							<h4>Statistiques</h4>
							<table class="table table-bordered">
								<?php
								$stats = $entity->type == "hero" ? array("stats"=>"Par Défaut") : array("tier1"=>"Tier 1", "tier2"=>"Tier 2", "tier3"=>"Tier 3");
								?>
								<thead>
									<tr>
										<th scope="col">Statistiques</th>
										<?php
										foreach($stats as $s){
										?>
											<th> <?= $s ?> </th>
										<?php } ?>
									</tr>
								</thead>

								<tbody>
								<?php
								$infos = array(
										array(
												"name"=>"PV",
												"stat"=>"hp"
										),
										array(
												"name"=>"Dégâts",
												"stat"=>"dmg"
										),
										array(
												"name"=>"Vitesse d'attaque",
												"stat"=>"atk_spd"
										),
										array(
												"name"=>"Dégats par seconde",
												"stat"=>"dmg",
												"func"=>function($stat) { return $stat->dmg * $stat->atk_spd; }
										),
										array(
												"name"=>"Portée (mêlée)",
												"stat"=>"atk_range"
										),
										array(
												"name"=>"Portée (distance)",
												"stat"=>"shoot_range"
										),
										array(
												"name"=>"Coût à l'unité",
												"stat"=>"cost"
										),
										array(
												"name"=>"Coût d'améliration",
												"stat"=>"unlock_cost"
										),
										array(
												"name"=>"Récompense",
												"stat"=>"reward"
										),
								);

								foreach($infos as $info){
									if(isset($entity->$stat->{$info["stat"]})){
									?>
									<tr>
										<td><?= $info["name"] ?></td>
										<?php foreach($stats as $s=>$_){ ?>
											<td><?= isset($info["func"]) ? call_user_func($info["func"], $entity->$s) : $entity->$s->{$info["stat"]} ?></td>
										<?php } ?>
									</tr>
								<?php }
								} ?>
								</tbody>
							</table>

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

	public function levelPage($level) {
		Utils::addResource("<link href='/data/css/pagination.css' rel='stylesheet' />");
		?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-9 wiki-body">
						<img src="<?= $level->img ?>" alt="<?= $level->name ?>" />
						<h2><?= $level->name ?></h2>
						<div class="wiki-level-description">
							<h3>Description</h3>
							<?php
							$sidebar = Utils::loadComponent("markdowntext", false, $level->description);
							$sidebar->generateRender();
							$sidebar->display();
							?>
						</div>
						<script>
							/**
							 * @type {{
							 *  map: number[][],
							 *  spawns: {x: number, y: number}[],
							 *  target: {x: number, y: number},
							 *  doors: {x: number, y: number, hp: number}[],
							 *  id: string,
							 *  name: string,
							 *  description: string,
							 *  lives: number,
							 *  start_money: number,
							 *  img: string,
							 *  waves: {name: string, reward: number, entities: Object<number, string>}[]
							 * }}
							 */
							const level = JSON.parse('<?= strtr(json_encode($level), array("\\" => "\\\\", "'" => "\'")) ?>');
						</script>
						<div id="map" class="d-none d-lg-block"></div>
						<div class="wiki-level-info">
							<div>
								<h3>Spawns</h3>
								<?php
								$i = 1;
								foreach ($level->spawns as $spawn) {
									echo "<p class='map-spawn-legend' data-pos='$spawn->x;$spawn->y'>Spawn $i ($spawn->x ; $spawn->y)</p>";
									$i++;
								}
								?>
							</div>
							<div>
								<h3>Portes</h3>
								<?php
								$i = 1;
								foreach ($level->doors as $door) {
									echo "<p class='map-door-legend' data-pos='$door->x;$door->y'>Porte $i ($door->x ; $door->y) : $door->hp PV</p>";
									$i++;
								}
								?>
							</div>
							<div>
								<h3>Fin</h3>
								<p>Coordonnées (<?= $level->target->x ?> ; <?= $level->target->y ?>)</p>
							</div>
							<div>
								<h3>Nombre de vies</h3>
								<p><?= $level->lives ?></p>
							</div>
							<div>
								<h3>Somme de départ</h3>
								<p><?= $level->start_money ?></p>
							</div>
						</div>
						<div class="wiki-level-waves">
							<div>
								<h3>Vagues</h3>
								<div id="waves"></div>
							</div>
							<div>
								<p>Récompense : <span id="wave-reward"></span></p>
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
