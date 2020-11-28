<?php
namespace Component;

include_once "components/generic/View.php";

class WikiPagePreviewView extends View {

	public function generateWikiPagePreview($imagePreview, $name) { ?>
		<div>
			<img src="/data/img/logo.png" alt="preview de page">
			<label>bonjour</label>
		</div>
	<?php }
}