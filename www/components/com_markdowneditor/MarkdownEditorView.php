<?php
namespace Component;

use Utils;

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
				config.previewRender = function(text, preview) {
					$.post(`${Utils.misc.API_URL}v1/markdown`, {text: text}, result => {
						$(preview).html(result.markdown);
						Prism.highlightAllUnder(preview, true);
					});
					return `<div style="height: ${preview.scrollHeight}px;">Chargement du Markdown...</div>`;
				};
				simplemde[element] = new SimpleMDE(config);
			</script>
		<?php
		$this->firstEditor = false;
	}
}
