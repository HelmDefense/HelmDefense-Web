<?php
namespace Module;

include_once "modules/generic/View.php";

class WikiPageView extends View {

	public function entityPage($entity){
		?>
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

							<td><?php
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
								<?= $entity->size->width . " case" ?>
							</td>

							<td>
								<?php
									if ($entity->num == 1 || $entity->num == 3)
										echo "Attaquants";
									else
										echo "Défenseurs";
								?>
							</td>
						</tr>
					</tbody>
				</table>

				<?php
				if ($entity->type != "hero"){
					?>
					<h3>Améliorations</h3>
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

							<?php
							if (isset($entity->$stat->atk_range)){
							?>
								<tr>
									<td>Portée (mêlée)</td>
									<td><?= $entity->tier1->atk_range ?></td>
									<td><?= $entity->tier2->atk_range ?></td>
									<td><?= $entity->tier3->atk_range ?></td>
								</tr>
							<?php
							}
							if (isset($entity->$stat->shoot_range)){
							?>
								<tr>
									<td>Portée (distance)</td>
									<td><?= $entity->tier1->shoot_range ?></td>
									<td><?= $entity->tier2->shoot_range ?></td>
									<td><?= $entity->tier3->shoot_range ?></td>
								</tr>
							<?php
							}
							if ($entity->type == "defender"){
							?>
								<tr>
									<td>Coût à l'unité</td>
									<td><?= $entity->tier1->cost ?></td>
									<td><?= $entity->tier2->cost ?></td>
									<td><?= $entity->tier3->cost ?></td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				<?php
				}
				?>
			</div>


		</div>

		<?php
	}

}
