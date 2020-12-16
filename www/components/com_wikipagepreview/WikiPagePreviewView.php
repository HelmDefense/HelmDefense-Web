<?php
namespace Component;

include_once "components/generic/View.php";

class WikiPagePreviewView extends View {
	public function generatePagePreview($page, $type, $heading) { ?>
		<div class="position-relative text-center wiki-pagepreview-container">
			<div class="page-image">
				<img class="w-100" src="<?= $page->img ?>" alt="<?= $page->title ?>">
			</div>
			<?= "<$heading class='page-title'><a href='/wiki/page/" . (is_null($type) || $type == "page" ? "" : "$type/") . "$page->id' class='text-reset stretched-link'>$page->title</a></$heading>" ?>
		</div>
	<?php }
}
