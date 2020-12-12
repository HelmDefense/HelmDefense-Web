<?php
namespace Module;

include_once "modules/generic/View.php";

class WikiPageView extends View {

	public function classicPage($data){
		?>
			<div class="container">
				<div class="row mt-5">
					<div class="col-6">
						<img class="w-100" src=<?= $data->img ?>>
						<h2><?= $data->title ?></h2>
					</div>
					<div class="col-6">
						<div class="border border-light px-5">
							<h2>Description</h2>
							<p><?= $data->content ?></p>
						</div>
						<h4>Crée par <strong> <?= $data->name ?> </strong> le <?= $data->created_at?> - Modifié le <?= $data->edited_at ?></h4>
					</div>
				</div>
			</div>
		<?php
	}

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
