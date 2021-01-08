<div class="d-flex align-items-center" style="min-height: calc(100vh - 200px);">
	<div class="mx-auto">
		<?php
		$id = Utils::get("id");
		if (is_null($id)) {
			echo Utils::renderComponent("forumpostlist", Utils::get("type", "topic"), Utils::get("limit"), Utils::get("offset"));
		} else {
			$topic = Utils::httpGetRequest("v1/forum/" . Utils::get("type", "topic") . "/$id");
			var_dump($topic);
		}
		?>
	</div>
</div>
