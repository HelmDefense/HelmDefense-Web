<?php
namespace Module;

class PanelHomeView extends View {
	public function panel($ranks) { ?>
		<div class="d-flex align-items-center panel">
			<div class="mx-auto text-center">
				<h2>Panel de contrôle</h2>
				<div class="panel-link">
				    <a class="btn sub-btn<?php if (!in_array("administrator", $ranks)) echo " disabled"; ?>" href="/panel/admin">Administration</a>
				</div>
				<div class="panel-link">
					<a class="btn sub-btn<?php if (!in_array("developer", $ranks)) echo " disabled"; ?> in-dev" href="/panel/dev">Développement</a>
				</div>
				<div class="panel-link">
				    <a class="btn sub-btn<?php if (!in_array("moderator", $ranks)) echo " disabled"; ?>" href="/panel/modo">Modération</a>
				</div>
				<div class="panel-link">
				    <a class="btn sub-btn<?php if (!in_array("redactor", $ranks)) echo " disabled"; ?>" href="/panel/redac">Rédaction</a>
				</div>
			</div>
		</div>
	<?php }
}
