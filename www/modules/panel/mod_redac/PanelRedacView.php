<?php
namespace Module;

use Utils;

class PanelRedacView extends View {
	public function displayList($pages, $count, $limit, $p) {
		Utils::addResource("<link href='/data/css/pagination.css' rel='stylesheet' />");
		$total = ceil($count / $limit); ?>
		<div class="container panel-body">
			<h2>Panel de rédaction</h2>
			<a class="btn sub-btn panel-btn" href="/panel/redac/new">Nouvelle page</a>
			<table class="w-100 custom-table">
				<thead>
					<tr>
						<th>N°</th>
						<th>ID</th>
						<th>Titre</th>
						<th>Auteur</th>
						<th>Création</th>
						<th>Edition</th>
						<th>Publiée</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pages as $page) { ?>
						<tr>
							<td><?= $page->num ?></td>
							<td><a href="/panel/redac/edit/<?= $page->num ?>" data-toggle="tooltip" title="Éditer la page"><?= $page->id ?></td>
							<td><a href="/wiki/page/<?= $page->id ?>" data-toggle="tooltip" title="Voir la page Wiki" target="_blank"><?= htmlspecialchars($page->title) ?></td>
							<td><a href="/user/profile/<?= $page->author ?>" data-toggle="tooltip" title="Voir le profil de l'auteur" target="_blank"><?= htmlspecialchars($page->author_name) ?></a></td>
							<td><?= Utils::formatDate($page->created_at) ?></td>
							<td><?= is_null($page->edited_at) ? "<span data-toggle='tooltip' title=\"La page n'a jamais été éditée\">&times;</span>" : Utils::formatDate($page->edited_at) ?></td>
							<td><?= $page->published ? "<span class='badge badge-success'>Oui</span>" : "<span class='badge badge-danger'>Non</span>" ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="navigation mt-4"></div>
			<script>
				Utils.pagination.show({
					container: $(".navigation"),
					pages: ["<?= implode('", "', range(1, $total)) ?>"],
					callback: page => {
						if (page.num <= 0 || page.num > <?= $total ?>)
							return false;
						window.location.href = `/panel/redac/home/${page.num}/<?= $limit ?>`;
						return true;
					},
					defaultPage: <?= $p ?>,
					triggerOnCreation: false,
					ignoreWhenSelected: true,
					customClass: "justify-content-center"
				});
			</script>
		</div>
	<?php }

	public function displayEditPage($num = 0, $id = "", $title = "", $content = "", $published = true, ...$errors) {
		Utils::addResource("<link href='/data/css/form.css' rel='stylesheet' />"); ?>
		<div class="container panel-body">
			<?php foreach ($errors as $error) { ?>
				<div class="alert alert-danger" role="alert">
					Erreur : <?= $error ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
			<?php } ?>
			<h2><?= $num ? "Édition de la" : "Nouvelle" ?> page Wiki</h2>
			<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="check" value="valid" />
				<img id="page-image" class="w-100" src="https://via.placeholder.com/250?text=data/img/wiki/<?= $num ?>.png" alt="Aucune" />
				<div class="custom-input-container">
					<div class="custom-file">
						<input id="image" name="image" class="custom-file-input" type="file" accept="image/png" required />
						<label class="custom-file-label" for="image" data-browse="Charger">Image de la page</label>
						<script>
                            $("#image").change(e1 => {
                                let file = e1.currentTarget.files[0];
                                $("label[for=image]").text(file.name);
                                let reader = new FileReader();
                                reader.onload = e2 => $("#page-image").attr("src", e2.target.result);
                                reader.readAsDataURL(file);
                            });
						</script>
					</div>
				</div>
				<div class="custom-input-container">
					<div class="custom-input">
						<input id="title" name="title" type="text" placeholder="" value="<?= $title ?>" required />
						<label for="title">Titre</label>
					</div>
				</div>
				<div class="row">
					<div class="custom-input-container col-12 col-lg-8">
						<div class="custom-input">
							<input id="id" name="id" type="text" placeholder="" value="<?= $id ?>" required />
							<label for="id">ID</label>
						</div>
					</div>
					<div class="custom-input-container col-12 col-lg-4 d-flex justify-content-center align-items-center">
						<div class="custom-control custom-switch published-switch">
							<input class="custom-control-input" id="published" name="published" type="checkbox"<?php if ($published) echo " checked"; ?> />
							<label class="custom-control-label" for="published">Publiée</label>
						</div>
					</div>
				</div>
				<div class="markdown-editor-container">
					<textarea id="content" name="content" placeholder="" required></textarea>
					<label class="sr-only" for="content">Contenu</label>
					<?= Utils::renderComponent("markdowneditor", "#content", $content, array("placeholder" => "Contenu")) ?>
				</div>
				<div class="row">
					<div class="col-12 col-lg-4 text-center text-lg-left">
						<a class="btn sub-btn panel-btn" href="/panel/redac">Annuler</a>
					</div>
					<div class="col-12 col-lg-4 text-center">
						<?php if ($num) { ?>
							<button id="suppress" class="btn sub-btn panel-btn" data-toggle="modal" data-target="#confirm-suppress">Supprimer la page</button>
							<script>
								$("#suppress").click(e => e.preventDefault());
							</script>
							<div id="confirm-suppress" class="modal custom-modal fade" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Confirmer la suppression</h3>
											<button class="close" data-dismiss="modal"><span>&times;</span></button>
										</div>
										<div class="modal-body">
											Êtes-vous sûr de confirmer la suppression de la page "<?= htmlspecialchars($title) ?>" (<?= htmlspecialchars($id) ?>) ? Cette action est irréversible !
										</div>
										<div class="modal-footer">
											<a class="btn main-btn panel-btn" href="/panel/redac/delete/<?= $num ?>">Confirmer la suppression</a>
											<button class="btn main-btn panel-btn" data-dismiss="modal">Annuler</button>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="col-12 col-lg-4 text-center text-lg-right">
						<input class="btn sub-btn panel-btn" type="submit" value="<?= $num ? "Éditer" : "Créer" ?> la page" />
					</div>
				</div>
			</form>
		</div>
	<?php }
}
