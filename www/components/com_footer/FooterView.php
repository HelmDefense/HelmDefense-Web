<?php
namespace Component;

class FooterView extends View {
	public function generateFooter() { ?>
			<footer class="container-fluid">
				<div class="row h-100 d-flex align-items-center">
					<p class="col-12 col-lg-6 mb-0 text-center text-lg-left">Tous droits réservés &copy; <a href="/">Helm Defense</a> 2020</p>
					<p class="col-12 col-lg-6 mb-0 text-center text-lg-right"><a href="/api">Documentation API</a> &bull; <a href="/legal">Mentions légales</a></p>
				</div>
			</footer>
	<?php }
}
