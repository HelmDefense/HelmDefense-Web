<?php
namespace Module;

use Utils;

class ForumPostView extends View {
	public function generateMessages($id, $post, $user) {
		Utils::addResource("<link href='/data/css/pagination.css' rel='stylesheet' />");
		Utils::addResource("<link href='/data/css/form.css' rel='stylesheet' />");
		$total = ceil($post->message_count / ForumPostController::LIMIT); ?>
		<div class="mx-5">
			<div id="messages">
				<?php foreach ($post->messages as $message) {
					$self = $message->author->id == $post->author->id; ?>
					<div class="msg d-flex my-4 position-relative">
						<img class="user-avatar mr-3" src="<?= $message->author->avatar ?>" alt="Avatar de <?= addslashes($message->author->name) ?>" />
						<div class="px-4 pt-3 pb-3 flex-fill forum-message<?php if ($self) echo " forum-message-self"; ?>">
							<div class="mb-1">
								<a class="font-weight-bold important<?php if (!$self) echo " dark"; ?>" href="/user/profile/<?= addslashes($message->author->id) ?>"><?= htmlspecialchars($message->author->name) ?></a>
								<span class="align-text-top badge <?= $self ? "main" : "sub" ?>-badge text-wrap d-none d-md-inline-block">
									<?= Utils::formatDate($message->created_at) ?>
									<?php if (property_exists($message, "edited_at")) echo " édité le " . Utils::formatDate($message->edited_at); ?>
								</span>
							</div>
							<?= Utils::markdown($message->content, !$self) ?>
							<?php if (!is_null($user) && $user->id == $message->author->id) { ?>
								<div class="position-absolute edit-btn" data-toggle="tooltip" title="Éditer le message">
									<img src="/data/img/edit-<?php if (!$self) echo "dark"; ?>.svg" alt="Éditer" data-toggle="modal" data-target="#msg-edit" data-msg-id="<?= $message->id ?>" />
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<div id="messages-nav"></div>
			<div id="msg-edit" class="modal custom-modal fade" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title">Modifier le message</h3>
							<button class="close" data-dismiss="modal"><span>&times;</span></button>
						</div>
						<div class="modal-body">
							<span class="important">Ancien message :</span>
							<div id="oldmessage" class="markdown"></div>
						</div>
						<div class="modal-footer">
							<form id="msg-edit-form" class="w-100" method="post" action="" data-require-captcha="#edit-message-container">
								<div id="edit-message-container"></div>
								<div class="markdown-editor-container markdown-editor-container-small m-0">
									<textarea id="newmessage" name="message" required></textarea>
									<label class="sr-only" for="newmessage">Message</label>
									<?= Utils::renderComponent("markdowneditor", "#newmessage", null, array("placeholder" => "Votre nouveau commentaire...")) ?>
								</div>
								<?= Utils::renderComponent("captcha", "d-flex justify-content-center custom-input-container") ?>
								<div class="text-center">
									<div class="custom-input-container pt-0">
										<input class="btn main-btn small-btn" type="submit" value="Confirmer la modification" />
									</div>
									<button class="btn main-btn small-btn" data-dismiss="modal">Annuler</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<script>
				const messages = $("#messages");
				Utils.pagination.show({
					container: $("#messages-nav"),
					pages: ["<?= implode('", "', range(1, $total)) ?>"],
					callback: page => {
						if (page.num <= 0 || page.num > <?= $post->message_count ?>)
							return false;
						let scroll = Utils.misc.jWindow.scrollTop();
						messages.html(`
							<div id="msg-load" class="d-flex justify-content-center">
								<div class="spinner-border m-5">
									<span class="sr-only">Chargement des messages...</span>
								</div>
							</div>
						`);
						Utils.ajax.getWithCache({
							url: "v1/forum/<?= $id ?>",
							data: {limit: <?= ForumPostController::LIMIT ?>, page: page.num},
							callback: data => {
								/**
								 * @var data
								 * @type {{
								 *     messages: {
								 *         id: number,
								 *         author: {
								 *             id: string,
								 *             name: string,
								 *             avatar: string,
								 *         },
								 *         content: string,
								 *         created_at: string,
								 *         [edited_at]: string
								 *     }[],
								 *     message_count: number
								 * }}
								 */
								$("#msg-load").remove();
								for (let [i, message] of data.messages.entries()) {
									let self = message.author.id === "<?= $post->author->id ?>";
									messages.append(`
											<div class="msg d-flex my-4 position-relative">
												<img class="user-avatar mr-3" src="${message.author.avatar}" alt="Avatar de ${message.author.name}" />
												<div class="px-4 pt-3 pb-3 flex-fill forum-message${self ? " forum-message-self" : ""}">
													<div class="mb-1">
														<a class="font-weight-bold important${self ? "" : " dark"}" href="/user/profile/${message.author.id}">${Utils.misc.escape(message.author.name)}</a>
														<span class="align-text-top badge ${self ? "main" : "sub"}-badge text-wrap d-none d-md-inline-block">
															${Utils.date.format(message.created_at)}
															${message.edited_at ? (" édité le " + Utils.date.format(message.edited_at)) : ""}
														</span>
													</div>
													<div id="msg-${i}" class="markdown${self ? "" : " inverted"}">
														<div class="d-flex justify-content-center">
															<div class="spinner-border m-3">
																<span class="sr-only">Chargement du message...</span>
															</div>
														</div>
													</div>
													${message.author.id === "<?= is_null($user) ? "" : $user->id ?>" ? `<div class="position-absolute edit-btn" data-toggle="tooltip" title="Éditer le message">
														<img src="/data/img/edit-${self ? "" : "dark"}.svg" alt="Éditer" data-toggle="modal" data-target="#msg-edit" data-msg-id="${message.id}" />
													</div>` : ""}
												</div>
											</div>
										`);
									$.post(`${Utils.misc.API_URL}v1/markdown`, {text: message.content}, result => {
										$(`#msg-${i}`).html(result.markdown);
										Utils.misc.jWindow.scrollTop(scroll);
									});
								}
								return data.message_count !== 0;
							},
							toApi: true
						});
						return true;
					},
					triggerOnCreation: false,
					ignoreWhenSelected: true,
					customClass: "justify-content-center dark"
				});

				const msgEditForm = $("#msg-edit-form");
				const oldMsg = $("#oldmessage");
				const newMsg = $("#newmessage");
				$("#msg-edit").on("show.bs.modal", e => {
					let id = e.relatedTarget.dataset.msgId;
					oldMsg.html(`
						<div class="d-flex justify-content-center">
							<div class="spinner-border m-4">
								<span class="sr-only">Chargement du message...</span>
							</div>
						</div>
					`);
					msgEditForm.attr("action", `/forum/post/edit/${id}`);
					Utils.ajax.getWithCache({
						url: `v1/forum/msg/${id}`,
						callback: data => {
							/**
							 * @var msg
							 * @type {{msg: string}}
							 */
							$.post(`${Utils.misc.API_URL}v1/markdown`, {text: data.msg}, result => oldMsg.html(result.markdown));
							simplemde["#newmessage"].value(data.msg);
							setTimeout(() => simplemde["#newmessage"].codemirror.refresh(), 200);
							return true;
						},
						toApi: true
					});
				});
			</script>
		</div>
		<?php if ($post->opened) {
			if (!is_null($user)) { ?>
				<form method="post" data-require-captcha>
					<div class="my-4 mx-5">
						<div id="message-container" class="no-avatar"></div>
						<div class="d-flex">
							<img class="user-avatar mr-3" src="<?= $user->avatar ?>" alt="Avatar de <?= addslashes($user->name) ?>" />
							<div class="flex-fill">
								<div class="markdown-editor-container markdown-editor-container-small m-0">
									<textarea id="message" name="message" required></textarea>
									<label class="sr-only" for="message">Message</label>
									<?= Utils::renderComponent("markdowneditor", "#message", null, array("placeholder" => "Votre commentaire...")) ?>
								</div>
							</div>
						</div>
						<div class="no-avatar">
							<?= Utils::renderComponent("captcha", "d-flex justify-content-center justify-content-lg-end custom-input-container") ?>
							<div class="custom-input-container text-center text-lg-right">
								<input class="btn sub-btn" type="submit" value="Commenter" />
							</div>
						</div>
					</div>
				</form>
			<?php } else { ?>
				<div class="my-4 mx-5 text-center">
					<p class="important">Connectez-vous pour commenter sur ce post</p>
					<a class="btn sub-btn" href="/user/login">Se connecter</a>
				</div>
			<?php }
		} else { ?>
			<div class="my-4 mx-5 text-center">
				<p class="important">Ce post a été fermé</p>
				<p>Vous ne pouvez plus le commenter</p>
			</div>
		<?php }
	}

	private $i = 0;
	public function displayRate($rate) {
		$this->i++; ?>
		<form class="d-inline-block align-middle">
			<div class="stars">
				<?php for ($i = 5; $i >= 1; $i--) { ?>
					<input id="<?= $this->i ?>-star-<?= $i ?>" class="star star-<?= $i ?>" type="radio" name="star" value="<?= $i ?>" disabled readonly <?php if ($i == $rate) echo "checked"; ?> />
					<label class="star star-<?= $i ?>" for="<?= $this->i ?>-star-<?= $i ?>"></label>
				<?php } ?>
			</div>
		</form>
	<?php }

	public function talk($id, $talk, $user) { ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-xl-9 pb-5">
					<h2><?= htmlspecialchars($talk->title) ?></h2>
					<?php $this->generateMessages("talk/$id", $talk, $user) ?>
				</div>
				<div class="col-12 col-xl-3 forum-sidebar-container">
					<?= Utils::renderComponent("forumsidebar") ?>
				</div>
			</div>
		</div>
	<?php }

	public function rate($id, $rate, $user) { ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-xl-9 pb-5">
					<h2><?= htmlspecialchars($rate->title) ?></h2>
					<div class="mx-5">
						<div class="no-avatar">
							<div class="row align-items-center text-center important mb-5">
								<div class="col-12 col-md-6 mb-2 d-flex justify-content-center align-items-center">
									<div class="position-relative">
										Entité : <a class="stretched-link" href="/wiki/page/entity/<?= $rate->entity->id ?>"><?= $rate->entity->name ?></a>
										<img class="user-avatar" src="<?= $rate->entity->image ?>" alt="<?= $rate->entity->name ?>" />
									</div>
								</div>
								<div class="col-12 col-md-6 mb-2 d-flex justify-content-center align-items-center">
									<div class="px-2 py-1">
										Note : <?php $this->displayRate($rate->rate); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php $this->generateMessages("rate/$id", $rate, $user) ?>
				</div>
				<div class="col-12 col-xl-3 forum-sidebar-container">
					<?= Utils::renderComponent("forumsidebar") ?>
				</div>
			</div>
		</div>
	<?php }

	public function strat($id, $strat, $user) { ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-xl-9 pb-5">
					<h2><?= htmlspecialchars($strat->title) ?></h2>
					<div class="mx-5">
						<div class="no-avatar">
							<div class="row text-center important mb-5">
								<div class="col-12 col-md-6 mb-2 d-flex justify-content-center align-items-center">
									<div class="position-relative">
										Niveau : <a class="stretched-link" href="/wiki/page/level/<?= $strat->level->id ?>"><?= $strat->level->name ?></a>
										<img class="user-avatar" src="<?= $strat->level->image ?>" alt="<?= $strat->level->name ?>" />
									</div>
								</div>
								<div class="col-12 col-md-6 mb-2 d-flex justify-content-center align-items-center">
									<div class="position-relative">
										Héros : <a class="stretched-link" href="/wiki/page/entity/<?= $strat->hero->id ?>"><?= $strat->hero->name ?></a>
										<img class="user-avatar" src="<?= $strat->hero->image ?>" alt="<?= $strat->hero->name ?>" />
									</div>
								</div>
							</div>
							<div id="entities" class="carousel slide" data-interval="false">
								<div class="carousel-inner">
									<div class="carousel-item active">
										<div class="d-flex flex-wrap justify-content-around">
											<?php
											$count = 0;
											foreach ($strat->entities as $stratEntity) {
												if ($count && $count % 4 == 0) { ?>
													</div></div><div class="carousel-item"><div class='d-flex flex-wrap justify-content-around'>
												<?php }
												$count++;
												?>
												<div class="text-center"><img src="<?= $stratEntity->entity->image ?>" alt="<?= $stratEntity->entity->name ?>" /><p class="entity-name font-weight-bold"><?= $stratEntity->entity->name ?></p><p>Nombre : <?= $stratEntity->count ?></p></div>
											<?php } ?>
										</div>
									</div>
								</div>
								<a class="carousel-control-prev" href="#entities" data-slide="prev">
									<span class="carousel-control-prev-icon"></span>
								</a>
								<a class="carousel-control-next" href="#entities" data-slide="next">
									<span class="carousel-control-next-icon"></span>
								</a>
							</div>
							<div id="rates" class="modal custom-modal fade">
								<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Avis sur la stratégie</h3>
											<button class="close" data-dismiss="modal"><span>&times;</span></button>
										</div>
										<div class="modal-body">
											<hr />
											<?php
											$rated = false;
											$userId = is_null($user) ? "" : $user->id;
											$sum = 0;
											$count = 0;
											foreach ($strat->ratings as $rating) {
												$sum += $rating->rate;
												$count++;
												if ($rating->user->id == $userId)
													$rated = true;
												?>
												<div class="d-flex">
													<img class="user-avatar mr-3" src="<?= $rating->user->avatar ?>" alt="<?= $rating->user->name ?>" />
													<div class="flex-fill">
														<a class="important font-weight-bold" href="/user/profile/<?= $rating->user->id ?>"><?= $rating->user->name ?></a>
														<?php $this->displayRate($rating->rate); ?>
														<span class="align-text-top badge main-badge text-wrap d-none d-lg-inline-block"><?= Utils::formatDate($rating->date) ?></span>
														<?= Utils::markdown($rating->comment) ?>
													</div>
												</div>
												<hr />
											<?php }
											if ($count) {
												$avg = $sum / $count;
											} else {
												$avg = 0; ?>
												<p class="text-center">Aucun avis sur la stratégie pour le moment</p>
												<hr />
											<?php } ?>
										</div>
										<div class="modal-footer">
											<h4>Laisser un commentaire et une note</h4>
											<?php if ($rated) { ?>
												<div class="my-4 mx-5 text-center">
													<p class="important">Vous avez déjà laissé votre avis</p>
													<p>Vous ne pouvez plus la noter</p>
												</div>
											<?php } else {
												if (is_null($user)) { ?>
													<div class="my-4 mx-5 text-center">
														<p class="important">Connectez-vous pour commenter sur ce post</p>
														<a class="btn main-btn" href="/user/login">Se connecter</a>
													</div>
												<?php } else { ?>
													<form class="w-100" method="post" action="/forum/post/strat/<?= $strat->id ?>/rating" data-require-captcha>
														<div class="markdown-editor-container markdown-editor-container-small mt-0">
															<textarea id="comment" name="comment"></textarea>
															<label class="sr-only" for="comment">Commentaire</label>
															<?= Utils::renderComponent("markdowneditor", "#comment", null, array("placeholder" => "Commentaire")) ?>
														</div>
														<div class="text-center">
															<span class="important">Votre note :</span>
															<div class="stars align-text-bottom">
																<input id="star-5" class="star star-5" type="radio" name="rate" value="5" required />
																<label class="star star-5" for="star-5"></label>
																<input id="star-4" class="star star-4" type="radio" name="rate" value="4" required />
																<label class="star star-4" for="star-4"></label>
																<input id="star-3" class="star star-3" type="radio" name="rate" value="3" required />
																<label class="star star-3" for="star-3"></label>
																<input id="star-2" class="star star-2" type="radio" name="rate" value="2" required />
																<label class="star star-2" for="star-2"></label>
																<input id="star-1" class="star star-1" type="radio" name="rate" value="1" required />
																<label class="star star-1" for="star-1"></label>
															</div>
															<?= Utils::renderComponent("captcha", "mt-3 d-flex justify-content-center") ?>
															<div class="custom-input-container">
																<input class="btn main-btn" type="submit" value="Noter" />
															</div>
														</div>
													</form>
												<?php }
											} ?>
										</div>
									</div>
								</div>
							</div>
							<div class="row align-items-center mt-3">
								<div class="col-12 col-lg-6 text-center text-lg-left">
									<button class="btn sub-btn small-btn" data-toggle="modal" data-target="#rates">
										<?= $avg ? ($count > 1 ? "Voir les $count avis" : "Voir l'avis") . " (" . round($avg, 2) . "/5)" : "Laisser un avis" ?>
									</button>
								</div>
								<div class="col-12 col-lg-6 text-center text-lg-right py-3">
									<span class="important">Note moyenne :</span>
									<?php $this->displayRate(round($avg)); ?>
								</div>
							</div>
						</div>
					</div>
					<?php $this->generateMessages("strat/$id", $strat, $user) ?>
				</div>
				<div class="col-12 col-xl-3 forum-sidebar-container">
					<?= Utils::renderComponent("forumsidebar") ?>
				</div>
			</div>
		</div>
	<?php }

	public function newTalk() {
		Utils::addResource("<link href='/data/css/form.css' rel='stylesheet' />"); ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-xl-9 pb-5">
					<div class="mx-5">
						<div id="message-container" class="mt-5"></div>
						<h2>Nouvelle discussion</h2>
						<form method="post" data-require-captcha>
							<div class="custom-input-container">
								<div class="custom-input">
									<input id="title" name="title" type="text" placeholder="" required />
									<label for="title">Titre</label>
								</div>
							</div>
							<div class="markdown-editor-container">
								<textarea id="message" name="message" required></textarea>
								<label class="sr-only" for="message">Message</label>
								<?= Utils::renderComponent("markdowneditor", "#message", null, array("placeholder" => "Message de la discussion...")) ?>
							</div>
							<?= Utils::renderComponent("captcha", "d-flex justify-content-center justify-content-lg-end custom-input-container") ?>
							<input type="hidden" name="check" value="valid" />
							<div class="custom-input-container text-center text-lg-right mb-4">
								<input class="btn sub-btn" type="submit" value="Publier" />
							</div>
						</form>
					</div>
				</div>
				<div class="col-12 col-xl-3 forum-sidebar-container">
					<?= Utils::renderComponent("forumsidebar") ?>
				</div>
			</div>
		</div>
	<?php }

	public function newRate($entities) {
		Utils::addResource("<link href='/data/css/form.css' rel='stylesheet' />"); ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-xl-9 pb-5">
					<div class="mx-5">
						<div id="message-container" class="mt-5"></div>
						<h2>Nouvel avis</h2>
						<form method="post" data-require-captcha>
							<div class="custom-input-container">
								<div class="custom-input">
									<input id="title" name="title" type="text" placeholder="" required />
									<label for="title">Titre</label>
								</div>
							</div>
							<div class="row">
								<div class="custom-input-container custom-input-container-inline col-12 col-lg-6">
									<select id="entity" name="entity" class="custom-select" required>
										<option value="" selected disabled readonly>Choisir une entité</option>
										<?php foreach ($entities as $entity) { ?>
											<option value="<?= $entity->id ?>"><?= htmlspecialchars($entity->name) ?></option>
										<?php } ?>
									</select>
									<label class="sr-only" for="entity">Entité</label>
								</div>
								<div class="custom-input-container custom-input-container-inline col-12 col-lg-6">
									<div class="text-center">
										<span class="important">Votre note :</span>
										<div class="stars align-text-bottom">
											<input id="star-5" class="star star-5" type="radio" name="rate" value="5" required />
											<label class="star star-5" for="star-5"></label>
											<input id="star-4" class="star star-4" type="radio" name="rate" value="4" required />
											<label class="star star-4" for="star-4"></label>
											<input id="star-3" class="star star-3" type="radio" name="rate" value="3" required />
											<label class="star star-3" for="star-3"></label>
											<input id="star-2" class="star star-2" type="radio" name="rate" value="2" required />
											<label class="star star-2" for="star-2"></label>
											<input id="star-1" class="star star-1" type="radio" name="rate" value="1" required />
											<label class="star star-1" for="star-1"></label>
										</div>
									</div>
								</div>
							</div>
							<div class="markdown-editor-container">
								<textarea id="message" name="message" required></textarea>
								<label class="sr-only" for="message">Message</label>
								<?= Utils::renderComponent("markdowneditor", "#message", null, array("placeholder" => "Message de la discussion...")) ?>
							</div>
							<?= Utils::renderComponent("captcha", "d-flex justify-content-center justify-content-lg-end custom-input-container") ?>
							<input type="hidden" name="check" value="valid" />
							<div class="custom-input-container text-center text-lg-right mb-4">
								<input class="btn sub-btn" type="submit" value="Publier" />
							</div>
						</form>
					</div>
				</div>
				<div class="col-12 col-xl-3 forum-sidebar-container">
					<?= Utils::renderComponent("forumsidebar") ?>
				</div>
			</div>
		</div>
	<?php }

	public function newStrat($heroes, $levels, $entities) {
		Utils::addResource("<link href='/data/css/form.css' rel='stylesheet' />"); ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-xl-9 pb-5">
					<div class="mx-5">
						<div id="message-container" class="mt-5"></div>
						<h2>Nouvelle stratégie</h2>
						<form method="post" data-require-captcha>
							<div class="custom-input-container">
								<div class="custom-input">
									<input id="title" name="title" type="text" placeholder="" required />
									<label for="title">Titre</label>
								</div>
							</div>
							<div class="row">
								<div class="custom-input-container custom-input-container-inline col-12 col-lg-6">
									<select id="hero" name="hero" class="custom-select" required>
										<option value="" selected disabled readonly>Choisir un héros</option>
										<?php foreach ($heroes as $hero) { ?>
											<option value="<?= $hero->id ?>"><?= htmlspecialchars($hero->name) ?></option>
										<?php } ?>
									</select>
									<label class="sr-only" for="hero">Héros</label>
								</div>
								<div class="custom-input-container custom-input-container-inline col-12 col-lg-6">
									<select id="level" name="level" class="custom-select" required>
										<option value="" selected disabled readonly>Choisir un niveau</option>
										<?php foreach ($levels as $level) { ?>
											<option value="<?= $level->id ?>"><?= htmlspecialchars($level->name) ?></option>
										<?php } ?>
									</select>
									<label class="sr-only" for="level">Niveau</label>
								</div>
							</div>
							<div id="entities"></div>
							<div class="text-center text-lg-left">
								<button id="new-entity" class="btn sub-btn">Autre entité</button>
							</div>
							<script>
								const entities = $("#entities");
								let i = 0;
								$("#new-entity").click(() => {
									i++;
									entities.append(`
										<div class="row">
											<div class="custom-input-container custom-input-container-inline col-12 col-lg-6">
												<select id="entity-${i}" name="entities[entity][]" class="custom-select" required>
													<option value="" selected disabled readonly>Choisir une entité</option>
													<?php foreach ($entities as $entity) { ?>
														<option class="entity" value="<?= $entity->id ?>"><?= htmlspecialchars($entity->name) ?></option>
													<?php } ?>
												</select>
												<label class="sr-only" for="entity-${i}">Entités</label>
											</div>
											<div class="custom-input-container custom-input-container-inline col-10 col-lg-4">
												<div class="custom-input">
													<input id="count-${i}" name="entities[count][]" type="number" min="1" max="100" placeholder="" required />
													<label for="count-${i}">Nombre</label>
												</div>
											</div>
											<div class="custom-input-container custom-input-container-inline col">
												<button class="btn sub-btn small-btn w-100" onclick="$(this).parents('.row').first().remove()">&times;</button>
											</div>
										</div>
									`);
								}).click();
							</script>
							<div class="markdown-editor-container">
								<textarea id="message" name="message" required></textarea>
								<label class="sr-only" for="message">Message</label>
								<?= Utils::renderComponent("markdowneditor", "#message", null, array("placeholder" => "Message de la discussion...")) ?>
							</div>
							<?= Utils::renderComponent("captcha", "d-flex justify-content-center justify-content-lg-end custom-input-container") ?>
							<input type="hidden" name="check" value="valid" />
							<div class="custom-input-container text-center text-lg-right mb-4">
								<input class="btn sub-btn" type="submit" value="Publier" />
							</div>
						</form>
					</div>
				</div>
				<div class="col-12 col-xl-3 forum-sidebar-container">
					<?= Utils::renderComponent("forumsidebar") ?>
				</div>
			</div>
		</div>
	<?php }

}
