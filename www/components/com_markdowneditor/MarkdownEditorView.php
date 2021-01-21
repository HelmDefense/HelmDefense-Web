<?php
namespace Component;

use Utils;

class MarkdownEditorView extends View {
	private static $firstEditor = true;

	public function displayEditor($element, $config) { ?>
			<script>
				/**
				 * @class SimpleMDE
				 * @const simplemde
				 * @type {Object<string, SimpleMDE>}
				 */
				<?php if (self::$firstEditor) echo "const simplemde = {}; let config; let element;"; ?>
				config = <?= Utils::toJSObject($config) ?>;
				element = "<?= $element ?>";
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
		self::$firstEditor = false;
	}
}
