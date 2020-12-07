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
								?></td>
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

		<?php
	}

}
