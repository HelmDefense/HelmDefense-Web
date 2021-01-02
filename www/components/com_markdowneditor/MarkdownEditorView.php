<?php
namespace Component;

use Utils;

include_once "components/generic/View.php";

class MarkdownEditorView extends View {
	private $firstEditor = true;

	public function displayEditor($element, $config) { ?>
			<script>
				/**
				 * @class SimpleMDE
				 * @const simplemde
				 * @type {Object<string, SimpleMDE>}
				 */
				<?php if ($this->firstEditor) echo "const simplemde = {};"; ?>
				let config = <?= Utils::toJSObject($config) ?>;
				let element = "<?= $element ?>";
				config.element = $(element)[0];
				simplemde[element] = new SimpleMDE(config);
			</script>
		<?php
		$this->firstEditor = false;
	}
}
