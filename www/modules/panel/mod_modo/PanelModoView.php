<?php
namespace Module;

use Utils;

class PanelModoView extends View {
	public function displayList($users, $count, $limit, $p, $sanctions) {
		Utils::addResource("<link href='/data/css/pagination.css' rel='stylesheet' />");
		Utils::addResource("<link href='/data/css/form.css' rel='stylesheet' />");
		$total = ceil($count / $limit); ?>
		<div class="container panel-body">
			<h2>Panel de modération</h2>
			<table class="w-100 custom-table">
				<thead>
					<tr>
						<th>Avatar</th>
						<th>ID</th>
						<th>Nom</th>
						<th>Date d'inscription</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $user) { ?>
						<tr>
							<td><img class="user-avatar" src="/data/img/avatar/<?= is_null($user->avatar) ? "default.png" : "$user->id-$user->avatar" ?>" alt="Avatar de <?= $user->name ?>" /></td>
							<td><?= htmlspecialchars($user->id) ?></td>
							<td><a href="/user/profile/<?= $user->login ?>" data-toggle="tooltip" title="Voir le profil de l'utilisateur" target="_blank"><?= htmlspecialchars($user->name) ?></a></td>
							<td><?= Utils::formatDate($user->joined_at) ?></td>
							<td class="important">
								<a href="#" class="badge badge-warning text-white" data-toggle="modal" data-target="#apply-santion-<?= $user->id ?>">Avertir</a>
								<a href="#" class="badge badge-danger text-white" data-toggle="modal" data-target="#apply-ban-<?= $user->id ?>">Bannir</a>
								<a href="#" class="badge sub-badge text-white" data-toggle="modal" data-target="#history-<?= $user->id ?>">Historique</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="navigation mt-4"></div>
			<?php foreach ($users as $user) { ?>
				<div id="apply-santion-<?= $user->id ?>" class="modal custom-modal fade" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h3 class="modal-title">Confirmer l'avertissement</h3>
								<button class="close" data-dismiss="modal"><span>&times;</span></button>
							</div>
							<div class="modal-body">
								Êtes-vous sûr de vouloir sanctionner "<?= htmlspecialchars($user->name) ?>" ? Cet avertissement sera permanent !
							</div>
							<div class="modal-footer">
								<form method="post" action="/panel/modo/warn/<?= $user->id ?>">
									<div class="custom-input-container">
										<div class="custom-input">
											<input id="reason-<?= $user->id ?>" name="reason" type="text" placeholder="" required />
											<label for="reason-<?= $user->id ?>">Raison</label>
										</div>
									</div>
									<div class="custom-input-container">
										<input class="btn main-btn small-btn" type="submit" value="Confirmer l'avertissement" />
									</div>
								</form>
								<button class="btn main-btn small-btn" data-dismiss="modal">Annuler</button>
							</div>
						</div>
					</div>
				</div>
				<div id="apply-ban-<?= $user->id ?>" class="modal custom-modal fade" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h3 class="modal-title">Confirmer le bannissement</h3>
								<button class="close" data-dismiss="modal"><span>&times;</span></button>
							</div>
							<div class="modal-body">
								Êtes-vous sûr de vouloir bannir "<?= htmlspecialchars($user->name) ?>" ? Cet avertissement sera permanent !
							</div>
							<div class="modal-footer">
								<form method="post" action="/panel/modo/ban/<?= $user->id ?>">
									<div class="custom-input-container">
										<div class="custom-input">
											<input id="reason-<?= $user->id ?>" name="reason" type="text" placeholder="" required />
											<label for="reason-<?= $user->id ?>">Raison</label>
										</div>
									</div>
									<div class="custom-input-container">
										<input class="btn main-btn small-btn" type="submit" value="Confirmer le bannissement" />
									</div>
								</form>
								<button class="btn main-btn small-btn" data-dismiss="modal">Annuler</button>
							</div>
						</div>
					</div>
				</div>
				<div id="history-<?= $user->id ?>" class="modal custom-modal fade">
					<div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h3 class="modal-title">Historique des sanctions de <?= $user->name ?></h3>
								<button class="close" data-dismiss="modal"><span>&times;</span></button>
							</div>
							<div class="modal-body">
								<?php $i = 0;
								foreach ($sanctions as $sanction) {
									if ($sanction->user == $user->id) {
										$i++; ?>
										<hr />
										<div>
											<?= $this->defineSanction($sanction->type) ?> Le <strong><?= Utils::formatDate($sanction->date) ?></strong> pour la raison : &laquo; <em><?= $sanction->reason ?></em> &raquo; par le modérateur <a class="inverted" href="/user/profile/<?= $sanction->mod_id ?>" target="_blank"><?= $sanction->mod_name ?></a>
										</div>
									<?php }
								}
								if ($i) { ?>
									<hr />
								<?php } else { ?>
									<div class="text-center">
										Cet utilisateur n'a reçu aucune sanction
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<script>
                Utils.pagination.show({
                    container: $(".navigation"),
                    pages: ["<?= implode('", "', range(1, $total)) ?>"],
                    callback: page => {
                        if (page.num <= 0 || page.num > <?= $total ?>)
                            return false;
                        window.location.href = `/panel/modo/home/${page.num}/<?= $limit ?>`;
                        return true;
                    },
                    defaultPage: <?= $p ?>,
                    triggerOnCreation: false,
                    ignoreWhenSelected: true,
                    customClass: "justify-content-center dark"
                });
			</script>
		</div>
	<?php }

	function defineSanction($sanction) {
		switch ($sanction) {
			case 1:
				return "<span class='badge badge-warning text-white'>Warn</span>";
			case 2:
				return "<span class='badge badge-danger'>Ban</span>";
			default:
				return "";
		}
	}
}