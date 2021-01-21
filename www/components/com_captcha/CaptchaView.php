<?php
namespace Component;

class CaptchaView extends View {
	private static $catpchaId = 0;

	public function captcha($form, $sitekey, $classes) {
		self::$catpchaId++;
		if (self::$catpchaId == 1) { ?>
			<script>
				const captchaForm = {};
				function loadCaptcha() {
					for (let [form, i] of Object.entries(captchaForm)) {
						let id = grecaptcha.render(`captcha-${i}`, {
							sitekey: "<?= $sitekey ?>"
						});
						$(form).attr("data-captcha", id);
					}
				}
			</script>
		<?php } ?>
		<div id="captcha-<?= self::$catpchaId ?>" class="<?= $classes ?>"></div>
		<script>
			captchaForm["<?= $form ?>"] = <?= self::$catpchaId ?>;
		</script>
	<?php }
}
