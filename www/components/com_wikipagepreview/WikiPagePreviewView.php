<?php
namespace Component;

include_once "components/generic/View.php";

class WikiPagePreviewView extends View {

	public function generatePagePreview($page, $heading) { ?>
		<div class="position-relative text-center">
			<img class="w-100" src="<?= $page->img ?>" alt="<?= $page->title ?>">
			<?= "<$heading><a href='/wiki/page/$page->id' class='text-reset stretched-link'>$page->title</a></$heading>" ?>
		</div>
	<?php }
}