<?php
namespace Module;

use Utils;

class PanelAdminView extends View {
	public function displayList($users, $pages, $count, $limit, $p) {
		Utils::addResource("<link href='/data/css/pagination.css' rel='stylesheet' />");
		Utils::addResource("<link href='/data/css/form.css' rel='stylesheet' />");
		$total = ceil($count / $limit); ?>
		<div class="container panel-body">
			<h2>Panel d'administration</h2>
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

			<table class="w-100 custom-table">
				<thead>
				<tr>
					<th>Avatar</th>
					<th>ID</th>
					<th>Login</th>
					<th>Nom</th>
					<th>Mail</th>
					<th>Date de création</th>
					<th>Rôles</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($users as $user) { ?>
					<tr>
						<td><img class="user-avatar" src="/data/img/avatar/<?= is_null($user->avatar) ? "default.png" : $user->avatar ?>" alt="Avatar de <?= $user->name ?>" /></td>
						<td><?= htmlspecialchars($user->id) ?></td>
						<td><a href="/panel/admin/edit/<?= $user->id ?>" data-toggle="tooltip" title="modifier les rôles de l'utilisateur" target="_blank"><?= htmlspecialchars($user->login) ?></a></td>
						<td><a href="/user/profile/<?= $user->login ?>" data-toggle="tooltip" title="Voir le profil de l'utilisateur" target="_blank"><?= htmlspecialchars($user->name) ?></a></td>
						<td><a href="mailto:<?= $user->email ?>"><?= htmlspecialchars($user->email) ?></a></td>
						<td><?= Utils::formatDate($user->joined_at) ?></td>
						<td>
							<?php
							if(count($user->ranks))
								$this->userRanks($user->ranks);
							else
								echo "<span data-toggle='tooltip' title=\"L'utilisateur n'a pas de rôles\">&times;</span>";
							?>
						</td>
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
		                window.location.href = `/panel/admin/home/${page.num}/<?= $limit ?>`;
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

	public function userRanks($ranks) {
		foreach ($ranks as $rank) { ?>
			<span class="badge sub-badge"><?= $this->rank($rank) ?></span>
		<?php }
	}

	public function rank($rank) {
		switch ($rank) {
		case "administrator":
			return "Administrateur";
		case "moderator":
			return "Modérateur";
		case "developer":
			return "Développeur";
		case "redactor":
			return "Rédacteur";
		default:
			return "";
		}
	}

	public function displayProfileRole($user) {
		Utils::addResource("<link href='/data/css/pagination.css' rel='stylesheet' />");
		Utils::addResource("<link href='/data/css/form.css' rel='stylesheet' />"); ?>
		<div class="text-center col-12 col-md-4">
			<img src="/data/img/avatar/<?= is_null($user->avatar) ? "default.png" : $user->avatar ?>" alt="Avatar de <?= $user->name ?>" />
			<form method="post">
				<div class="custom-input">
					<input id="login" name="login" type="text" value="<?= htmlspecialchars($user->name) ?>" placeholder="" required/>
					<label for="login">Login</label>
				</div>
				<h3><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></h3>
				<div>
					<input name="check" type="hidden" value="valid">
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="admin" name="admin" <?= $this->isRole("administrator", $user) ?>>
						<label class="custom-control-label" for="admin">Administrateur</label>
					</div>
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="modo" name="modo" <?= $this->isRole("moderator", $user) ?>>
						<label class="custom-control-label" for="modo">Modérateur</label>
					</div>
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="dev" name="dev" <?= $this->isRole("developer", $user) ?>>
						<label class="custom-control-label" for="dev">Développeur</label>
					</div>
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="redac" name="redac" <?= $this->isRole("redactor", $user) ?>>
						<label class="custom-control-label" for="redac">Rédacteur</label>
					</div>
					<div class="col-12 col-lg-4 text-center text-lg-right">
						<input class="btn sub-btn panel-btn" type="submit" value="Enregistrer" />
					</div>
				</div>
			</form>
		</div>
	<?php }

	private function isRole($str, $user) {
		if(in_array($str, $user->ranks))
			return "checked";
		else
			return "";
	}
}